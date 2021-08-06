@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            {{-- <h4 class="page-title mb-0">Show</h4> --}}
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update : cpc </h3>
                </div>
                <div class="card-body pb-2">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert"><button type="button" class="close"
                                data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('cpc-update',$cpc->id) }}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Information
                                </h3>
                            </div>

                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Cpc Model</label>
                                        <input type="text" class="form-control mb-4" value="{{ $cpc->Model }}"
                                            name='model' readonly>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Related Compte</label>
                                        <div class="col-md-12">
                                            <select multiple="multiple"
                                                onchange="console.log($(this).children(':selected').length)"
                                                class="search-box" name="bilans[]">
                                                @foreach ($bilans as $bilan)
                                                    <option value="{{ $bilan->num }}"
                                                        {{ $cpc_bilans->containsStrict('bilan_num', $bilan->num) ? 'selected' : '' }}>
                                                        {{ $bilan->num }} : {{ $bilan->compte }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if(count($cpc_bilans)>0)
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">List of Comptes</label>
                                        <div class="col-md-12 m-4 mr-7">
                                            @foreach ($bilans as $bilan)
                                                @if ($cpc_bilans->containsStrict("bilan_num", $bilan->num))
                                                    <span class="badge badge-danger-light"> {{ $bilan->num }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <input type="submit" value="Save" name="action" class="btn btn-primary mt-4 mb-0">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!--INTERNAL Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
@endsection
