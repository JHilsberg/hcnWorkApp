@extends('master')

@section('title', 'Clubübersicht')

@section('content')
    @include('menu')

    <div class="col-md-12">
        @include('messages.messages')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Funktionen</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => array('club.mail'), 'method' => 'get', 'class' => 'form-horizontal')) !!}
                <div class="form-group">
                    <div class="form-group">
                        <label class="control-label col-md-5">Alle Nutzer mit offenen Stunden erinnern</label>
                        <div class="col-md-3 datepicker-container">
                            <div class='input-group date' data-provide="datepicker" data-date-format="dd.mm.yyyy"
                                 data-date-language="de" data-date-container=".datepicker-container">
                                <input readonly="true" class="form-control" name="date" value="{{ old('date') }}"
                                       placeholder="Enddatum auswählen">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-5">
                            <textarea class="form-control" rows="3" placeholder="Nächste Termine hinzufügen"
                                      name="events"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success col-md-3 col-md-offset-5">
                        Mail senden
                    </button>
                </div>
                {!! Form::close() !!}
                {!! Form::open(array('route' => array('club.export'), 'method' => 'get', 'class' => 'form-horizontal')) !!}
                <div class="form-group">
                    <label class="control-label col-md-5">Alle Nutzer mit offenen Stunden als .csv speichern</label>
                    <button type="submit" class="btn btn-success col-md-3">
                        Exportieren
                    </button>
                </div>
                {!! Form::close() !!}
                {!! Form::open(array('route' => array('club.setInactive'), 'method' => 'put','class' => 'form-horizontal',
                 'onsubmit' => 'return confirm("Alle aktuellen Arbeitsstunden auf inaktiv schalten?");')) !!}
                <div class="form-group">
                    <label class="control-label col-md-5">Alle aktuell geleisteten Stunden auf inaktiv ändern</label>
                    <button type="submit" class="btn btn-danger col-md-3">
                        Deaktivieren
                    </button>
                </div>
                {!! Form::close() !!}
                {!! Form::open(array('route' => array('club.exportPDF'), 'method' => 'get','class' => 'form-horizontal')) !!}
                <div class="form-group">
                    <label class="control-label col-md-5">Team-Stunden als PDF anzeigen</label>
                    <div class="col-md-3">
                        {!! Form::select('team',$teams, 1,['class' =>'form-control']) !!}
                    </div>
                    </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success col-md-3 col-md-offset-5">
                        Anzeigen
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Alle Mitglieder</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nachname</th>
                            <th>Vorname</th>
                            <th>Geleistete Stunden</th>
                            <th>Unbestätigte Stunden</th>
                            <th>Noch zu leistende Stunden</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="col-md-3">{{$user->surname}}</td>
                                <td class="col-md-3">{{$user->first_name}}</td>
                                <td class="col-md-2">{{$user->workActivities()->where('active', true)->where('proven', true)->sum('hours')}}</td>
                                <td class="col-md-2">{{$user->workActivities()->where('active', true)->where('proven', false)->sum('hours')}}</td>
                                @if(($sum = 10 - $user->workActivities()->where('active', true)->where('proven', true)->sum('hours')) < 0)
                                    <td class="col-md-2 success">{{$sum}}</td>
                                @else
                                    <td class="col-md-2 danger">{{$sum}}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Diagramme</h4>
            </div>
            <div class="panel-body">
                <div id="overview_chart"></div>
                @linechart('Overview', 'overview_chart')
            </div>
        </div>
    </div>
@endsection