<?php

namespace App\Http\Controllers;

use App\Addpass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;



class AddpassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('addpass.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userOne = User::where('id', Auth::id())->first();
//        echo '<pre>';
//        print_r($userOne);
//        echo '</pre>';

        if ($request->password === $request->password_confirmation) {


            $userOne->password = Hash::make($request['password']);
            $userOne->save();
            $request->session()->flash('success_add_pass', "You add your pass!");

            return redirect('/home');

            } else {
                $request->session()->flash('confirm_pass', "Check your pass");
                return redirect('addpass/create');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Addpass  $addpass
     * @return \Illuminate\Http\Response
     */
    public function show(Addpass $addpass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Addpass  $addpass
     * @return \Illuminate\Http\Response
     */
    public function edit(Addpass $addpass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Addpass  $addpass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addpass $addpass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Addpass  $addpass
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addpass $addpass)
    {
        //
    }
}
