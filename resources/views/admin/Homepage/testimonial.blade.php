@extends('layout.master')
@section('style')
<style>
    .cke_notifications_area {
        pointer-events: none;
        display: none;
    }
</style>
@stop
@section('body')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Testimonial </h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{url('admin/dashboard')}}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Testimonial</li>
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
                    <h6 class="card-title mb-0">Testimonial</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/testimonial') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">
                            {{-- <div class="col-md-4">
                                <label class="form-label">Upload Video</label>
                                <input type="file" name="video" class="form-control">
                                <span class="text-danger">Size 430*430 max = 1MB</span>
                            </div> --}}
                            <div class="col-md-12">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="name">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control ckeditor" name="description" placeholder="Enter the Description" rows="5" name="body"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="//cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@stop
