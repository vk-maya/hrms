@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Task List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Task-List</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 data-table-theme">
                        <thead>
                            <tr>
                                <th style="width: 30px;">SR</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ route('employees.show-taskk', $item->id) }}">{{ $item->title }}</a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->post_date)->format('d/m/Y') }} </td>
                                    <td class="text-center"><a class="btn add-btn" href="{{ route('employees.show-taskk', $item->id) }}">
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
@endpush
