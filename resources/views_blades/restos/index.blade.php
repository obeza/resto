@extends('layouts.admin')
@section('content')

  <h1>Liste des restos : </h1>
  <div id="appResto"></div>



  @vite('resources/js/app-restos.js')

@endsection