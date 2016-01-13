<p>Hallo {{$user->first_name}} {{$user->surname}},</p>
<p>am {{$date}} endet die Frist zur Ableistung der Arbeitsstunden. Dir fehlen aktuell noch {{$openWorkHours}} Stunden zum Erreichen des Ziels.</p>
<p>Unter <a href="stunden.hcniesky1920.de">stunden.hcniesky1920.de</a> kannst du deine geleisteten Stunden eintragen.</p>
@if($events != "")
<p>Bei den folgenden Events werden noch Helfer gesucht und können Arbeitsstunden abgeleistet werden:</p>
<p><strong>{{$events}}</strong></p>
@endif
<p>
    HC Niesky 1920 e.V.<br/>
    Arbeitsstundenverwaltung
</p>