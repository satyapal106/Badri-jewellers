@extends('layout.master')
@section('style')
    <style>
        .cke_notifications_area {
            pointer-events: none;
            display: none;
        }

        div:where(.swal2-icon) .swal2-icon-content {
            display: flex;
            align-items: center;
            font-size: 1.2em !important;
        }

        .swal2-popup .swal2-styled {
            margin: 0px 5px 0 !important;
            padding: 10px 32px;
        }
    </style>
@stop
@section('body')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">All Testimonial </h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ url('admin/dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">All Testimonial</li>
        </ul>
    </div>
    <div class="row gy-4">
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
        <div class="card h-100 p-0 radius-12">

            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                </div>
                <a href="{{ url('admin/testimonial') }}"
                    class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    Add New
                </a>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="d-flex align-items-center gap-10">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border input-form-dark" type="checkbox"
                                                name="checkbox" id="selectAll">
                                        </div>
                                        S.L
                                    </div>
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $key => $row)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400"
                                                    type="checkbox" name="checkbox" id="SL">
                                            </div>
                                            {{ $key + 1 }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span
                                                    class="text-md mb-0 fw-normal text-secondary-light">{{ $row->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-md mb-0 fw-normal text-secondary-light">
                                                    @php
                                                        echo \Illuminate\Support\Str::words(
                                                            $row->description,
                                                            15,
                                                            '...',
                                                        );
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($row->status == '1')
                                        <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                                        @else
                                        <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Non Active</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            @if ($row->status == '1')
                                                <a href="javascript:void(0)"
                                                    class="fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center updateStatus"
                                                    id="testimonial-{{ $row->id }}" data-page-id="{{ $row->id }}">
                                                    <i class="fa fa-toggle-on" style="font-size:22px;color:blue"
                                                        status="active"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"
                                                    class="fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center updateStatus"
                                                    id="testimonial-{{ $row->id }}" data-page-id="{{ $row->id }}">
                                                    <i class="fa fa-toggle-off" style="font-size:22px;color:gray"
                                                        status="Non-Active"></i>
                                                </a>
                                            @endif
                                            <a href="{{ url('/admin/testimonial/' . $row->id) }}"
                                                class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="confirmDelete bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                name="Testimonial" title="testimonial section"
                                                data-id="{{ $row->id }}">
                                                <iconify-icon icon="fluent:delete-24-regular"
                                                    class="menu-icon"></iconify-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', ".confirmDelete", function() {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    window.location.href = "/admin/delete-testimonial/" + id;
                }
                // var name = $(this).attr('name');
                // if (confirm('Are you sure you want to delete ' + name + '?')) {
                //     return true;
                // }
                // return false;
            });
        });

        $(document).on('click', '.updateStatus', function() {

            var status = $(this).children('i').attr('status');
            var page_id = $(this).attr('data-page-id');

            //alert(page_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/testimonial-status',
                data: {
                    page_id: page_id,
                    status: status
                },
                success: function(response) {
                    if(response['status'] ==0){
                        $("#testimonial-" + page_id).html('<i class="fa fa-toggle-off" style="font-size:22px;color:gray" status="Non-Active"></i>');
                    }
                    else if(response['status'] == 1){
                        $("#testimonial-" + page_id).html('<i class="fa fa-toggle-on" style="font-size:22px;color:blue" status="Active"></i>');
                    }
                },
                error: function() {
                    alert('Error');
                }
            })

        })
    </script>

@stop
