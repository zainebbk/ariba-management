@extends('admin.layouts.master3')
@section('css')
    <style>hr.divider:after {
            content: '';
            background: #beb6e2;
        }
    </style>
@endsection
@section('content')

    <div class="page">
        <div class="page-single">
            <div class="p-5">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-9">
                                <div class="card-group mb-0">
                                    <div class="card p-4">
                                        <div class="card-body mt-6">
                                            <div class="text-center title-style mb-7">
                                                <h1 class="mb-2" style="font-size: 45px;">Login</h1>

                                            </div>
                                            <div class="btn-list d-flex">
                                            </div>
                                            <hr class="divider my-6 mb-8">

                                            <h6 class="text-muted text-center mb-7">Sign In to your account</h6>
                                            @error('status')
                                            <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4"
                                                 role="alert">
                                                <strong>Whoops!</strong>
                                                <ul>
                                                    <li>{{ $message }}</li>

                                                </ul>
                                            </div>
                                            @enderror

                                            <form method="POST" action="{{route('vendor.login.post')}}">
                                                @csrf

                                                <div class="input-group mb-5">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="email" class="form-control" name="email"
                                                           value="{{ old('email') }}" autocomplete="email" required
                                                           autofocus placeholder="Email">
                                                </div>
                                                @error('email')
                                                <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4">
                                                    {{ $message}}
                                                </div>
                                                @enderror


                                                <div class="input-group mb-6">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-lock"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control" name="password"
                                                           value="{{ old('password') }}" required
                                                           autocomplete="current-password" placeholder="Password">
                                                </div>
                                                @error('password')
                                                <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4">
                                                    {{ $message}}
                                                </div>
                                                @enderror

                                                <div class="row mb-2 mt-4">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn  btn-primary btn-block px-4">
                                                            Login
                                                        </button>
                                                    </div>

                                                    <div class="col-12 text-center">
                                                        @if (Route::has('vendor.password.request'))
                                                            <a href="{{ route('vendor.password.request') }}"
                                                               class="btn btn-link box-shadow-0 px-0">Forgot
                                                                password?</a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="text-center pt-4 mb-8">
                                                    <div class="font-weight-normal fs-16">You Don't have an account <a
                                                            class="btn-link font-weight-normal"
                                                            href="{{route('vendor.register')}}">Register Here</a>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-none d-md-flex align-items-center bg-primary">
                                        <div class="text-center justify-content-center page-single-content ">
                                            <div class="box">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <img src="{{URL::asset('assets/images/png/login.png')}}" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
