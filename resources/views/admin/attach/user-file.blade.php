@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <style>
        .file-cont-wrap {
            margin-left: 0px !important;
        }
    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="file-cont-wrap">
                            <div class="file-cont-inner">
                                <div class="file-cont-header">
                                    <span>File Manager</span>
                                    <div class="col-auto float-end ms-auto">
                                        <a href="" class="btn add-btn" data-bs-toggle="modal"
                                            data-bs-target="#add_policy"><i class="fa fa-paperclip"
                                                aria-hidden="true"></i>Attach Document</a>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($files as $file)
                                    <div class="col-md-3">
                                                <div class="card card-file">
                                                <div class="dropdown-file">
                                                    <a href="#" class="dropdown-link" data-bs-toggle="dropdown"><i
                                                            class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">                                                                                                            
                                                        <a href="#" class="download dropdown-item"
                                                        data-download="{{ asset('storage/file/' . $file->fileName) }}">
                                                        Download</a>
                                                        <a href="{{route('admin.fileattach.delete',$file->id)}}"class="dropdown-item">Delete</a>
                                                    </div>
                                                </div>
                                                {{-- <div class="row"> --}}
                                                <iframe src="{{ asset('storage/file/' . $file->fileName) }}"
                                                    alt="" width="100%"height="auto"></iframe>
                                                <div>

                                                    {{ $file->fileName }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add_policy" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Document</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.employees.attach.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            @if (isset($user))
                                
                        
                            <input type="hidden" name="user_id" value="{{ $user->id }}">    @endif
                            <label>Document Employees Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="first_name" type="text" value=" @if (isset($user)){{ $user->first_name }} @endif">
                        </div>
                        <div class="form-group">
                            <label>Upload Document <span class="text-danger">*</span></label>
                            <input name="files[]" class="form-control" value="" type="file" multiple>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </form>
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
        $(document).ready(function() {
            $(".download").on("click", function(e) {
                $(this).attr("href", $(this).data('download')).attr("download", $(this).data('download'))
                    .appendTo("body");
            });
        });
    </script>@endpush
