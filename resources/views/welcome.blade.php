@extends('master')

@section('title', 'Willkomen')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <h2 style="text-align: center">Wilkommen in der Arbeitsstundenverwaltung <br/> des HC Niesky 1920 e.V.</h2>
        <div class="row">
            <img src="/images/logo.png" style="display: block; margin-left: auto; margin-right: auto">
        </div>
        <div class="row" style="margin-top: 50px">
            <div class="col-md-6">
                <label class="control-label">Bereits registriert? Dann hier anmelden:</label>
            </div>
            <div class="col-md-6">
                <label class="control-label">Noch nicht registriert? Dann bitte hier entlang:</label>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
                <a href="auth/login" class = "btn btn-primary btn-large" role="button">Anmelden</a>
            </div>
            <div class="col-md-6">
                <a class = "btn btn-success btn-large" href = "auth/register" role="button">Registrieren</a>
            </div>
        </div>
        <div class="row" style="margin-top: 40px">
            <h4 style="text-align: center">Empfohlene Browser: Mozilla Firefox oder Google Chrome</h4>
        </div>
    </div>
@endsection

