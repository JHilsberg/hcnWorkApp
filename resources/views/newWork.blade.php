@extends('master')

@section('title', 'Neue Arbeitsstunden')

@section('content')
    @include('menu')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Geleistete Arbeitsstunden für {!! Auth::user()->first_name !!} {!! Auth::user()->surname !!} eintragen</h4>
            </div>
            <div class="panel-body">
                @include('errors.errors')
                @include('messages.messages')
                {!! Form::open(array('route' => 'newWork.store', 'class' => 'form-horizontal')) !!}
                <div class="form-group">
                    <label class="col-md-4 control-label">Datum der Arbeitsmaßname</label>
                    <div class="col-md-6 datepicker-container">
                        <div class='input-group date' data-provide="datepicker" data-date-format="dd.mm.yyyy"
                             data-date-language="de" data-date-today-highlight="true"
                             data-date-container=".datepicker-container" data-date-end-date="today">
                            <input readonly="true" class="form-control" name="date" value="{{ old('date') }}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Beschreibung der Arbeitsmaßnahme</label>
                    <div class="col-md-6">
                        <input class="form-control" name="description" value="{{ old('description') }}" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Bestätiger</label>
                    <div class="col-md-6">
                        {!! Form::select('prover_id', $provers, null, array('class'=>'form-control', 'name' => 'prover_id')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4" style="text-align: right">
                        <label class="control-label">Geleistete Arbeitsstunden</label>
                        <p class="help-block">Eintragbar in Halbstunden-Schritten<br/> Bsp: 1,0 oder 3,5<br/>Minimal: 0,5 Maximal 9</p>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" name="hours" type="number" max="9" min="0.5" step="0.5" maxlength="2" value="{{ old('hours')}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        {!! Form::submit('Speichern', array('class' => 'btn btn-success')) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection