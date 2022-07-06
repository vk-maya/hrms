@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
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
                                    <span>Uplad Document</span>
                                </div>
                                <div class="file-content">
                                    <div class="file-body">
                                        <div class="file-scroll">
                                            <div class="file-content-inner" style="margin-left:0px !important">
                                                <h4>Upload Document</h4>
                                                <div class="row row-sm">
                                                    @foreach ($files as $file)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="card card-file">
                                                                <div class="dropdown-file">
                                                                    <a href="#" class="dropdown-link"
                                                                        data-bs-toggle="dropdown"><i
                                                                            class="fa fa-ellipsis-v"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a href="#" class="dropdown-item">View
                                                                            Details</a>
                                                                        <a href="#" class="dropdown-item">Share</a>
                                                                        <a href="#" class="download dropdown-item"
                                                                            data-download="{{ asset('storage/file/' . $file->fileName) }}">
                                                                            Download</a>
                                                                        <a href="#" class="dropdown-item">Rename</a>
                                                                        <a href="{{ route('employees.employees.delete', $file->id) }}"
                                                                            class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </div>
                                                                <div class="images">&times;
                                                                    <iframe src="{{ asset('storage/file/' . $file->fileName) }}" alt="" width="300" height="200"></iframe>
                                                                     
                                                                    </div>
                                                                    
                                                                    <div id="image-viewer">
                                                                      <span class="close">&times;</span>
                                                                      <iframe class="modal-content" id="full-image"></iframe>
                                                                    </div>
                                                                {{-- <div class="card-file-thumb">
                                                                    <iframe
                                                                        src="{{ asset('storage/file/' . $file->fileName) }}"
                                                                        class="img-thumbnail" alt=""></iframe>
                                                                </div> --}}
                                                                <div class="card-body">
                                                                    <span>12mb</span>
                                                                    <h6><a href="#">{{ $file->fileName }}</a></h6>
                                                                </div>
                                                                <div class="card-footer">{{ $file->created_at }}</div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".download").on("click", function(e) {
                $(this).attr("href", $(this).data('download')).attr("download", $(this).data('download'))
                    .appendTo("body");
            });
        });
    </script>
@endpush
