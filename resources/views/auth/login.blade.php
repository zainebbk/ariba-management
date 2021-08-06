@extends('admin.layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="page">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <div class="text-white">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <h2 class="display-4 mb-2 font-weight-bold error-text text-center"><strong>Login</strong></h2>
                                        <h4 class="text-white-80 mb-7 text-center">Sign In to your account</h4>
                                        <div class="row">
                                            <div class="col-9 d-block mx-auto">
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                                </div>
                                                @error('email')
                                                <div class="row">
                                                    <div class="col-md-12 offset-md-2">
                                                        <div class="form-check-label" >
                                                            {{ $message}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @enderror

                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-lock"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required autocomplete="current-password" placeholder="Password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6 offset-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        
                                                            <label class="form-check-label" for="remember">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn  btn-secondary btn-block px-4">Login</button>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}" class="btn btn-link box-shadow-0 px-0 text-white-80">Forgot password?</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-flex align-items-center">
                        <img src="{{URL::asset('assets/images/png/login.png')}}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
