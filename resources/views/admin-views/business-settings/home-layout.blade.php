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

                            <button class="btn btn--primary btn-icon-split for-addFaq" data-toggle="modal"
                                data-target="#addModal">

                                <i class="tio-add"></i>
                                <span class="text">Add FAQ </span>
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
                                                            rowspan="1" colspan="1"
                                                            aria-sort="ascending"
                                                            aria-label="SL: activate to sort column descending">Section Name
                                                        </th>

                                                        <th class="min-w-200 sorting" tabindex="0"
                                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                                            aria-label="Answer: activate to sort column ascending">Web
                                                            Order
                                                        </th>
                                                        <th class="text-center sorting" tabindex="0"
                                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                                            aria-label="Ranking: activate to sort column ascending">Web
                                                            Status
                                                        </th>
                                                        <th class="text-center sorting" tabindex="0"
                                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                                            aria-label="Status : activate to sort column ascending">Mobile Order
                                                        </th>
                                                        <th class="text-center sorting" tabindex="0"
                                                            aria-controls="dataTable" rowspan="1" colspan="1"
                                                            aria-label="Action: activate to sort column ascending">Mobile
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd">
                                                        <td>
                                                            1
                                                        </td>
                                                        <td>
                                                            Home Banner
                                                        </td>
                                                        <td >
                                                            <div class="d-flex align-items-center justify-content-around">
                                                                <input type="number" class="form-control w-50" placeholder="Enter Web Order">
                                                                <button class="btn btn-sm btn-primary"> <i class="tio-add"></i>add</button>
                                                            </div>


                                                        </td>
                                                        <td>
                                                            <!-- Default switch -->
                                                            <div class="custom-control custom-switch text-center">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="customSwitches">
                                                                <label class="custom-control-label"
                                                                    for="customSwitches"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-around">
                                                                <input type="number" class="form-control w-50" placeholder="Enter Mobile Order">
                                                                <button class="btn btn-sm btn-primary"> <i class="tio-add"></i>add</button>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <!-- Default switch -->
                                                            <div class="custom-control custom-switch text-center">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="customSwitches2">
                                                                <label class="custom-control-label"
                                                                    for="customSwitches2"></label>
                                                            </div>
                                                        </td>

                                                        {{-- <td valign="top" colspan="6" class="dataTables_empty">No data
                                                            available in table</td> --}}
                                                    </tr>
                                                    <tr class="odd">
                                                        <td>
                                                            1
                                                        </td>
                                                        <td>
                                                            Home Banner
                                                        </td>
                                                        <td >
                                                            <div class="d-flex align-items-center justify-content-around">
                                                                <input type="number" class="form-control w-50" placeholder="Enter Web Order">
                                                                <button class="btn btn-sm btn-primary"> <i class="tio-add"></i>add</button>
                                                            </div>


                                                        </td>
                                                        <td>
                                                            <!-- Default switch -->
                                                            <div class="custom-control custom-switch text-center">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="customSwitches3">
                                                                <label class="custom-control-label"
                                                                    for="customSwitches3"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-around">
                                                                <input type="number" class="form-control w-50" placeholder="Enter Mobile Order">
                                                                <button class="btn btn-sm btn-primary"> <i class="tio-add"></i>add</button>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <!-- Default switch -->
                                                            <div class="custom-control custom-switch text-center">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="customSwitches4">
                                                                <label class="custom-control-label"
                                                                    for="customSwitches4"></label>
                                                            </div>
                                                        </td>

                                                        {{-- <td valign="top" colspan="6" class="dataTables_empty">No data
                                                            available in table</td> --}}
                                                    </tr>
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
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                id="dataTable_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous disabled"
                                                        id="dataTable_previous"><a href="#"
                                                            aria-controls="dataTable" data-dt-idx="0" tabindex="0"
                                                            class="page-link">Previous</a></li>
                                                    <li class="paginate_button page-item next disabled"
                                                        id="dataTable_next"><a href="#" aria-controls="dataTable"
                                                            data-dt-idx="1" tabindex="0" class="page-link">Next</a>
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
@endsection

@push('script')
    {{-- ck editor --}}
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('#editor').ckeditor({
            contentsLangDirection: '{{ Session::get('direction') }}',
        });
    </script>
    {{-- ck editor --}}
@endpush
