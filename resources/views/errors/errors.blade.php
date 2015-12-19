@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Da ist wohl was mit den Eingaben falsch!<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif