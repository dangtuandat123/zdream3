<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $images = $request->user()->generatedImages()
            ->with('style')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($images);
    }
}
