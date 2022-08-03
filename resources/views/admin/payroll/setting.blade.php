@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    {{-- <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css"> --}}
@endpush
@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Company Settings</h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('admin.settings-store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contact Person</label>
                                    <input class="form-control" name="co_name" value=" @if(isset($setting[1]->description)) {{$setting[1]->description}} @endif" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Permanent Address</label>
                                    <input class="form-control" name="p_address" value=""
                                        type="text">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Curent Address</label>
                                    <input class="form-control" name="c_address" value=""
                                        type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="select" name="country" id="inputcountry"  onkeypress="country()">
                                        <option value="">Select Country</option>
                                        @foreach ($data as $item)
                                        <option  @if(isset($setting[3]->description) && $setting[3]->description == $item->id) selected @endif
                                            value="{{ $item->id }} {{ old('country') }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>State/Province</label>
                                    <select class="select" name="state" id="inputstate">
                                        <option value="" >Select State</option>
                                    </select>
                                    @isset($setting)
                                    <input type="hidden" value=" @if(isset($setting[4]->description)){{ $setting[4]->description }}@endif" id="EditState">
                                @endisset
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="select" name="city" id="inputcity">
                                        <option value="">Select City</option>
                                    </select>
                                    @isset($setting)
                                    <input type="hidden" value="@if(isset($setting[5]->description)){{ $setting[5]->description }}@endif" id="Editcity">
                                @endisset
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input class="form-control" name="postal" value="@if(isset($setting[6]->description)) {{$setting[6]->description}} @endif" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="email" value="@if (isset($setting[7]->description)){{$setting[7]->description}} @endif" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" name="number" value=" @if(isset($setting[8]->description)){{$setting[8]->description}} @endif" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Other Number</label>
                                    <input class="form-control" name="other_number" value=" @if(isset($setting[8]->description)){{$setting[8]->description}} @endif" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Website Url</label>
                                    <input class="form-control" name="web" value="" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // ------------shoe data table---------------
        $('#department').DataTable({
            paging: true,
            searching: true
        });

        function states() {
            var contid = document.getElementById("inputcountry");
            var id = $('#inputcountry').val();
            var url = "{{ route('admin.country.name') }}";
            $.ajax({
                url: url,
                type: "post",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    contid: id,
                },
                success: function(res) {
                    // console.log(state);
                    let data = '';
                    let selected = ''
                    $.each(res.state, function(key, val) {
                        if ($(document).find("#EditState").length > 0 && $("#EditState").val() == val
                            .id) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        data += '<option ' + selected + ' value="' + val.id + '">' + val.name +
                            '</option>';
                    });
                    $("#inputstate").html(data);
                    cities();
                }
            })
        }

        function cities() {
            var id = $("#inputstate").val();
            var url = "{{ route('admin.country.state.name') }}"
            $.ajax({
                type: "post",
                url: url,
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(res) {
                    var data = '';
                    var selected = ''
                    $.each(res.city, function(key, val) {
                        if ($(document).find("#Editcity").length > 0 && $("#Editcity").val() == val
                            .id) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        data += '<option ' + selected + ' value="' + val.id + '">' + val.name +
                            '</option>';
                    });
                    $("#inputcity").html(data);
                }
            });
        }
        states();
        document.getElementById("inputcountry").onchange = function() {
            states();
        };
        document.getElementById("inputstate").onchange = () => {
            cities();
        };
    </script>
@endpush
