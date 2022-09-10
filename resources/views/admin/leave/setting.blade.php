@extends('admin.layouts.app')
@push('css')
@endpush
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leave Settings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Settings</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{route('admin.add-leave-type')}}" class="btn add-btn"><i class="fa fa-plus"></i>
                        Add Leave Type</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table cus-table-striped custom-table mb-0 data-table-theme">
                    <thead>
                        <tr>
                            <th style="width: 30px;">SR</th>
                            <th>Type</th>
                            <th>Days (Yearly)</th>
                            <th>Days (Monthly)</th>
                            <th>Carry Forward</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->type}}</td>
                            <td>{{$item->day}}</td>
                            <td>{{$item->day/12}}</td>
                            <td>{{$item->carryfordward==null?'No':$item->carryfordward}}</td>
                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('admin.edit-leave-type',$item->id)}}"><i class="fa fa-pencil me-2"></i> Edit</a>
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
@endpush