@extends('layouts.back-end.app')

@section('title', translate('Home_Page_Layout'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{ asset('/public/assets/back-end/img/Pages.png') }}" alt="">
                {{ translate('pages') }}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.pages-inline-menu')
        <!-- End Inlile Menu -->

        {{-- <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"> --}}
        <div class="row"> <!-- Sidebar-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Home Layout Table </h5>

                        {{-- <button class="btn btn--primary btn-icon-split for-addFaq" data-toggle="modal"
                            data-target="#addModal">

                            <i class="tio-add"></i>
                            <span class="text">Add New Section </span>
                        </button> --}}
                        <button class="btn btn--primary btn-icon-split for-addFaq" data-toggle="modal"
                            data-target="#addModal">
                            <i class="tio-add"></i>
                            <span class="text">Add New Section</span>
                        </button>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="dataTable_length"><label>Show <select
                                                    name="dataTable_length" aria-controls="dataTable"
                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input
                                                    type="search" class="form-control form-control-sm" placeholder=""
                                                    aria-controls="dataTable"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table
                                            class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100 dataTable no-footer"
                                            id="dataTable" cellspacing="0" style="text-align: left;" role="grid"
                                            aria-describedby="dataTable_info">
                                            <thead class="thead-light thead-50 text-capitalize">
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="SL: activate to sort column descending">SL</th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="SL: activate to sort column descending">Section Name
                                                    </th>

                                                    <th class="min-w-200 sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Answer: activate to sort column ascending">Web
                                                        Order
                                                    </th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ranking: activate to sort column ascending">Web
                                                        Status
                                                    </th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Status : activate to sort column ascending">Mobile Order
                                                    </th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending">Mobile
                                                        Status
                                                    </th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending">actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($home_layout as $data)
                                                    {{-- {{ $data }} --}}
                                                    <tr class="odd">
                                                        <td id="layout{{ $data->id }}">
                                                            {{ $data->id }}
                                                        </td>
                                                        <td>
                                                            {{ $data->section_name }}
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <input onkeypress="showBtn({{ $data->id }})"
                                                                    type="number" id="web-order{{ $data->id }}"
                                                                    class="web-order form-control "
                                                                    placeholder="Enter Web order"
                                                                    value="{{ $data->web_order }}">

                                                            </div>


                                                        </td>
                                                        <td>
                                                            <!-- Custom switch with dynamic status -->
                                                            <div id=""
                                                                class="custom-control custom-switch text-center">
                                                                <input onchange="showBtn({{ $data->id }})"
                                                                    type="checkbox" class="custom-control-input"
                                                                    id="web-status-switch{{ $data->id }}"
                                                                    name="status"
                                                                    {{ $data->web_status ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="web-status-switch{{ $data->id }}"></label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="">
                                                                <input onkeypress="showBtn({{ $data->id }})"
                                                                    type="number" id="mobile-order{{ $data->id }}"
                                                                    class="mobile-order form-control"
                                                                    placeholder="Enter Mobile Order"
                                                                    value="{{ $data->mobile_order }}">

                                                            </div>
                                                        </td>

                                                        <td>
                                                            <!-- Default switch -->
                                                            <div id=""
                                                                class="custom-control custom-switch text-center">
                                                                <input onchange="showBtn({{ $data->id }})"
                                                                    type="checkbox" class="custom-control-input"
                                                                    id="mobile-status-switch{{ $data->id }}"
                                                                    {{ $data->mobile_status ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="mobile-status-switch{{ $data->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <button id="save-button{{ $data->id }}"
                                                                    class="btn btn--primary save-button"
                                                                    onclick="saveLayout({{ $data->id }})">Save</button>

                                                                <button id="delete-button{{ $data->id }}"
                                                                    class="btn btn-danger delete-button"
                                                                    onclick="deleteLayout({{ $data->id }})">Delete</button>
                                                            </div>
                                                        </td>
                                                        {{-- <td valign="top" colspan="6" class="dataTables_empty">No data
                                                            available in table</td> --}}
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="dataTable_info" role="status"
                                            aria-live="polite">Showing 0 to 0 of 0 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="dataTable_previous"><a href="#" aria-controls="dataTable"
                                                        data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                                </li>
                                                <li class="paginate_button page-item next disabled" id="dataTable_next"><a
                                                        href="#" aria-controls="dataTable" data-dt-idx="1"
                                                        tabindex="0" class="page-link">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.business-settings.submit.section') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="sectionName">Section Name</label>
                            <input type="text" class="form-control" id="sectionName" name="sectionName"
                                placeholder="Enter Section Name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    {{-- ck editor --}}
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('#editor').ckeditor({
            contentsLangDirection: '{{ Session::get('direction') }}',
        });
        $('.save-button').prop('disabled', true);

        function showBtn(layoutID) {
            console.log(layoutID);
            $('#save-button' + layoutID).prop('disabled', false);
        }

        function deleteLayout(layoutID) {
            var id = layoutID;
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var csrfToken = "{{ csrf_token() }}";
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    var ajaxData = {
                        id_layout: id,
                        _token: csrfToken
                    };
                    $.ajax({
                        url: '/admin/business-settings/home-layout',
                        method: 'DELETE',
                        data: ajaxData,
                        success: function(response) {
                            location.reload();

                        },
                        error: function(error) {
                            console.error('Error deleting layout:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        }


        function saveLayout(layoutID) {
            var id = layoutID;
            var webOrder = $('#web-order' + layoutID).val();
            var webStatus = $('#web-status-switch' + layoutID).is(':checked') ? 1 : 0;
            var mobileOrder = $('#mobile-order' + layoutID).val();
            var mobileStatus = $('#mobile-status-switch' + layoutID).is(':checked') ? 1 : 0;
            $.ajax({
                url: '/admin/business-settings/home-layout',
                method: 'POST',
                data: {
                    id_layout: id,
                    web_order: webOrder,
                    web_status: webStatus,
                    mobile_order: mobileOrder,
                    mobile_status: mobileStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        title: "Updated successully!",
                        icon: "success"
                    });
                },

            });
        };
    </script>
    {{-- ck editor --}}
@endpush
