@extends('admin.layouts.app')
@push('css')
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
                            <li class="breadcrumb-item active">
                                Task-View
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="job-content job-widget">
                <div class="job-desc-title">
                    <small class="text-muted"> {{ \Carbon\Carbon::parse($data->post_date)->format('d/m/Y') }}</small>
                    <hr>    
                    <small class="text-muted">Title</small>
                    <h3>{{ $data->title }}</h3>
                </div>
                <hr>
                <small class="text-muted">Description</small>
                <div class="">
                    <p>{!! $data->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
