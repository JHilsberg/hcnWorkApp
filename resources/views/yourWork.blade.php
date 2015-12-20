@extends('master')

@section('title', 'Zusammenfassung')

@section('content')
    @include('menu')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Geleistete Arbeitsstunden von {{$user->first_name}} {{$user->surname}}</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Bereits geleiste Arbeitsstunden</label>
                    </div>
                    <div class="col-md-2">
                        <p>{{$work_activities->where('proven', 1)->sum('hours')}} Stunden</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Unbestätigte Arbeitsstunden</label>
                    </div>
                    <div class="col-md-2">
                        <p>{{$work_activities->where('proven', 0)->sum('hours')}} Stunden</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Noch zu leistende Stunden</label>
                    </div>
                    <div class="col-md-2">
                        @if($work_activities->where('proven', 1)->sum('hours') <= 10)
                            <p>{{10 - $work_activities->where('proven', 1)->sum('hours')}} Stunden</p>
                        @else
                            <p>0</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        @if($work_activities->where('proven', 1)->sum('hours') <= 10)
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     aria-valuenow="{{$work_activities->where('proven', 1)->sum('hours')}}"
                                     aria-valuemin="0" aria-valuemax="10"
                                     style="width:{{$work_activities->where('proven', 1)->sum('hours') / 10 * 100}}%;">
                                    {{$work_activities->where('proven', 1)->sum('hours')}} von 10
                                </div>
                            </div>
                        @else
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width:10%;">10
                                </div>
                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                     style="width:{{($work_activities->where('proven', 1)->sum('hours') -10)}}%;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Übersicht Arbeitsmaßnahmen</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Beschreibung</th>
                            <th>Datum</th>
                            <th>Geleistete Stunden</th>
                            <th>Bestätigt?</th>
                            <th>Bestätiger</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($work_activities as $work_activity)
                            <tr>
                                <td>{{$work_activity->description}}</td>
                                <td>{{date('d.m.Y', strtotime($work_activity->date))}}</td>
                                <td>{{$work_activity->hours}} Stunden</td>
                                <td>@if($work_activity->proven) ja @else nein @endif</td>
                                <td>{{$work_activity->prover->first_name}} {{$work_activity->prover->surname}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center"><h4>Keine eingetragenen Arbeiten</h4></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection

