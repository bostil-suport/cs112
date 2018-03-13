<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        $news = Project::orderBy('id')->get();
        echo '<pre>';
        $userid = Auth::id();
        echo 'userId= ';
        print_r($userid);
        echo '</pre>';


        return view('project.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //нельзя незалогиненному
        echo '<pre>';
        $userid = Auth::id();
        echo 'userId= ';
        print_r($userid);
        echo '</pre>';
        $tags = Tag::pluck('name', 'id');
        echo '<pre>';
        print_r($tags);
        echo '</pre>';
//        echo '<pre>';
//        print_r($tags);
//        echo '</pre>';

//        die();
        return view('project.create', compact('userid', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //нельзя незалогиненному

//        dd($request->input('tags'));
        $project = new Project();
        $title = $request['title'];
        $description = $request['description'];
        $userid = $request['user_id'];


        $project->title = $title;
        $project->description = $description;
        $project->user_id = $userid;


        if (Auth::id() == $project->user_id) {

//            $dbTags = Tag::pluck('name', 'id')->toArray();

            $dbTags = Tag::all('id', 'name');
            $tags = [];
            foreach ($dbTags as $t) {
                //I've placed the name as the key in case of additional checking
                $tags[$t->name] = $t->id;
            }
            //$tags = $dbTags

            $receivedTags = $request->input('tag_list');
//            dump($tags, $receivedTags);

            $newTags = [];

            //Create any new tags
            foreach (array_diff($receivedTags, $tags) as $key => $t) {
                //I'm funny about using ::create() for no reason really
                $nt = new Tag();
                $nt->name = $t;
                $nt->save();
                $newTags[] = (string) $nt->id;
                unset($receivedTags[$key]);
            }
            $currentProjectTags = array_merge($receivedTags, $newTags);
//            dd($currentProjectTags);
            $project->save();
            $this->syncTags($project, $currentProjectTags);


/*

//            foreach ($receivedTags as $receivedTag) {
//                if (in_array($receivedTag, $tags)) {
//                    echo 'yes'.$receivedTag.'<br>';
//
//                } else {
//                    echo 'no'.$receivedTag.'<br>';
//                    $newTag = new Tag();
//                    $newTag->name = $receivedTag;
//                    $newTag->save();
//              }
//            }
/*
//            die();

//            foreach ($tags as $tag_key => $tag_value) {
////                echo $tag_key . ' => ' . $tag_value . '<br>';
//                if (is_numeric($tag_value) && Tag::where('id', $tag_value)->get()) {
//
//                    echo '<pre>';
//                    print_r(Tag::where('id', $tag_value)->get()->toArray());
//                    echo '</pre>';
//
//                }
//                else {
//echo $tag_value.'<br>';
//                    $newTag = new Tag();
//                    $newTag->name = $tag_value;
//                    $newTag->save();
////                    Tag::create(['name', $tag_value]); почему не работает????
////
//                    echo '<pre>';
//                    print_r(Tag::where('name', $tag_value)->get()->toArray());
//                    echo '</pre>';
//
//                }
//            }

*/
//            die();
//
//
//            $updatedTagList = Tag::pluck('name', 'id')->toArray();
//
//            foreach ($updatedTagList as $key => $value) {
//                if (in_array($value, $receivedTags)) {
//                    $arrayTags[] = $key;
//                }
//            }



            return redirect('/project/mylist');
        } else {
            $request->session()->flash('add_not_available', "You can add only your projects!");
            return redirect('/project/mylist');
        }


    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //нельзя незалогиненному

        //получить данные из бд по id
//        $project = Project::where('id', $id)->first();
        $id = Auth::id();
        echo 'userId= ';

        echo $id;
//        echo $project->user_id;

        if (Auth::id() == $project->user_id) {

            $tags = Tag::pluck('name', 'id');


            return view('project.edit', compact('project', 'tags'));
        } else {
            Session::flash('edit_not_available', "You can edit only your projects!");
            echo $id;
            echo $project->user_id;
            return redirect('/project/mylist');
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //нельзя незалогиненному

        $title = $request['title'];
        $description = $request['description'];
        $userid = $request['userid'];


        $project->title = $title;
        $project->description = $description;

        if (Auth::id() == $project->user_id) {

            $dbTags = Tag::all('id', 'name');
            $tags = [];
            foreach ($dbTags as $t) {
                //I've placed the name as the key in case of additional checking
                $tags[$t->name] = $t->id;
            }
            //$tags = $dbTags

            $receivedTags = $request->input('tag_list');
//            dump($tags, $receivedTags);

            $newTags = [];

            //Create any new tags
            foreach (array_diff($receivedTags, $tags) as $key => $t) {
                //I'm funny about using ::create() for no reason really
                $nt = new Tag();
                $nt->name = $t;
                $nt->save();
                $newTags[] = (string) $nt->id;
                unset($receivedTags[$key]);
            }
            $currentProjectTags = array_merge($receivedTags, $newTags);
//            dd($currentProjectTags);
            $project->save();
            $this->syncTags($project, $currentProjectTags);

//            $tags = Tag::pluck('name', 'id')->toArray();
//            $receivedTags = $request->input('tag_list');
//            dd($receivedTags, $tags);
//
//            foreach ($receivedTags as $receivedTag) {
//                if (array_key_exists($receivedTag, $tags)) {
//                    echo 'yes'.$receivedTag.'<br>';
//
//                } else {
//                    echo 'no'.$receivedTag.'<br>';
//                    $newTag = new Tag();
//                    $newTag->name = $receivedTag;
//                    $newTag->save();
//                    $var = $newTag->id;
//                }
//            }
//            /*
//            //            die();
//
//            //            foreach ($tags as $tag_key => $tag_value) {
//            ////                echo $tag_key . ' => ' . $tag_value . '<br>';
//            //                if (is_numeric($tag_value) && Tag::where('id', $tag_value)->get()) {
//            //
//            //                    echo '<pre>';
//            //                    print_r(Tag::where('id', $tag_value)->get()->toArray());
//            //                    echo '</pre>';
//            //
//            //                }
//            //                else {
//            //echo $tag_value.'<br>';
//            //                    $newTag = new Tag();
//            //                    $newTag->name = $tag_value;
//            //                    $newTag->save();
//            ////                    Tag::create(['name', $tag_value]); почему не работает????
//            ////
//            //                    echo '<pre>';
//            //                    print_r(Tag::where('name', $tag_value)->get()->toArray());
//            //                    echo '</pre>';
//            //
//            //                }
//            //            }
//
//            */
//            die();
////
//
//            $updatedTagList = Tag::pluck('name', 'id')->toArray();
//
//            foreach ($updatedTagList as $key => $value) {
//                if (in_array($value, $receivedTags)) {
//                    $arrayTags[] = $key;
//                }
//            }
//
//
//            $project->save();
//            $this->syncTags($project, $arrayTags);


            return redirect('/project/mylist');
        } else {
            $request->session()->flash('edit_not_available', "You can edit only your projects!");
            return redirect('/project/mylist');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */

    public function destroy(Project $project)
    {
        //нельзя незалогиненному

    }

    public function mylist()
    {
        //нельзя незалогиненному + отображение только своих проектов

        echo '<pre>';
        $userid = Auth::id();
        print_r($userid);
        echo '</pre>';

        $news = Project::orderBy('id')->where('user_id', $userid)->get();
        return view('mylist.index', compact('news'));


    }

    /**
     * Sync up the list of tags in the database.
     * @param Project $project
     * @param array $tags
     */
    public function syncTags(Project $project, array $tags): void
    {
        $project->tags()->sync($tags);
    }




}
