@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Leave Type</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Leave Type</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.store-leave-type') }}" method="POST" id="form">
                            <div class="row">
                                @csrf
                                @if ($leave!=NULL)
                                    <input type="hidden" name="id" value="{{$leave->id}}">
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputname">Title</label>
                                        <input id="InputTitle" name="type" value="{{($leave==NULL)?old('type'):$leave->type}}" required
                                            class="form-control" type="text">
                                        <span class="text-danger">
                                            @error('type')
                                                <p>{{$message}}</p>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputname">Days (Yearly)</label>
                                    <div class="form-group">
                                        <input class="form-control" required name="day" type="number" id="days" value="{{($leave==NULL)?old('days'):$leave->day}}">
                                        <span id="monthly">{{($leave==NULL)?old('days'):'Monthly - '.$leave->day/12}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputname">CarryForward (Monthly)</label>
                                    <div class="form-group">
                                        <input class="form-control" name="carryfordward" type="number" value="{{($leave==NULL)?old('carryfordward'):$leave->carryfordward}}">
                                    </div>
                                </div>

                                <div class="submit-section">
                                    <button id="submit" type="submit" class="btn btn-primary submit-btn">Submit</button>
                                </div>
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        $("#days").change(function(){
            var days = $(this).val()/12;
            if (days >= 1) {
                $("#monthly").html('Monthly - '+days);
                $("#monthly").show();
            }else{
                $("#monthly").html('');
                $("#monthly").hide();
            }
        });
    </script>
@endpush
