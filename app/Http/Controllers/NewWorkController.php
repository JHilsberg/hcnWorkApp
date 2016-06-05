<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkActivityRequest;
use App\User;
use App\WorkActivity;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class NewWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $work_activities = $user->workActivities()->where('active', true)->orderBy('date', 'desc')->get();
        return view('yourWork', ['user' => $user, 'work_activities' => $work_activities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $users)
    {
        $provers = $users->getAllProvers();
        return view('newWork', ['provers' => $provers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkActivityRequest $request)
    {
        $workActivity = new WorkActivity();

        $workActivity->user_id = Auth::user()->id;
        $workActivity->active = true;
        $workActivity->proven = false;

        $workActivity->date = date('Y-m-d', strtotime($request->date));
        $workActivity->description = $request->description;
        $workActivity->prover_id = $request->prover_id;
        $workActivity->hours = $request->hours;

        $workActivity->save();

        $prover = User::find($request->prover_id);
        $worker = Auth::user();

        Mail::send('emails.newWorkToProve', ['worker' => $worker, 'prover' => $prover], function ($m) use ($prover) {
            $m->from('stunden-app@hcniesky1920.de', 'HC Niesky Arbeitsstundenverwaltung');
            $m->to($prover->email)->subject('Neue Arbeitsstunden bestätigen!');
        });


        Session::flash('message', "Daten erfolgreich gespeichert");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $workActivity = WorkActivity::find($id);
        $workActivity->proven = true;

        $workActivity->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WorkActivity::destroy($id);

        return back();
    }

    public function showProveWorkActivities()
    {
        $activities_to_prove = Auth::user()->proveWorkActivities()->where('proven', false)->where('active', true)->orderBy('date', 'desc')->get();
        return view('proveWork', ['activities_to_prove' => $activities_to_prove]);
    }

    public function bisectHours()
    {
        $workActivity = WorkActivity::find(Input::get('id'));
        $originalHours = $workActivity->hours;
        $workActivity->hours = $originalHours/2;
        $workActivity->save();
        return back();
    }
}
