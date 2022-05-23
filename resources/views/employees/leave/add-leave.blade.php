@extends('layouts.app')
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
                    <h3 class="page-title">Leaves</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Request Leave</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('employees.store.leave')}}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id}}">
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" name="type_id">
                                    <option value=""> Select Leave Type</option>
                                    @foreach ($data as $item)                                        
                                    <option value="{{$item->id}}">{{$item->type}}</option>                                 
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>From <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control" name="from" type="date">
                                        </div> 
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>To <span class="text-danger">*</span></label>
                                        <div class="">
                                            <input class="form-control " name="to" type="date">
                                        </div>
                                    </div>   
                                </div>
                               
                                        

                            </div>
                                         
                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea name="reason" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
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

@endpush
