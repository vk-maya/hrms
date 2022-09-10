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
                <table class="table cus-table-striped custom-table mb-0 data-table-theme">
                    <thead>
                        <tr>
                            <th style="width: 30px;">SR</th>
                            <th>Employees Name</th>
                            <th>Designation</th>
                            <th>Task Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{route('admin.emp.show-taskk',$item->id)}}">{{ $item->first_name }}</a></td>
                            <td>{{ $item->designation->designation_name }}</td>
                            <td>@isset($item->dailyTask()->orderBy('post_date','desc')->first()->post_date)
                                @php
                                $nowd =\Carbon\Carbon::now()->format('d/m/Y');
                                $postdate =($item->dailyTask()->orderBy('post_date','desc')->first()->post_date);
                                $pdate =\Carbon\Carbon::parse($postdate)->format('d/m/Y')
                                @endphp
                                @if ($pdate == $nowd)
                                <i class="fa fa-check me-2 text-success"></i> <span class="yeh-data">Submit</span>
                                @else
                                <i class="fa fa-times me-2 text-danger"></i>No Submit
                                @endif
                                @else
                                <i class="fa fa-times me-2 text-danger"></i>No Submit

                                @endisset
                            </td>

                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="table-pencil" href="{{route('admin.emp.show-taskk',$item->id)}}">
                                            <!-- <button class="dropdown-item edit" data-id="1"><i class="fa fa-pencil me-2"></i>
                                                Edit</button> -->
                                            <i class="fa fa-pencil me-2"></i> Edit</a>
                                    </div>
                                </div>


                            </td>
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