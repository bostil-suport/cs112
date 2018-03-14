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


            $dbTags = Tag::all('id', 'name');
            $tags = [];
            foreach ($dbTags as $t) {
                //I've placed the name as the key in case of additional checking
                $tags[$t->name] = $t->id;
            }
            //$tags was $dbTags

            $receivedTags = $request->input('tag_list');
//            dump($tags, $receivedTags);

            $newTags = [];

            //Create any new tags
            foreach (array_diff($receivedTags, $tags) as $key => $t) {
                // ::create() don't work
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
            //it was $tags = it became $dbTags

            $receivedTags = $request->input('tag_list');
//            dump($tags, $receivedTags);

            $newTags = [];

            //Create any new tags
            foreach (array_diff($receivedTags, $tags) as $key => $t) {
                // ::create() not working
                $nt = new Tag();
                $nt->name = $t;
                $nt->save();
                $newTags[] = (string) $nt->id;
                unset($receivedTags[$key]);
            }
            $currentProjectTags = array_merge($receivedTags, $newTags);
            $project->save();
            $this->syncTags($project, $currentProjectTags);



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


    }

    /**
     * Return project list for the current user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mylist()
    {

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
