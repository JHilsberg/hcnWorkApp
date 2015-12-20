@extends('master')

@section('title', 'Nutzer')

@section('content')
    @include('menu')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Nutzerverwaltung</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-3">Nachname</th>
                            <th class="col-md-3">Vorname</th>
                            <th class="col-md-3">Team</th>
                            <th class="col-md-3">Bestätiger</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->team->name}}</td>
                                @if($user->is_prover)
                                    <td>
                                        {!! Form::open(array('route' => array('user.update', 'id' => $user->id),
                                        'method' => 'put', 'style' => 'margin-bottom: 0px;')) !!}
                                        <label class="control-label col-md-4">ja</label>
                                        <button type="submit" class="btn btn-warning col-md-8">
                                            <span class="glyphicon glyphicon-remove-circle"></span> Recht entfernen
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td>
                                        {!! Form::open(array('route' => array('user.update', 'id' => $user->id),
                                        'method' => 'put', 'style' => 'margin-bottom: 0px;')) !!}
                                        <label class="control-label col-md-4">nein</label>
                                        <button type="submit" class="btn btn-success col-md-8">
                                            <span class="glyphicon glyphicon-ok-circle"></span> Recht hinzufügen
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection