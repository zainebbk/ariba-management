@extends('admin.layouts.master3')
@section('css')
    <!-- INTERNAL Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet"/>

    <!-- INTERNAL Date Picker css -->
    <link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet"/>

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
                            <div class="col-lg-11 col-xl-10">
                                <div class="card-group mb-0">
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <form method="POST" action="{{route('vendor.register.post')}}">
                                                @csrf
                                                <div class="text-center title-style mb-6">
                                                    <h1 class="mb-2">Register</h1>
                                                </div>
                                                <div class="btn-list d-flex">
                                                </div>
                                                <hr class="divider my-6 mb-6">
                                                @if (count($errors) > 0)
                                                    <div class="bg-danger-transparent-2 text-danger px-4 py-2 br-3 mb-4"
                                                         role="alert">
                                                        <strong>Whoops!</strong> There were some problems with your input.
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                                           value="{{ old('firstname') }}" autocomplete="firstname"
                                                           @if (count($errors) == 0)  autofocus @endif placeholder="First Name *" spellcheck="false">
                                                </div>


                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                                           value="{{ old('lastname') }}"
                                                           autocomplete="lastname"  placeholder="Last Name *"  spellcheck="false">
                                                </div>


                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user-check"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name"
                                                           value="{{ old('display_name') }}" autocomplete="display_name"
                                                            placeholder="User Name *"  spellcheck="false">
                                                </div>


                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-mail"></i>
                                                        </div>
                                                    </div>
                                                    <input type="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                                           name="email"
                                                           autocomplete="email"  placeholder="Email *"  spellcheck="false">
                                                </div>


                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-phone"></i>
                                                        </div>
                                                    </div>
                                                    <input type="tel" class="form-control  @error('telephone') is-invalid @enderror"
                                                           placeholder="e.g.* +212687994523 or 0687994523" pattern="^(?:(?:\+|00)212|0)\s*[1-9](?:[\s.-]*\d{2}){4}$"
                                                           value="{{ old('telephone') }}" name="telephone"
                                                           autocomplete="telephone"  >
                                                </div>

                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control  @error('birthday') is-invalid @enderror" name="birthday"
                                                           value="{{ old('birthday') }}"
                                                           autocomplete="birthday" placeholder="Birthday Date *"  onfocus="(this.type='date')" onfocusout="(this.type='text')">
                                                </div>


                                                <div class="input-group mb-4" id="show_hide_password">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-lock"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror"
                                                           placeholder="Password *">
                                                           <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <a><i class="fe fe-eye-off"></i></a>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-briefcase"></i>
                                                        </div>
                                                    </div>
                                                    <select class="form-control" name="type">
                                                        <option value="Company" >Company</option>
                                                        <option value="Cooperative">Cooperative</option>
                                                        <option value="Individual" selected>Individual (vendor)</option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-4 change">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-layers"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="company" class="form-control change"
                                                           placeholder="Company Name *">
                                                </div>

                                                <div class="input-group mb-4 change">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-users"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="company_position" class="form-control change"
                                                           placeholder="Your Position*">
                                                </div>


                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="agree"/>
                                                        <span class="custom-control-label"><a
                                                                href="{{url('/' . $page='terms')}}" class="">Agree the  Terms and policy</a></span>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn  btn-primary btn-block px-4">
                                                            Create New Account
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                            <div class="text-center pt-4">
                                                <div class="font-weight-normal fs-16">You Already have an account <a
                                                        class="btn-link font-weight-normal"
                                                        href="{{route('vendor.login')}}">Login Here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none d-md-flex align-items-center bg-primary">
                                        <div class="text-center justify-content-center page-single-content">
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

    <!-- INTERNAL Datepicker js -->
    <script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    <!--INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <script>
          $('.change').css("display","none");
          $('select[name=type]').on('change', function() {
            if (this.value == "Company") {
                $('.change').css("display","flex");
            } else {
                $('.change').css("display","none");
            }
        });
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "fe-eye-off" );
                    $('#show_hide_password i').removeClass( "fe-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "fe-eye-off" );
                    $('#show_hide_password i').addClass( "fe-eye" );
                }
            });
        });

    </script>
  
@endsection
