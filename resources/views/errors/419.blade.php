@extends('admin.layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="page">
        <div class="page-content">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <div class="text-white">
                                <div class="display-1 error-text mb-5 font-weight-bold"> 419</div>
                                <h1 class="h3  mb-3 font-weight-bold">Sorry, your session has expired. </h1>
                                <p class="h5 font-weight-normal mb-7 leading-normal">Please refresh and try again.</p>
                                <a class="btn btn-secondary" href="{{ url('/' . ($page = 'login')) }}"><i
                                        class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-flex align-items-center">
                        <img src="{{ URL::asset('assets/images/png/e1.png') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
