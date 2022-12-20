@extends('layouts.app')

@section('content')
<section class="user">
  <div class="user_options-container">
    <div class="user_options-text">
      <div class="user_options-unregistered">
        <h3 class="user_unregistered-title">¿No tienes cuenta?</h3>
        <p class="user_unregistered-text">Crea una cuenta de manera gratuita haciendo click en el botón de abajo.</p>
        <button class="user_unregistered-signup" id="signup-button">Sign up</button>
      </div>

      <div class="user_options-registered">
        <h3 class="user_registered-title">¿Ya tienes cuenta?</h3>
        <p class="user_registered-text">Accede con tus credenciales haciendo click en el botón de abajo.</p>
        <button class="user_registered-login" id="login-button">Login</button>
      </div>
    </div>
    
    <div class="user_options-forms" id="user_options-forms">
      <div class="user_forms-login">
        <h1>LOGIN</h1>
        <form method="POST" action="{{ route('login') }}" class="forms_form">
        @csrf
          <fieldset class="forms_fieldset">
            <div class="forms_field">
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('fields.Email Address') }}" class="forms_field-input form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus />
            </div>
            <div class="forms_field">
                <input id="password" name="password" type="password" placeholder="{{ __('fields.Password') }}" class="forms_field-input form-control @error('password') is-invalid @enderror" required autocomplete="current-password" />
            </div>
          </fieldset>
          <div class="forms_buttons">
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forms_buttons-forgot">
                    {{ __('fields.Forgot Your Password?') }}
                </a>
            @endif
            <button type="submit" class="btn btn-primary forms_buttons-action">
                {{ __('fields.Login') }}
            </button>
          </div>
        </form>
      </div>
      <div class="user_forms-signup">
        <h1>SIGN UP</h1>
        <form method="POST" action="{{ route('register') }}" class="forms_form">
        @csrf
          <fieldset class="forms_fieldset">
            <div class="forms_field">
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="{{ __('fields.Name') }}" class="forms_field-input form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus />
            </div>
            <div class="forms_field">
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('fields.Email Address') }}" class="forms_field-input form-control @error('email') is-invalid @enderror" required autocomplete="email" />
            </div>
            <div class="forms_field">
                <input id="password" name="password" type="password" placeholder="{{ __('fields.Password') }}" class="forms_field-input form-control @error('password') is-invalid @enderror" required autocomplete="new-password" />
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
          </fieldset>
          <div class="forms_buttons">
            <button type="submit" class="btn btn-primary forms_buttons-action">
                {{ __('fields.Register') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<style>
  body{
    overflow-x:scroll;
    overflow-x:hidden;
    overflow-y:hidden;
  }
</style>
<script>
    const signupButton = document.getElementById('signup-button'),
        loginButton = document.getElementById('login-button'),
        userForms = document.getElementById('user_options-forms')

    signupButton.addEventListener('click', () => {
    userForms.classList.remove('bounceRight')
    userForms.classList.add('bounceLeft')
    }, false)

    loginButton.addEventListener('click', () => {
    userForms.classList.remove('bounceLeft')
    userForms.classList.add('bounceRight')
    }, false)

</script>
@endsection