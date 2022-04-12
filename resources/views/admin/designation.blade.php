@extends('admin.layouts.app')
@push('css')
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
            top: -6%;
            width: 1.5em;
            height: 1.5em;
            border: 1px solid #757575;
            border-radius: 4em;
            background: #ffffff;
        }

        .input-switch:checked~.label-switch::before {
            background: #00a900;
            border-color: #008e00;
            /* margin-top: 6px; */
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
    <div class="row mt-5">
        <div class="col-md-12 col-sm-6">
            <div class="card card-box">
                <div class="card-head">
                    <header>Designation Form</header>
                </div>
                <div class="card-body " id="bar-parent">
                    <form action="{{ route('admin.designation') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="Designationinput">Designation</label>
                            <input type="text" name="designation" class="form-control" id="Designationinput"
                                placeholder="Enter Designation">
                        </div>
                        <label for="statusinput">Status</label>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class='input-switch' type="checkbox" value="1" name="status" checked id="demo" />
                                <label class="label-switch" for="demo"></label>
                                <span class="info-text"></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
