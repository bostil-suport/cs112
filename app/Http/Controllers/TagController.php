<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Project;

class TagController extends Controller
{

    /**
     * Return tags name in tag_input with select2
     * @return \Illuminate\Http\JsonResponse
     */
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


    /**
     * Return project list with the current tag
     *
     * @param $tag_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function tagSearch($tag_name)
    {


        $tag = Tag::where('name', $tag_name)->first();
        if (!$tag) {
            return abort(404);
        }

        $projects = $tag->projects->toArray();



        if ($projects) {
            return view('project.tagprojects', compact('projects', 'tag_name'));
        }

        return view('project.tagprojects', compact( 'tag_name'));

    }

}
