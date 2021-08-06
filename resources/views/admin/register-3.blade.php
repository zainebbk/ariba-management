@extends('admin.layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="page">
        <div class="page-single">
            <div class="p-5">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="col-lg-9 col-xl-8">
                                <div class="card-group mb-0">
                                    <div class="card p-4">
                                        <div class="card-body">

                                            <img src="{{URL::asset('assets/images/png/admin.png')}}" alt="img">

                                        </div>
                                    </div>
                                    <div class="card p-">
                                        <div class="card-body">

                                            <img src="{{URL::asset('assets/images/png/vendor.png')}}" alt="img">

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
