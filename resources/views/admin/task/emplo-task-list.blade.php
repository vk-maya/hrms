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
                        <h3 class="page-title">Employees Task-list</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employees Task-list</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="department">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th class="text-end">Task</th>
                                <th class="text-end">Date</th>                              
                                <th class="text-end">Action</th>                           
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="text-end"><a href="{{ route('admin.employ.task.list', $item->id) }}">{{ $item->title }}</a>
                                </td>
                                <td class="text-end">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }} </td>
                                <td class="text-end"><a href="{{ route('admin.employ.task.list', $item->id) }}">
                                        View</a></td>
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