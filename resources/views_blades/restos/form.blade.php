@extends('layouts.admin')

@section('content')
    
  <h1>{{ $fonction }} un restaurant</h1>

  <!-- Way 1: Display All Error Messages -->
  @if ($errors->any())
  <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
 @endif

  @if (isset($resto))
    <!-- Le formulaire est géré par la route "restos.update" -->
    <form mpethod="POST" action="{{ route('restos.update', $rubrique) }}" enctype="multipart/form-data">
      <!-- <input type="hidden" name="_method" value="PUT"> -->
      @method('PUT')

  @else

    <!-- Le formulaire est géré par la route "restos.store" -->
    <form method="POST" action="{{ route('restos.store') }}" enctype="multipart/form-data" >

  @endif

      <!-- Le token CSRF -->
      @csrf

      <div class="mb-3">
        <label for="formControlNom" class="form-label">Nom</label>
        <input class="form-control" name="nom" value="{{ isset($resto->nom) ? $resto->nom : '' }}" required id="formControlNom" placeholder="nom du restaurant">
      </div>

      <div class="mb-3">
        <label for="formControlTel" class="form-label">Tel</label>
        <input class="form-control" name="tel" value="{{ isset($resto->tel) ? $resto->tel : '' }}" id="formControlTel" placeholder="+123 456 123456" pattern="[+]{1}[0-9]{3} [0-9]{3} [0-9]{6}">
      </div>

      <div class="mb-3">
        <label for="formControlEmail" class="form-label">Email</label>
        <input class="form-control" name="email" value="{{ isset($resto->email) ? $resto->email : '' }}" id="formControlEmail" placeholder="email du restaurant">
      </div>

      <div class="mb-3">
        <label for="formControlAdresse" class="form-label">Adresse</label>
        <input class="form-control" name="adresse" value="{{ isset($resto->adresse) ? $resto->adresse : '' }}" id="formControlAdresse" placeholder="adresse du restaurant">
      </div>

      <div class="mb-3">
        <label for="formControlCommentaire" class="form-label">Commentaire</label>
        <textarea name="commentaire" id="formControlCommentaire" rows="3" class="form-control">{{ isset($resto->commentaire) ? $resto->commentaire : '' }}</textarea>        
      </div>

      <div class="mb-3">
        <label for="formControlDate" class="form-label">Abonnement <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
          <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
          <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        </svg></label>
        <div class="input-groupe date" id="datepicker">
          <input type="text" class="form-control" readonly="readonly" name="dt_abon" id="formControlDate" value="{{ isset($resto->dt_abon) ? $resto->dt_abon : '' }}">
          <span class="input-group-append"></span>
        </div>
      </div>

      <div class="form-check form-switch">
        <input name="actif" class="form-check-input" type="checkbox" role="switch" value="actif" id="flexSwitchCheckChecked"/>
        <label class="form-check-label" for="flexSwitchCheckChecked">Statut</label>
      </div>

      <div class="d-grid gap-2 col-6 mx-auto">

        <button type="submit" class="btn btn-primary">{{ $fonction }}</button>

      </div>


  </div> <!-- fin app -->

  <script type="text/javascript">
    $(function() {
      $('#datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose:true,
        language: 'fr',
        ignoreReadonly: true
      });
    });
  </script>

@endsection