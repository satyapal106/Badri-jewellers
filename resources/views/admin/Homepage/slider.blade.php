@extends('layout.master')

@section('body')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Upload Slider Image </h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Slider</li>
        </ul>
    </div>
    <div class="row gy-4">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('success_msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session('success_msg') }}</strong>
                </div>
            @endif
            @if (Session::has('error_msg'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ Session('error_msg') }}</strong>
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Slider</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/slider') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Slider Image</label>
                                <input type="file" name="slider_image" class="form-control">
                                <span class="text-danger">Size 1920*950 max = 1MB</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alt Text</label>
                                <input type="text" name="alt_text" class="form-control" placeholder="Alt Text">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-40">
            <h6 class="mb-24">All Slider Image </h6>
            <div class="row gy-4">
                @foreach ($slider as $key => $row)
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card h-100 radius-12 p-0 overflow-hidden position-relative">
                            <div class="card-body p-0 gradient-overlay bottom-0 start-0">
                                <img src="{{ asset($row->slider_image) }}" alt="{{ $row->alt_text }}" class="w-100 h-100">
                                <div class="position-absolute start-0 bottom-0 p-24 z-1">
                                    <button
                                        class="btn text-danger-600 hover-text-danger px-0 py-10 d-inline-flex align-items-center gap-2 delete-slider-image"
                                        data-id="{{$row->id}}">
                                        <iconify-icon icon="iconamoon:trash" class="text-xl"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-slider-image').on('click', function() {
                var id = $(this).data('id');
                var token = $('meta[name="csrf-token"]').attr('content'); 

                $.ajax({
                    url: "{{ url('admin/slider/delete') }}/" + id, 
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

@stop
