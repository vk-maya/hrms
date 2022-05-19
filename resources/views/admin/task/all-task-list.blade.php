@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employees Task-List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employees Task-List</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- {{$employees->dailyTask->orderBy('post_date','desc')->first()->post_date}} --}}
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="department">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th>Employees Name</th>
                                <th>Email</th>
                                <th>Task Status</th>
                                <th>Mobile Name</th>
                                <th>Designation</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{route('admin.emp.show-taskk',$item->id)}}">{{ $item->first_name }}</a></td>
                                    <td>{{ $item->email }}</td>
                                    <td>@isset($item->dailyTask()->orderBy('post_date','desc')->first()->post_date)
                                        @php
                                            $nowd =\Carbon\Carbon::now('Asia/Kolkata')->format('d-m-Y');
                                            $post =$item->dailyTask()->orderBy('post_date','desc')->first()->post_date;
                                        @endphp
                                        {{-- {{$nowd}} --}}
                                        @if ( == $nowd)
                                            
                                        {{"Submit"}}
                                        {{-- {{$item->dailyTask()->orderBy('post_date','desc')->first()->post_date}} --}}
                                        @else
                                        {{'No Date'}}
                                        @endif
                                    @endisset</td>
                                    <td>status{{ \Carbon\Carbon::now('Asia/Kolkata')->format('d-m-Y')}}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->designation->designation_name }}</td>
                                    <td class="text-end"><a href="{{route('admin.emp.show-taskk',$item->id)}}">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        // ------------shoe data table---------------
        $('#department').DataTable({
            paging: true,
            searching: true
        });
    </script>
@endpush
