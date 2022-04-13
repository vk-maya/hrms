@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <style>
        .input-switch {
            display: none;
        }

        .label-switch {
            display: inline-block;
            position: relative;
        }

        .label-switch::before,
        .label-switch::after {
            content: "";
            display: inline-block;
            cursor: pointer;
            transition: all 0.5s;
        }

        .label-switch::before {
            width: 3em;
            height: 1em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #888888;
        }

        .label-switch::after {
            position: absolute;
            left: 0;
            top: -12%;
            width: 1.5em;
            height: 1.5em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #ffffff;
        }

        .input-switch:checked~.label-switch::before {
            background: #00a900;
            border-color: #008e00;
            margin-top: 2px;
        }

        .input-switch:checked~.label-switch::after {
            left: unset;
            right: 0;
            background: #00ce00;
            border-color: #009a00;
            /* margin-top: 4px; */
        }

        .info-text {
            display: inline-block;
        }

        .info-text::before {
            content: "Not active";
        }

        .input-switch:checked~.info-text::before {
            content: "Active";
        }

    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Designation</a></li>
                            <li class="breadcrumb-item active">Designation</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Designation</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.designation') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="form-group">
                                        <label for="Designationinput">Designation</label>
                                        <input type="text" name="designation" class="form-control" id="Designationinput"
                                            placeholder="Enter Designation">
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group form-focus select-focus">
                                            <select class="select floating" name="department_id">
                                                <option>Select Department</option>
                                                @foreach ($department as $item)
                                                    <option value="{{ $item->id }}">{{ $item->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label class="focus-label">Department</label>
                                        </div>
                                    </div>
                                    <label for="statusinput">Status</label>
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class='input-switch' type="checkbox" value="1" name="status" checked
                                                id="demo" />
                                            <label class="label-switch" for="demo"></label>
                                            <span class="info-text"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
@endpush
