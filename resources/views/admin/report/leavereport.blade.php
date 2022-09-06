@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endpush
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Employee Salary </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Salary</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="" class="" role="">
            <div class="" role="">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{route('admin.employees.salary.generate')}}" method="POST">
                            @csrf
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="col-form-label">Select Month</label>
                                    <input type="month" class="form-control" name="month" value="">
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="col-form-label">Select Employees</label>
                                    <select class="select" name="user_id">
                                        <option value="{{$users}}">All</option>
                                        @foreach ($users as $user)
                                        <option @if (isset($id)&& $user->id == $id) selected @endif value="@if(isset($id)&& $user->id== $id) {{$id}} @else {{$user->id}}@endif">{{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 ">
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('plugin-js')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script>
    if (isset($dataedit)) {
        $("#add_salary").modal('show');
    }
</script>
@endpush