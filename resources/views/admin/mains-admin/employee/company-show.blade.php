@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Show Company</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Show Company</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <style>
        .card-header:before {
            content: none;
        }

        .table.details-table td,
        .table.details-table th {
            // border-top: none;
            padding: .3rem;
        }

        .table.details-table td {
            //  color: #000000;
            font-weight: bold;
        }

        img {
            max-width: 98%;
        }

    </style>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-status card-status-left bg-purple-dark br-bl-7 br-tl-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Company Details</h3>
                    <div class="card-options">
                        <a href="{{ url('/' . ($page = '#')) }}" class="card-options-fullscreen mr-2"
                            data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table details-table">
                        <tbody>
                            <tr>
                                <th class="border-0" scope="row">Company Name</th>
                                <td class="border-0">{{ $company->name }} </td>
                            </tr>
                            <tr>
                                <th>Company Address 1</th>
                                <td>{{ $company->address1 }} {{ $company->city }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Phone</th>
                                <td>{{ $company->phone }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Owner</th>
                                <td>{{ $company->owner }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Owner Email</th>
                                <td>{{ $company->ownerEmail }} </td>
                            </tr>

                            <tr>
                                <th scope="row">Owner Phone</th>
                                <td>{{ $company->ownerPhone }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Note</th>
                                <td>{{ $company->note }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Date Added</th>
                                <td>{{ $company->date_added }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Employees</th>
                                <td><a href="/admin/employee/{{ $company->e_id }}">{{ $company->e_firstname }}
                                        {{ $company->e_lastname }} </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Location (With Address) </th>
                                <td><a href={{ $maplink }} target="blank">click here </a></td>
                            </tr>
                            <tr>
                                <th scope="row">Location (With Coordinations) </th>
                                <td><a href={{ $maplink2 }} target="blank">click here </a></td>
                            </tr>
                            <tr>
                                <th scope="row">Images </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-group p-5">
                        @foreach ($images as $image)

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card shadow-none border border-right-30 overflow-hidden">
                                    <a download="{{ $image->link }}" href="https://ariba.ma/image/{{ $image->link }}"
                                        target="_blank" title=" ImageName" blank>
                                        <img src="https://ariba.ma/image/{{ $image->link }}" alt="image"
                                            class="card-image1 ">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title">Date Added :</h5>
                                        <p class="card-text"><small class="text-muted">{{ $image->date_added }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
@endsection
