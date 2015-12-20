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
                <div class="table-responsive">
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
                                <td>
                                    {!! Form::open(array('route' => array('newWork.update', 'id' => $activity->id),
                                    'method' => 'put', 'style' => 'margin-bottom: 0px;')) !!}
                                    {!! Form::submit('Bestätigen', array('class' => 'btn btn-success center-block')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                    {!! Form::open(array('route' => array('newWork.destroy', 'id' => $activity->id),
                                    'method' => 'delete', 'style' => 'margin-bottom: 0px;')) !!}
                                    {!! Form::submit('Ablehnen', array('class' => 'btn btn-warning center-block')) !!}
                                    {!! Form::close() !!}
                                </td>
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
    </div>
@endsection

