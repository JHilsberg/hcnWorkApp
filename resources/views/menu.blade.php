<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">HC Niesky</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li {!! (Request::is('newWork/create') ? 'class=active' : '') !!}><a href="{!! URL::route('newWork.create') !!}">Neue Stunden eintragen<span class="sr-only">(current)</span></a></li>
        <li {!! (Request::is('newWork') ? 'class=active' : '') !!}><a href="{!! URL::route('newWork.index') !!}">Deine Stundenübersicht<span class="sr-only">(current)</span></a></li>
        @if(Auth::user()->isProver())
        <li {!! (Request::is('proveWork') ? 'class=active' : '') !!}><a href="{!! URL::route('proveWork') !!}">Stunden bestätigen</a></li>
        @endif
        @if(Auth::user()->isAdmin())
          <li {!! (Request::is('user') ? 'class=active' : '') !!}><a href="{!! URL::route('user.index') !!}">Nutzerverwaltung</a></li>
          <li><a href="#">Vereinsübersicht</a></li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="/auth/logout">Abmelden</a></li>
      </ul>
    </div>
  </div>
</nav>