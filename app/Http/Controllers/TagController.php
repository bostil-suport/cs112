<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function api()
    {
        $input = request('q');
        $tags = Tag::where('name', 'like', $input.'%')
            ->orWhere('name', 'like', '% '.$input.'%')->get(
                ['name AS text', 'id']
            )->toArray();

        if ($input != '')
        {
            return response()->json([
                'results' => $tags
            ]);
        }
        else
        {
            return response()->json([
                'results' => ''
            ]);
        }
    }
}
