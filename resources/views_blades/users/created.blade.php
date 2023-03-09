@extends('layouts.admin')
@section('content')

  <div class="card">
    <div class="card-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
        </ol>
      </nav>
      <h3 class="user-title">Utilisateurs</h3>

      <div class="card">
        <div class="card-body">
          L'utilisateur a été créé. Il reçevra un email de confirmation qui lui permettra d'enregistrer son mot de passe.
        </div>
      </div>

    </div>
  </div>

  

@endsection