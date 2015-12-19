@extends('master')

@section('title', 'Bestätigen')

@section('content')
    @include('menu')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Alle Arbeitsstunden zum Bestätigen</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Mitglied</th>
                        <th>Beschreibung</th>
                        <th>Datum</th>
                        <th>Geleistete Stunden</th>
                        <th>Bestätigen</th>
                        <th>Ablehnen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($activities_to_prove as $activity)
                        <tr>
                            <td>{{$activity->user->first_name}} {{$activity->user->surname}}</td>
                            <td>{{$activity->description}}</td>
                            <td>{{date('d.m.Y', strtotime($activity->date))}}</td>
                            <td>{{$activity->hours}} Stunden</td>
                            <td><a href="#" class="btn btn-success" role="button">Bestätigen</a></td>
                            <td><a href="#" class="btn btn-warning" role="button">Ablehnen</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center"><h4>Keine zu bestätigenden Arbeiten</h4></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

