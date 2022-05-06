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
                        <h3 class="page-title">Task-View</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Daily Task-List</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="job-content job-widget">
                <small class="text-muted"> {{ \Carbon\Carbon::parse($dalilydata->created_at)->format('d/m/Y') }}</small>
                <hr>
                <small class="text-muted">Title</small>
                <div class="job-desc-title">
                    <h4>{{$dalilydata->title}}</h4>
                </div>
                <hr>
                <small class="text-muted">Description</small>
                <div class="">
                    <p>{!!$dalilydata->name!!}</p>
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
