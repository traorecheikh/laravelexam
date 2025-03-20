@extends('layouts.app')

@section('content')

    <link href="{{asset('login.css')}}" rel="stylesheet">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Bon retour chez ISI BURGER</h1>
                <p>Connectez-vous pour continuer votre bouffe</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('Adresse E-mail') }}</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Mot de passe') }}</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                        </div>
                        @error('password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group remember-checkbox">
                        <div class="custom-checkbox">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">{{ __('Se souvenir de moi') }}</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-login">
                            {{ __('Se connecter') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="login-footer">
                <p>Pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>
@endsection
