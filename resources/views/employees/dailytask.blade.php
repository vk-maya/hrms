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
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Task</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Daily Task</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('employees.daily.task.store')}}" method="POST" >
                            <div class="row">
                                @csrf
                                <input type="hidden" name="user_id" id=""
                                    value="{{ Auth::guard('web')->user()->id }}">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputname">Task Title</label>
                                        <input id="InputTitle" name="title" value="" class="form-control" type="text">
                                        <span class="text-danger">
                                            @error('title')
                                            <p>The Title field is required</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputname">Date</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input readonly class="form-control" name="post_date"
                                                value="{{ \Carbon\Carbon::now('Asia/Kolkata')->format('d-m-Y') }}"
                                                type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="editor" name="description" cols="3" rows="2"></textarea>
                                    <span class="text-danger">
                                        @error('description')
                                            <p>The Description field is required</p>
                                        @enderror
                                    </span>
                                </div>
                                <div class="submit-section">
                                    <button id="submit" type="submit" class="btn btn-primary submit-btn">Submit</button>
                                </div>
                        </form>
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
