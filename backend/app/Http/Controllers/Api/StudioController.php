<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeneratedImage;
use App\Models\Style;
use App\Services\BflService;
use App\Services\StorageService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudioController extends Controller
{
    protected $bflService;
    protected $walletService;
    protected $storageService;

    public function __construct(
        BflService $bflService,
        WalletService $walletService,
        StorageService $storageService
    ) {
        $this->bflService = $bflService;
        $this->walletService = $walletService;
        $this->storageService = $storageService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'style_id' => 'required|exists:styles,id',
            'prompt' => 'nullable|string',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'aspect_ratio' => 'nullable|string',
        ]);

        $user = $request->user();
        $style = Style::findOrFail($request->style_id);

        // 1. Calculate Cost
        $estimatedCost = $style->price; // Or calculate based on params

        // 2. Check Balance
        if ($this->walletService->checkBalance($user) < $estimatedCost) {
            return response()->json(['message' => 'Insufficient credits'], 402);
        }

        // 3. Deduct Credits
        $this->walletService->deductCredits($user, $estimatedCost, "Generate image with style: {$style->name}");

        try {
            // 4. Prepare Payload
            $payload = [
                'prompt' => $style->base_prompt . ' ' . $request->prompt,
                // Add other params from style config or request
            ];
            
            if ($request->width && $request->height) {
                $payload['width'] = $request->width;
                $payload['height'] = $request->height;
            } elseif ($request->aspect_ratio) {
                $payload['aspect_ratio'] = $request->aspect_ratio;
            }

            // 5. Call BFL API
            // Assuming style->provider_model_id maps to BFL endpoint suffix or we have a mapping
            // For now, hardcode or use a mapping. Let's assume provider_model_id IS the endpoint suffix for simplicity
            // e.g., 'flux-pro-1.1' -> '/v1/flux-pro-1.1'
            $endpoint = '/v1/' . $style->provider_model_id; 
            
            $result = $this->bflService->createTask($endpoint, $payload);

            // 6. Save Record
            $image = GeneratedImage::create([
                'user_id' => $user->id,
                'style_id' => $style->id,
                'final_prompt' => $payload['prompt'],
                'selected_options' => $request->options,
                'user_custom_input' => $request->prompt,
                'generation_params' => $payload,
                'estimated_cost' => $estimatedCost,
                'provider_task_id' => $result['id'],
                'provider_polling_url' => $result['polling_url'],
                'status' => 'processing',
                'credits_used' => $estimatedCost,
            ]);

            return response()->json($image);

        } catch (\Exception $e) {
            // Refund on failure
            $this->walletService->refundCredits($user, $estimatedCost, "Refund: Generation failed");
            Log::error('Generation Failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Generation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function poll($id, Request $request)
    {
        $image = GeneratedImage::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        if ($image->status === 'completed' || $image->status === 'failed') {
            if ($image->status === 'completed') {
                 $image->url = $this->storageService->getUrl($image->storage_path);
            }
            return response()->json($image);
        }

        try {
            $result = $this->bflService->pollTask($image->provider_polling_url);

            if ($result['status'] === 'Ready') {
                // Download and Upload
                $content = $this->bflService->downloadResult($result['result']['sample']);
                $path = $this->storageService->uploadImage($content);

                $image->status = 'completed';
                $image->storage_path = $path;
                $image->save();
                
                $image->url = $this->storageService->getUrl($path);

            } elseif (in_array($result['status'], ['Failed', 'Error', 'Request Moderated', 'Content Moderated'])) {
                $image->status = 'failed';
                $image->error_message = $result['error'] ?? 'Unknown error';
                $image->save();

                // Refund
                $this->walletService->refundCredits($image->user, $image->credits_used, "Refund: Generation failed ({$image->status})");
            }
            // If Pending/Processing, do nothing

            return response()->json($image);

        } catch (\Exception $e) {
            Log::error('Poll Failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Poll failed'], 500);
        }
    }
}
