@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Salary Settings</h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.salary.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Basic</label>
                                        <input class="form-control" name="basic_salary" value="@if(isset($salary[10]->description)){{$salary[10]->description}} @endif" id="BasicSalary" type="text">
                                        @error('basic_salary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault1" value="per"
                                                    id="flexRadioDefault1" @if (isset($salary[10]->type)){{$salary[10]->type == 'per' ? 'checked':''}}
                                                 @else checked @endif >
                                                <label class="form-check-label" for="flexRadioDefault1">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio"  name="flexRadioDefault1" value="fix"
                                                    id="fle" @if (isset($salary[10]->type)){{$salary[10]->type == 'fix' ? 'checked':''}}
                                                  @endif>
                                                <label class="form-check-label" for="fle"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>DA</label>
                                        <input class="form-control" name="da" id="Da" type="text" value="@if(isset($salary[11]->description)){{$salary[11]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault2" value="per"
                                                    id="flexRadioDefault2" @if (isset($salary[11]->type)){{$salary[11]->type == 'per'? 'checked':''}}
                                                   @else checked @endif>
                                                <label class="form-check-label" for="flexRadioDefault2">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault2"value="fix"
                                                    id="flex" @if (isset($salary[11]->type)){{$salary[11]->type == 'fix' ? 'checked':''}}
                                                        
                                                    @endif>
                                                <label class="form-check-label" for="flex"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>HRA</label>
                                        <input class="form-control" name="hra" id="Hra" type="text" 
                                        value="@if(isset($salary[12]->description)){{$salary[12]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault3" value="per"
                                                    id="flexRadioDefault3" @if (isset($salary[12]->type)){{$salary[12]->type == 'per' ? 'checked':''}}    
                                                    @else checked @endif>
                                                <label class="form-check-label" for="flexRadioDefault3">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault3"value="fix"
                                                    id="flexR" @if (isset($salary[12]->type)){{$salary[12]->type == 'fix' ? 'checked':''}}
                                                   @endif>
                                                <label class="form-check-label" for="flexR"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance</label>
                                        <input class="form-control" name="conveyance" id="Conveyance" type="text"
                                         value="@if(isset($salary[13]->description)){{$salary[13]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault4"value="per"
                                                    id="flexRadioDefault4" @if (isset($salary[13]->type)){{$salary[13]->type == 'per' ? 'checked':''}}
                                                    @else checked @endif>
                                                <label class="form-check-label" for="flexRadioDefault4">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault4"value="fix"
                                                    id="flexRa" @if (isset($salary[13]->type)){{$salary[13]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRa"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input class="form-control" name="allowance" id="Allowance" type="text"
                                        value="@if(isset($salary[14]->description)){{$salary[14]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault5"value="per"
                                                    id="flexRadioDefault5" @if (isset($salary[14]->type)){{$salary[14]->type == 'per' ? 'checked':''}}
                                                    @else checked  @endif>
                                                <label class="form-check-label" for="flexRadioDefault5">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault5"value="fix"
                                                    id="flexRad" @if (isset($salary[14]->type)){{$salary[14]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRad"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Medical Allowance</label>
                                        <input class="form-control" name="Medical_allow" id="Medical_allow" type="text"
                                        value="@if(isset($salary[15]->description)){{$salary[15]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault6"value="per"
                                                    id="flexRadioDefault6" @if (isset($salary[15]->type)){{$salary[15]->type == 'per' ? 'checked':''}}
                                                    @else checked  @endif>
                                                <label class="form-check-label" for="flexRadioDefault6">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault6"value="fix"
                                                    id="flexRadi"@if (isset($salary[15]->type)){{$salary[15]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadi"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>TDS</label>
                                        <input class="form-control" name="tds" id="Tds" type="text"
                                        value="@if(isset($salary[16]->description)){{$salary[16]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault7"value="per"
                                                    id="flexRadioDefault7" @if (isset($salary[16]->type)){{$salary[16]->type == 'per' ? 'checked':''}}
                                                    @else checked  @endif>
                                                <label class="form-check-label" for="flexRadioDefault7">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault7"value="fix"
                                                    id="flexRadio"@if (isset($salary[16]->type)){{$salary[16]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadio"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input class="form-control" name="est" id="Est" type="text"
                                        value="@if(isset($salary[17]->description)){{$salary[17]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault8"value="per"
                                                    id="flexRadioDefault8" @if (isset($salary[17]->type)){{$salary[17]->type == 'per' ? 'checked':''}}
                                                    @else checked   @endif>
                                                <label class="form-check-label" for="flexRadioDefault8">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault8"value="fix"
                                                    id="flexRadioD"@if (isset($salary[17]->type)){{$salary[17]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadioD"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>PF</label>
                                        <input class="form-control" name="pf" id="Pf" type="text"
                                        value="@if(isset($salary[18]->description)){{$salary[18]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault9"value="per"
                                                    id="flexRadioDefault9" @if (isset($salary[18]->type)){{$salary[18]->type == 'per' ? 'checked':''}}
                                                    @else checked  @endif>
                                                <label class="form-check-label" for="flexRadioDefault9">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault9"value="fix"
                                                    id="flexRadioDe"@if (isset($salary[18]->type)){{$salary[18]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadioDe"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Prof. Tax</label>
                                        <input class="form-control" name="Prof_tax" id="Prof_tax" type="text"
                                        value="@if(isset($salary[19]->description)){{$salary[19]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault10"value="per"
                                                    id="flexRadioDefault10" @if (isset($salary[19]->type)){{$salary[19]->type == 'per' ? 'checked':''}}
                                                    @else checked   @endif>
                                                <label class="form-check-label" for="flexRadioDefault10">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault10"value="fix"
                                                    id="flexRadioDef" @if (isset($salary[19]->type)){{$salary[19]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadioDef"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Labour Welfare</label>
                                        <input class="form-control" name="Labour_welf" id="Labour_welf" type="text"
                                        value="@if(isset($salary[20]->description)){{$salary[20]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault11"value="per"
                                                    id="flexRadioDefault11" @if (isset($salary[20]->type)){{$salary[20]->type == 'per' ? 'checked':''}}
                                                    @else checked   @endif>
                                                <label class="form-check-label" for="flexRadioDefault11">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault11"value="fix"
                                                    id="flexRadioDefa"@if (isset($salary[20]->type)){{$salary[20]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadioDefa"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Others</label>
                                        <input class="form-control" name="other" id="Other" type="text"
                                        value="@if(isset($salary[21]->description)){{$salary[21]->description}} @endif">
                                        <div class="row mt-1">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault12"value="per"
                                                    id="flexRadioDefault12" @if (isset($salary[21]->type)){{$salary[21]->type == 'per' ? 'checked':''}}
                                                    @else checked @endif>
                                                <label class="form-check-label" for="flexRadioDefault12">Percentage</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault12"value="fix"
                                                    id="flexRadioDefau"@if (isset($salary[21]->type)){{$salary[21]->type == 'fix' ? 'checked':''}}
                                                    @endif>
                                                <label class="form-check-label" for="flexRadioDefau"> Fix</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    
@endpush
