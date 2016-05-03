<h2>Stundenübersicht - HC Niesky 1920</h2>
<table border="1">
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
    @foreach($membersOfTeam as $member)
        <tr>
            <td class="col-md-3">{{$member->surname}}</td>
            <td class="col-md-3">{{$member->first_name}}</td>
            <td class="col-md-2">{{$member->workActivities()->where('active', true)->where('proven', true)->sum('hours')}}</td>
            <td class="col-md-2">{{$member->workActivities()->where('active', true)->where('proven', false)->sum('hours')}}</td>
            @if(($sum = 10 - $member->workActivities()->where('active', true)->where('proven', true)->sum('hours')) < 0)
                <td class="col-md-2 success">{{$sum}}</td>
            @else
                <td class="col-md-2 danger">{{$sum}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>