@extends('layouts.admin')
@section('content')

  <div class="card">
    <div class="card-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="/users">Utilisateurs</a></li>
          <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
        </ol>
      </nav>
      <h3 class="user-title">Ajouter un utilisateur</h3>

    </div>
  </div>

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

  <form method="POST" action="{{ route('users.store') }}">
    @csrf
  <div class="card">
    <div class="card-body">
      <div class="row">
      <div class="col-12 col-sm-6 big-row-form">
        <div class="form-icon-container">
          <div class="form-floating">
            <input required class="form-control form-icon-input" id="prenom" type="text" placeholder="PRENOM" name="prenom"><label class="text-700 form-icon-label" for="prenom">PRENOM</label>
            <svg class="big-form-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path></svg>
          </div>
          
        </div>
      </div>
        <div class="col-12 col-sm-6 big-row-form">
          <div class="form-icon-container">
            <div class="form-floating">
              <input required class="form-control form-icon-input" id="nom" type="text" placeholder="NOM" name="nom"><label class="text-700 form-icon-label" for="nom">NOM</label>
              <svg class="big-form-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path></svg>
            </div>
            
          </div>
        </div>
        <div class="col-12 col-sm-6 big-row-form">
          <div class="form-icon-container">
            <div class="form-floating">
              <input required class="form-control form-icon-input" id="email" type="text" placeholder="EMAIL" name="email"><label class="text-700 form-icon-label" for="email">EMAIL</label>
              <svg class="big-form-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"></path></svg>
            </div>
            
          </div>
        </div>
        <div class="col-12 col-sm-6 big-row-form">
          <div class="input-group">


            <input class="form-control" id="tel" type="text" placeholder="prefixe" required maxlength="12" name="prefixe">
            <span class="input-group-text">TEL.</span>
            <input class="form-control form-icon-input" id="tel" type="text" placeholder="TELEPHONE" required maxlength="12" name="tel">
              

            
          </div>
        </div>



        <div class="d-grid gap-2 col-6 mx-auto">

            <button type="submit" class="btn btn-primary">Ajouter</button>

        </div>

      </div>
    </div>
  </div>
</form>

@endsection