@extends('admin.layouts.app')
@push('css')

@endpush
@section('content')
@php
$month = date('m');
if($month > 3){
$min_date = date('Y').'-04-01';
$max_date = date('Y', strtotime('+1 year')).'-03-31';
$year = date('Y').' - '.date('Y', strtotime('+1 year'));
}else{
$min_date = date('Y', strtotime('-1 year')).'-04-01';
$max_date = date('Y').'-03-31';
$year = date('Y', strtotime('-1 year')).' - '.date('Y');
}
@endphp
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Holidays {{$year}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holidays</li>
                    </ul>
                </div>
                <div class="col-auto ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="fa fa-plus"></i> Add Holiday</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table cus-table-striped custom-table mb-0 data-table-theme" id="holiday-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title </th>
                                <th>Holiday Date</th>
                                <th>Day</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=> $item)
                            <tr class="holiday-upcoming">
                                <td>{{$key+1}}</td>
                                <td>{{$item->holidayName}}</td>
                                <td>{{\Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                                <td>{{date("l",strtotime($item->date))}}</td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('admin.holiday.edit',$item->id)}}"><i class="fas fa-pencil me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="{{route('admin.holiday.delete',$item->id)}}"><i class="fas fa-trash-alt me-2"></i>Delete</a>
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
    <div class="modal custom-modal fade " id="add_holiday" role="dialog">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content show">
                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.holiday')}}" method="POST">
                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="id" value="@isset($holi){{$holi->id}}@endisset">
                        <div class="form-group">
                            <label>Holiday Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="@isset($holi){{$holi->holidayName}}@endisset">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Holiday Date <span class="text-danger">*</span></label>
                            <div><input class="form-control" type="date" name="date" value="@isset($holi){{$holi->date}}@endisset" min="{{$min_date}}" max="{{$max_date}}">
                                @error('date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section">
                        <button type="submit" class="btn add-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        @isset($holi)
        new bootstrap.Modal(document.getElementById('add_holiday')).show();
        @endisset
    });
</script>
@endpush