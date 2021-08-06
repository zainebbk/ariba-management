<div class="e-panel card ">
    <div class="card-body zones">
        <div class="e-table">

            <div class="table-responsive table-lg mt-3">
                
                <table
                    class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                    id="example1">
                    <thead>
                        <tr>
                            <th class="wd-15p border-bottom-0">Region</th>
                            <th class="wd-15p border-bottom-0">Province</th>
                            <th class="wd-15p border-bottom-0">City</th>
                            <th class="wd-15p border-bottom-0">City Code</th>
                            <th class="wd-15p border-bottom-0">Street Name</th>
                            <th class="wd-15p border-bottom-0">Poste Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zones as $zone)
                            <tr>
                                <td>{{ $zone->region }}</td>
                                <td>{{ $zone->province }}</td>
                                <td>{{ $zone->ville }}</td>
                                <td>{{ $zone->ville_code }}</td>
                                <td>{{ $zone->quartier }}</td>
                                <td>{{ $zone->quartier_code }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              
                <style>
                    .dataTables_paginate{
                        display:none;
                    }
                    .dataTables_info{
                        display:none;
                    }
                </style>
                {!! $zones->appends(Request::capture()->except('page'))->render() !!}
            </div>
           
        </div>
    </div>
               
        
</div>

<!-- Jquery js-->
<script src="{{URL::asset('assets/js/jquery-3.5.1.min.js')}}"></script>

 <!--INTERNAL Select2 js -->
 <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
 <script src="{{ URL::asset('assets/js/select2.js') }}"></script>


