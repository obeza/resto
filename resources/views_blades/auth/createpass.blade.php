@extends('layouts.guest')
@section('content')

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          
          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required class="form-control form-control-lg"/>           
            
          </div>

          <!-- Password verif input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="password">Confirmation mot de passe</label>
            <input type="password" id="password2" name="password2" required class="form-control form-control-lg"/>           
            
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="#!" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" onclick="return Validate()">Se connecter</button>
            </div>
          </div>

        </form>
      </div>
      <div class="alert alert-danger" role="alert" id="passwordAlert">
        Les mots de passe doivent être identique.
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
  </div>
</section>

<script type="text/javascript">
  document.getElementById("passwordAlert").style.display = "none";
  function Validate() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("password2").value;
      if (password != confirmPassword) {
          //alert("Passwords do not match.");
          document.getElementById("passwordAlert").style.display = "block";
          document.getElementById("password2").classList.add("is-invalid")
          return false;
      }
      return true;
  }
</script>

@endsection