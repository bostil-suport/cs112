<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
        print_r($userid);
        echo '</pre>';


        return view('project.index',  compact('news'));
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
        print_r($userid);
        echo '</pre>';
        return view('project.create', compact('userid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //нельзя незалогиненному

        $title = $request['title'];
        $description = $request['description'];
        $userid = $request['userid'];

        $project = new Project();
        $project->title = $title;
        $project->description = $description;
        $project->user_id = $userid;

        if (Auth::id() == $project->user_id) {
            $project->save();
            return redirect('/project/mylist');
        } else {
            $request->session()->flash('add_not_available', "You can add only your projects!");
            return redirect('/project/mylist');
        }


        $project->save();

        return redirect('/project/mylist');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show',  compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //нельзя незалогиненному
//        echo $id;
//        print_r($project);

            $project = Project::where('id', $id)->first();



        //получить данные из бд по id

        return view('project.edit',  compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //нельзя незалогиненному

        $title = $request['title'];
        $description = $request['description'];
        $userid = $request['userid'];



        $projectOne = Project::find($project['id']);
        $projectOne->title = $title;
        $projectOne->description = $description;

        if (Auth::id() == $projectOne->user_id) {
            $projectOne->save();
            return redirect('/project/mylist');
        } else {
            $request->session()->flash('edit_not_available', "You can edit only your projects!");
            return redirect('/project/mylist');
        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
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

}
