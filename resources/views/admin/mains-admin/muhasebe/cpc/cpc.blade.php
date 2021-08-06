@extends('admin.layouts.master')
@section('css')

    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
@endsection
<div class="modal  fade" id="show" tabindex="-1" role="dialog" aria-labelledby="smallmodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodal1">Review Text</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('whitelist-add') }}" method='POST' role="form" enctype="multipart/form-data">
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
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <label class="col-md-12 form-label">Related Compte</label>
                                    <div class="col-md-12">
                                        <select multiple="multiple"
                                            onchange="console.log($(this).children(':selected').length)"
                                            class="form-control" name="bilans[]">
                                            @foreach ($bilans as $bilan)
                                                <option value="{{ $bilan->num }}"
                                                    {{ $cpc_bilans->contains('bilan_num', $bilan->num) ? 'selected' : '' }}>
                                                    {{ $bilan->num }} : {{ $bilan->compte }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                             @empty($cpc_bilans))
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <label class="col-md-12 form-label">List of Comptes</label>
                                    <div class="col-md-12 m-4 mr-7">
                                        @foreach ($bilans as $bilan)
                                            @if ($cpc_bilans->contains('bilan_num', $bilan->num))
                                                <span class="badge badge-danger-light"> {{ $bilan->num }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endempty
                        </div>
                    </div>

                    <div>
                        <input type="submit" value="Save" name="action" class="btn btn-primary mt-4 mb-0">
                    </div>
                </form>
            </div>
            <form id="form-review" action="" method="POST">
                @csrf
                <div class="modal-footer">
                    <button type="submit" id="approve" class="btn btn-success">Approve</button>
                    <button type="submit" id="disapprove" class="btn btn-danger">Disapprove</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('js')
    <!-- INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/date-picker/date-picker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <!-- INTERNAL File uploads js -->
    <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/file-upload.js') }}"></script>

@endsection
