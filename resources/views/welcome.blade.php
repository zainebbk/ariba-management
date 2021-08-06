@extends('admin.layouts.master2')
<style>
    body {
        background-image: none !important;
        background-color: transparent !important;
    }
</style>

@section('css')
@endsection
@section('content')
    <style>
        .welcome {
            --color: white;
            --position: center bottom;
            --width: 550px;
            --height: 7px;
            background: linear-gradient(var(--color), var(--color)) var(--position) / var(--width) var(--height) no-repeat;
            padding-bottom: 18px;
            letter-spacing: 2px;
            word-spacing: 3px;
        }


        /* Zoom In #1 */
        .hover01 figure img {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;
        }

        .hover01 figure:hover img {
            -webkit-transform: scale(1.1);
            padding-bottom: 5px;
            transform: scale(1.1);
        }
        .hoverme:hover  {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

    </style>
    <div class="page">
        <div class="page-single">
            <div class="p-5">
                <h2 class="display-2 font-weight-bold error-text text-center welcome" style="color: white;"><strong>WELCOME
                        TO ARIBA</strong></h2>
                <h4 class="text-white-80 mb-7 text-center" style="font-size: 26px;margin-top: 130px;">Are you a :</h4>
                <div class="row">
                    <div class="col mx-auto">
                        <div class="row justify-content-center">
                            <div class="card-body">

                                <div class="row mt-lg-5">
                                    <div class="col mr-9  ml-6 hover01">
                                        <a class="text-white-80"
                                           style="font-size:17px;letter-spacing:3px;font-weight:bold;font-family: 'Courier New', Courier, monospace"
                                           href="{{route("login")}}">
                                            <figure><img src="{{URL::asset('assets/images/png/admin.png')}}"
                                                         style="max-width: 80%" alt="img"></figure>
                                            <div class="text-center mt-2 mr-6 hoverme">ADMIN</div>
                                        </a>
                                    </div>

                                    <div class="col ml-6 hover01">
                                        <a class="text-white-80"
                                           style="font-size:17px;letter-spacing:3px;font-weight:bold;font-family: 'Courier New', Courier, monospace"
                                           href="{{route("vendor.login")}}">
                                            <figure><img src="{{URL::asset('assets/images/png/vendor.png')}}"
                                                         style="max-width: 80%" alt="img"></figure>
                                            <div class="text-center mt-2 mr-6 hoverme" id="vendor" >VENDOR</div>
                                        </a>
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
