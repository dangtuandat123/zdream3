<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Style;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    public function index(Request $request)
    {
        $query = Style::with(['tag', 'options'])
            ->where('is_active', true)
            ->orderBy('sort_order');

        if ($request->has('tag_id')) {
            $query->where('tag_id', $request->tag_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $style = Style::with(['tag', 'options'])->findOrFail($id);
        return response()->json($style);
    }
}
