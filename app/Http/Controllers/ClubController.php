<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\WorkActivity;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Session;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Team $team)
    {
        $this->getOverviewChart();

        $allUsers = User::all()->sortBy('surname');
        $allTeams = $team->getAllTeams();

        return view('clubOverview', ['users' => $allUsers, 'teams' => $allTeams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getOverviewChart(){
        $clubOverviewChart = \Lava::DataTable();

        $clubOverviewChart->addDateColumn('Date');

        foreach(Team::all()->sortBy('name') as $team){
            $clubOverviewChart->addNumberColumn($team->name);
        }

        $date = Carbon::today()->subYear();

        while($date <= Carbon::today()){
            $clubOverviewChart->addRow([$date, $this->getWorkingHoursForTeamAndDate('Damen', $date),
                $this->getWorkingHoursForTeamAndDate('Herren', $date), $this->getWorkingHoursForTeamAndDate('Senioren', $date)]);

            $date = $date->addWeeks(2);
        }

        \Lava::LineChart('Overview')
            ->dataTable($clubOverviewChart)
            ->title('Stundenübersicht nach Team, Zeitraum 1 Jahr, Intervall 2 Wochen')
            ->setOptions(array(
                'legend' => \Lava::Legend(array(
                    'position' => 'in'
                ))));
    }

    private function getTeamsChart(){
        $teamHoursDataTable = \Lava::DataTable();

        foreach(Team::all()->sortBy('name') as $team){
            $teamHoursDataTable->addNumberColumn($team->name);
        }

        foreach(Team::all() as $team){
            $teamHoursDataTable->addRow([$team->workActivities()->sum('hours')]);
        }

        \Lava::LineChart('Overview')
            ->dataTable($clubOverviewChart)
            ->title('Stundenübersicht nach Team, Zeitraum 1 Jahr, Intervall 2 Wochen')
            ->setOptions(array(
                'legend' => \Lava::Legend(array(
                    'position' => 'in'
                ))));

    }

    private function getWorkingHoursForTeamAndDate($teamName, $date){

        $allUsersOfTeam = User::whereHas('team', function($query) use ($teamName){
            $query->where('name', 'like', $teamName);
        })->get();

        $workingHoursOfTeam = 0;

        foreach($allUsersOfTeam as $user){
            $workingHoursOfTeam = $workingHoursOfTeam + $user->workActivities()->where('active', true)->where('proven', true)
                    ->whereDate('date', '<=', $date)->sum('hours');
        }

        return $workingHoursOfTeam;
    }

    public function export(){
        $users = User::whereHas('workActivities', function($query){
            $query->where('active', '=', true)->havingRaw('sum(hours) < 10');
        })->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['Nachname', 'Vorname', 'offene Arbeitsstunden']);

        foreach($users as $user){
            $openHours = 10 - $user->workActivities()->sum('hours');
            $csv->insertOne([$user->surname, $user->first_name, str_replace('.', ',', $openHours)]);
        }

        $usersWithoutWork = \DB::table('users')
            ->leftJoin('work_activities', 'users.id', '=', 'work_activities.user_id')
            ->select('surname', 'first_name')->whereNull('work_activities.id')->get();

        foreach($usersWithoutWork as $user){
            $csv->insertOne([$user->surname, $user->first_name, 10]);
        }

        $today = Carbon::today()->toDateString();

        $csv->output('offeneArbeitsstunden-'.$today.'.csv');
    }

    public function setAllHoursOnInactive(){
        WorkActivity::where('active', '=', true)->update(['active' => 0]);

        Session::flash('message', "Alle Stunden auf inaktiv geändert!");
        return back();
    }

    public function sendMailToUsers(){

        $users = User::whereHas('workActivities', function($query){
            $query->where('active', '=', true)->havingRaw('sum(hours) < 10');
        })->get();

        $endDate = Input::get('date');
        $events = Input::get('events');

        foreach($users as $user) {
            $openWorkHours = 10 - $user->workActivities()->sum('hours');

            Mail::send('emails.userReminder', ['user' => $user, 'openWorkHours' => $openWorkHours, 'date' => $endDate,
            'events' => $events],
                function ($m) use ($user) {
                    $m->from('stunden-app@hcniesky1920.de', 'HC Niesky Arbeitsstundenverwaltung');
                    $m->to($user->email)->subject('Dir fehlen noch Arbeitsstunden!');
                }
            );
        }

        Session::flash('message', "Mails wurden gesendet!");
        return back();
    }

    public function generateTeamPDF(PDF $pdfCreator, Team $team){
        $team = $team::find(Input::get('team'));
        $membersOfTeam = $team->users()->get();
        $pdf = $pdfCreator->loadView('pdf.teamHours', compact('membersOfTeam'));

        return $pdf->stream('Arbeitsstunden');
    }
}
