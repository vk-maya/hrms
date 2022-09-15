@extends('layouts.app')
@push('css')
 
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <h3 class="page-title">Task-View</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Daily Task-List</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
            <div class="job-content job-widget-inner">
                <small class="text-muted"> {{ \Carbon\Carbon::parse($dalilydata->post_date)->format('d/m/Y') }}</small>
                <hr>
                <small class="text-muted">Title</small>
                <div class="job-desc-title">
                    <h4>{{$dalilydata->title}}</h4>
                </div>
                <hr>
                <small class="text-muted">Description</small>
                <div class="">
                    {!!$dalilydata->description!!}
                </div>                       
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@push('plugin-js') 
@endpush
