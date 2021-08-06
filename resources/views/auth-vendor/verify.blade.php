@extends('admin.layouts.master-vendor')
@section('css')
@endsection
@section('content')
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center title-style mb-6">
                                            <h1 class="mb-2">Verify Your Email Address</h1>
                                            <hr>
                                            <p class="text-muted">Verify Your Email Address Page</p>
                                        </div>
                                        @if (session('resent'))
                                            <div class="alert alert-light-success" role="alert">
                                                {{ __('A fresh verification link has been sent to your email address.') }}
                                            </div>
                                        @endif
                                        <div class="text-center text-dark py-l-8 font-weight-normal fs-16 mb-4">
                                            {{ __('Before proceeding, please check your email for a verification link.') }}
                                            {{ __('If you did not receive the email') }}
                                        </div>
                                        <form class="d-inline" method="POST"
                                              action="{{ route('vendor.verification.resend') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn  btn-primary btn-block px-4"><i
                                                            class="fe fe-send"></i> {{ __('click here to request another') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
