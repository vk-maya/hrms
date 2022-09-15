@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
    <style>
        .file-cont-wrap {
            margin-left: 0px !important;
        }

        .zuned-img img {
            width: 100% !important;
            height: auto !important;
        }
    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            {{-- <div class="file-content-inner" style="margin-left:0px !important">
                <h4></h4>
            </div> --}}
            <div class="file-cont-header">
                <span>Upload Document</span>
                <div class="col-auto float-end ms-auto">
                    
                </div>
            </div>
            <div class="row">
                @if(count($files)>0)
                @foreach ($files as $file)
                    <div class="col-md-3">
                        <div class="dropdown-file">
                            <a href="#" class="dropdown-link" data-bs-toggle="dropdown"><i
                                    class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item">View
                                    Details</a>
                                <a href="#" class="dropdown-item">Share</a>
                                <a href="#" class="download dropdown-item"
                                    data-download="{{ asset('storage/file/' .$file->fileName) }}">
                                    Download</a>
                                <a href="" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <iframe src="{{ asset('storage/file/' . $file->fileName) }}" alt="" width="100%"height="auto"></iframe>
                        <div>
                            {{ $file->fileName}}
                        </div>
                    </div>
                @endforeach
                @else
                <h4>Document Not Upload</h4>
                @endif   
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
