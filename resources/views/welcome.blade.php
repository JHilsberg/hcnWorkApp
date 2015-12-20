@extends('master')

@section('title', 'Willkomen')

@section('content')
    <div class="col-md-10 col-md-offset-1 col-xs-12">
        <h2 class="text-center">Wilkommen in der Arbeitsstunden-App <br/> des HC Niesky 1920 e.V.</h2>
        <div class="row">
            <img class="img-responsive center-block" src="/images/logo.png">
        </div>
        <div class="row" style="margin-top: 50px">
            <div class="col-md-6 col-xs-6">
                <label class="control-label">Bereits registriert? Dann hier anmelden:</label>
            </div>
            <div class="col-md-6 col-xs-6">
                <label class="control-label">Noch nicht registriert? Dann bitte hier entlang:</label>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-6 col-xs-6">
                @if(Auth::guest())
                    <a href="auth/login" class = "btn btn-primary btn-large" role="button">Anmelden</a>
                @else
                    <a href="newWork/create" class = "btn btn-primary btn-large" role="button">Anmelden</a>
                @endif
            </div>
            <div class="col-md-6 col-xs-6">
                <a class = "btn btn-success btn-large" href = "auth/register" role="button">Registrieren</a>
            </div>
        </div>
        <div class="row" style="margin-top: 40px">
            <h4 style="text-align: center">Empfohlene Browser: Mozilla Firefox oder Google Chrome</h4>
        </div>
    </div>
@endsection

