@extends('layouts.admin')

@section('content')

  <h1>{{ $fonction }} un rubrique</h1>

  @if (isset($rubrique))
    <!-- Le formulaire est géré par la route "rubriques.update" -->
    <form mpethod="POST" action="{{ route('rubriques.update', $rubrique) }}" enctype="multipart/form-data">
      <!-- <input type="hidden" name="_method" value="PUT"> -->
      @method('PUT')

  @else

    <!-- Le formulaire est géré par la route "rubriques.store" -->
    <form method="POST" action="{{ route('rubriques.store') }}" enctype="multipart/form-data" >

  @endif

      <!-- Le token CSRF -->
      @csrf

      <div class="mb-3">
        <label for="formControlTitre" class="form-label">Titre</label>
        <input class="form-control" name="titre" value="{{ isset($rubrique->titre) ? $rubrique->titre : '' }}" required id="formControlTitre" placeholder="titre de la rubrique">

        

      </div>

      
      <!-- S'il y a une image $rubrique->image, on l'affiche. -->
      @isset($rubrique)
        <label for="image">
        <div>Image actuelle</div>
        <img src="storage/{{ $rubrique->image }}" style="max-height:300px;">
        </label>
      @endisset

      <input type="file" name="image" id="image">


      <div class="d-grid gap-2 col-6 mx-auto">

        <button type="submit" class="btn btn-primary">Ajouter</button>

      </div>

    </form>

@endsection