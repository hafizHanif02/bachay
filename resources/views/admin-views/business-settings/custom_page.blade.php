@extends('layouts.back-end.app')

@section('title', 'Custom Page')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/custom_page.png')}}" alt="">
                {{translate('custom_page')}}
                <small>
                    <strong class="text--primary"> ({{str_replace("_", " ", theme_root_path())}})</strong>
                </small>
            </h2>
            <div class="btn-group">
                <div class="ripple-animation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" class="svg replaced-svg">
                        <path d="M9.00033 9.83268C9.23644 9.83268 9.43449 9.75268 9.59449 9.59268C9.75449 9.43268 9.83421 9.2349 9.83366 8.99935V5.64518C9.83366 5.40907 9.75366 5.21463 9.59366 5.06185C9.43366 4.90907 9.23588 4.83268 9.00033 4.83268C8.76421 4.83268 8.56616 4.91268 8.40616 5.07268C8.24616 5.23268 8.16644 5.43046 8.16699 5.66602V9.02018C8.16699 9.25629 8.24699 9.45074 8.40699 9.60352C8.56699 9.75629 8.76477 9.83268 9.00033 9.83268ZM9.00033 13.166C9.23644 13.166 9.43449 13.086 9.59449 12.926C9.75449 12.766 9.83421 12.5682 9.83366 12.3327C9.83366 12.0966 9.75366 11.8985 9.59366 11.7385C9.43366 11.5785 9.23588 11.4988 9.00033 11.4993C8.76421 11.4993 8.56616 11.5793 8.40616 11.7393C8.24616 11.8993 8.16644 12.0971 8.16699 12.3327C8.16699 12.5688 8.24699 12.7668 8.40699 12.9268C8.56699 13.0868 8.76477 13.1666 9.00033 13.166ZM9.00033 17.3327C7.84755 17.3327 6.76421 17.1138 5.75033 16.676C4.73644 16.2382 3.85449 15.6446 3.10449 14.8952C2.35449 14.1452 1.76088 13.2632 1.32366 12.2493C0.886437 11.2355 0.667548 10.1521 0.666992 8.99935C0.666992 7.84657 0.885881 6.76324 1.32366 5.74935C1.76144 4.73546 2.35505 3.85352 3.10449 3.10352C3.85449 2.35352 4.73644 1.7599 5.75033 1.32268C6.76421 0.88546 7.84755 0.666571 9.00033 0.666016C10.1531 0.666016 11.2364 0.884905 12.2503 1.32268C13.2642 1.76046 14.1462 2.35407 14.8962 3.10352C15.6462 3.85352 16.24 4.73546 16.6778 5.74935C17.1156 6.76324 17.3342 7.84657 17.3337 8.99935C17.3337 10.1521 17.1148 11.2355 16.677 12.2493C16.2392 13.2632 15.6456 14.1452 14.8962 14.8952C14.1462 15.6452 13.2642 16.2391 12.2503 16.6768C11.2364 17.1146 10.1531 17.3332 9.00033 17.3327ZM9.00033 15.666C10.8475 15.666 12.4206 15.0168 13.7195 13.7185C15.0184 12.4202 15.6675 10.8471 15.667 8.99935C15.667 7.15213 15.0178 5.57907 13.7195 4.28018C12.4212 2.98129 10.8481 2.33213 9.00033 2.33268C7.1531 2.33268 5.58005 2.98185 4.28116 4.28018C2.98227 5.57852 2.3331 7.15157 2.33366 8.99935C2.33366 10.8466 2.98283 12.4196 4.28116 13.7185C5.57949 15.0174 7.15255 15.6666 9.00033 15.666Z" fill="currentColor"></path>
                    </svg>
                </div>


                <div class="dropdown-menu dropdown-menu-right bg-aliceblue border border-color-primary-light p-4 dropdown-w-lg-30">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img width="20" src="{{asset('/public/assets/back-end/img/note.png')}}" alt="">
                        <h5 class="text-primary mb-0">{{translate('note')}}</h5>
                    </div>
                    <p class="title-color font-weight-medium mb-0">{{ translate('currently_you_are_managing_custom_pages_for_')}}{{ucwords(str_replace("_", " ", theme_root_path()))}}.{{translate('these_saved_data_is_only_applicable_only_for_')}}{{ucwords(str_replace("_", " ", theme_root_path()))}}.{{translate('if_you_change_theme_from_theme_setup_these_custom_pages_will_not_be_shown_in_changed_theme._You_have_upload_all_the_custom_pages_over_again _according_to_the_new_theme_ratio_and_sizes._If_you_switch_back_to_')}}{{ucwords(str_replace("_", " ", theme_root_path()))}}{{translate('_again_,_you_will_see_the_saved_data.') }}</p>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row pb-4 d--none" id="main-custom_page"
             style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-capitalize">{{ translate('custom_page_form')}}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.business-settings.custom-page.store')}}" method="post" enctype="multipart/form-data"
                              class="custom_page_form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label for="resource_id"
                                           class="title-color text-capitalize">{{translate('resource_type')}}</label>
                                    <select onchange="display_data(this.value)"
                                            class="js-example-responsive form-control w-100"
                                            name="resource_type" required>
                                        <option value="product">{{ translate('product')}}</option>
                                        <option value="category">{{ translate('category')}}</option>
                                        <option value="sub_category">{{ translate('sub_category')}}</option>
                                        <option value="shop">{{ translate('shop')}}</option>
                                        <option value="brand">{{ translate('brand')}}</option>
                                        <option value="deals">{{ translate('deals')}}</option>
                                        <option value="none">{{ translate('none')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3" id="resource-product">
                                        <label for="product_id"
                                               class="title-color text-capitalize">{{translate('product')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="product_id">
                                            @foreach(\App\Model\Product::active()->get() as $product)
                                                <option value="{{$product['id']}}">{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 d--none" id="resource-deals">
                                        <label for="deals_id"
                                               class="title-color text-capitalize">{{translate('deals')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="deals_id">
                                            @foreach(\App\Model\FlashDeal::get() as $flashdeal)
                                                <option value="{{$flashdeal['id']}}">{{$flashdeal['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="form-group mb-3 d--none" id="resource-category">
                                        <label for="name"
                                               class="title-color text-capitalize">{{translate('category')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="category_id">
                                            @foreach(\App\CPU\CategoryManager::parents() as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="form-group mb-3 d--none" id="resource-sub_category">
                                        <label for="name"
                                               class="title-color text-capitalize">{{translate('sub_category')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="sub_category_id">
                                            @foreach(\App\CPU\CategoryManager::subcategory() as $sub_category)
                                                <option value="{{$sub_category['id']}}">{{$sub_category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="form-group mb-3 d--none" id="resource-shop">
                                        <label for="shop_id" class="title-color">{{translate('shop')}}</label>
                                        <select class="w-100 js-example-responsive form-control" name="shop_id">
                                            @foreach(\App\Model\Shop::active()->get() as $shop)
                                                <option value="{{$shop['id']}}">{{$shop['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="form-group mb-3 d--none" id="resource-brand">
                                        <label for="brand_id"
                                               class="title-color text-capitalize">{{translate('brand')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="brand_id">
                                            @foreach(\App\Model\Brand::all() as $brand)
                                                <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end flex-wrap gap-10">
                                    <button class="btn btn-secondary cancel px-4" type="reset">{{ translate('reset')}}</button>
                                    <button id="add" type="submit"
                                            class="btn btn--primary px-4">{{ translate('save')}}</button>
                                    <button id="update"
                                       class="btn btn--primary d--none text-white">{{ translate('update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="Custom_page_table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-6 mb-2 mb-md-0">
                                <h5 class="mb-0 text-capitalize d-flex gap-2">
                                    {{ translate('Custom_page_table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12">{{ count($custom_pages) }}</span>
                                </h5>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div class="row gy-2 gx-2 align-items-center text-left">
                                    <div class="col-sm-12 col-md-9">
                                        <form action="{{ url()->current() }}" method="GET">
                                            <div class="row gy-2 gx-2 align-items-center text-left">
                                                <div class="col-sm-12 col-md-9">
                                                    {{-- <select class="form-control __form-control" name="search" id="date_type">
                                                        <option value="">{{ translate('all')}}</option>
                                                        <option value="Main custom_page" {{ $search == "Main custom_page" ? 'selected':'' }}>{{ translate('main_custom_page')}}</option>
                                                        <option value="Popup custom_page" {{ $search == "Popup custom_page" ? 'selected':'' }}>{{ translate('popup_custom_page')}}</option>

                                                        @if(theme_root_path() != 'theme_fashion')
                                                            <option value="Footer custom_page" {{ $search == "Footer custom_page" ? 'selected':'' }}>{{ translate('footer_custom_page')}}</option>
                                                            <option value="Main Section custom_page" {{ $search == "Main Section custom_page" ? 'selected':'' }}>{{ translate('main_Section_custom_page')}}</option>
                                                        @endif

                                                        @if(theme_root_path() == 'theme_aster')
                                                            <option value="Header custom_page" {{ $search == "Header custom_page" ? 'selected':'' }}>{{ translate('header_custom_page')}}</option>
                                                            <option value="Sidebar custom_page" {{ $search == "Sidebar custom_page" ? 'selected':'' }}>{{ translate('sidebar_custom_page')}}</option>
                                                            <option value="Top Side custom_page" {{ $search == "Top Side custom_page" ? 'selected':'' }}>{{ translate('top_Side_custom_page')}}</option>
                                                        @endif
                                                        @if(theme_root_path() == 'theme_fashion')
                                                            <option value="Promo custom_page Left" {{ $search == "Promo custom_page Left" ? 'selected':'' }}>{{ translate('promo_custom_page_left')}}</option>
                                                            <option value="Promo custom_page Middle Top" {{ $search == "Promo custom_page Middle Top" ? 'selected':'' }}>{{ translate('promo_custom_page_middle_top')}}</option>
                                                            <option value="Promo custom_page Middle Bottom" {{ $search == "Promo custom_page Middle Bottom" ? 'selected':'' }}>{{ translate('promo_custom_page_middle_bottom')}}</option>
                                                            <option value="Promo custom_page Right" {{ $search == "Promo custom_page Right" ? 'selected':'' }}>{{ translate('promo_custom_page_right')}}</option>
                                                            <option value="Promo custom_page Bottom" {{ $search == "Promo custom_page Bottom" ? 'selected':'' }}>{{ translate('promo_custom_page_bottom')}}</option>
                                                        @endif
                                                    </select> --}}
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <button type="submit" class="btn btn--primary px-4 w-100 text-nowrap">
                                                        {{ translate('filter')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div id="custom_page-btn">
                                            <button id="main-custom_page-add" class="btn btn--primary text-nowrap text-capitalize">
                                                <i class="tio-add"></i>
                                                {{ translate('create_page')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="columnSearchDatatable"
                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th class="pl-xl-5">{{translate('SL')}}</th>
                                <th>Title</th>
                                <th>Resource Type</th>
                                <th>Resource Name</th>
                                <th>Web</th>
                                <th>Mobile</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            @foreach($custom_pages as $custom_page)
                                <tbody>
                                <tr id="data-{{$custom_page->id}}">
                                    <td class="pl-xl-5">{{ $loop->iteration }}</td>
                                    <td>{{ $custom_page->title }}</td>
                                    <td>{{$custom_page->resource_type}}</td>
                                    <td>{{$custom_page->resource_name->name}}</td>
                                    <td>
                                        <form action="{{route('admin.business-settings.custom-page.web',$custom_page['id'])}}" method="post" id="web_form{{$custom_page['id']}}" >
                                            @csrf
                                            <input type="hidden" name="id" value="{{$custom_page['id']}}">
                                            <label class="switcher">
                                                <input type="checkbox"  class="switcher_input" id="web{{$custom_page['id']}}" name="status" value="1" {{ $custom_page['is_web'] == 1 ? 'checked':'' }} onclick="SubmitWeb({{ $custom_page['id'] }})" >
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{route('admin.business-settings.custom-page.mobile',$custom_page['id'])}}" method="post" id="mobile_form{{$custom_page['id']}}" >
                                            @csrf
                                            <input type="hidden" name="id" value="{{$custom_page['id']}}">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input" id="mobile{{$custom_page['id']}}" name="status" value="1" {{ $custom_page['is_mobile'] == 1 ? 'checked':'' }} onclick="SubmitMobile({{ $custom_page['id'] }})" >
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            <a class="btn btn-outline--primary btn-sm cursor-pointer edit"
                                               title="{{ translate('edit')}}"
                                               href="{{route('admin.business-settings.custom-page.edit',$custom_page['id'])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            {{-- {{ dd($custom_page->id) }} --}}
                                            <a class="btn btn-outline-danger btn-sm {{-- cursor-pointer delete --}}"
                                               title="{{ translate('delete')}}"
                                               href="{{route('admin.business-settings.custom-page.delete',$custom_page['id'])}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{-- {{$custom_pages->links()}} --}}
                        </div>
                    </div>

                    @if(count($custom_pages)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160"
                                 src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description">
                            <p class="mb-0">{{ translate('no_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        function SubmitHome(id) {
            let form = $('#home_form' + id);
            console.log(form.serialize());
            

            $.ajax({
                type: 'POST',
                url: `home/${id}`,
                data: form.serialize(),
                success: function (response) {
                    console.log(response);
                    $('#home' + id).prop('checked', response.is_home == 1);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function SubmitWeb(id) {
            let form = $('#web_form' + id);
            console.log(form.serialize());
            $.ajax({
                type: 'POST',
                url: `custom-page/web/${id}`,
                data: form.serialize(),
                success: function (response) {
                    console.log(response);
                    $('#web' + id).prop('checked', response.is_web == 1);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function SubmitMobile(id) {
            let form = $('#mobile_form' + id);
            console.log(form.serialize());
            

            $.ajax({
                type: 'POST',
                url: `custom-page/mobile/${id}`,
                data: form.serialize(),
                success: function (response) {
                    console.log(response);
                    $('#mobile' + id).prop('checked', response.is_mobile == 1);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        function readUrl(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                let imgData = e.target.result;
                let imgName = input.files[0].name;
                input.setAttribute("data-title", "");
                let img = new Image();
                img.onload = function() {
                    let imgWidth = img.naturalWidth;
                    let imgHeight = img.naturalHeight;
                    $('.input_image').css({
                        "background-image": `url('${imgData}')`,
                        "width": "100%",
                        "height": "auto",
                        backgroundPosition: "center",
                        backgroundSize: "contain",
                        backgroundRepeat: "no-repeat",
                        // aspectRatio: 4 / 1,
                    });
                    $('.input_image').addClass('hide-before-content')
                };
                img.src = imgData;
            }
            reader.readAsDataURL(input.files[0]);
        }
        }

        function readUrl2(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                let imgData = e.target.result;
                let imgName = input.files[0].name;
                input.setAttribute("data-title", "");
                let img = new Image();
                img.onload = function() {
                    let imgWidth = img.naturalWidth;
                    let imgHeight = img.naturalHeight;
                    $('.input_image2').css({
                        "background-image": `url('${imgData}')`,
                        "width": "100%",
                        "height": "auto",
                        backgroundPosition: "center",
                        backgroundSize: "contain",
                        backgroundRepeat: "no-repeat",
                        // aspectRatio: 4 / 1,
                    });
                    $('.input_image2').addClass('hide-before-content')
                };
                img.src = imgData;
            }
            reader.readAsDataURL(input.files[0]);
        }
        }
    </script>
    <script>
        $(document).on('ready', function () {
            theme_wise_ration();
        });

        function theme_wise_ration(){
            let custom_page_type = $('#custom_page_type_select').val();
            let theme = '{{ theme_root_path() }}';
            let theme_ratio = {!! json_encode(THEME_RATIO) !!};
            let get_ratio= theme_ratio[theme][custom_page_type];
            $('#theme_ratio').text(get_ratio);
        }

        $('#custom_page_type_select').on('change',function(){
            theme_wise_ration();
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });

        function display_data(data) {

            $('#resource-product').hide()
            $('#resource-brand').hide()
            $('#resource-category').hide()
            $('#resource-sub_category').hide()
            $('#resource-shop').hide()
            $('#resource-deals').hide()

            if (data === 'product') {
                $('#resource-product').show()
            } else if (data === 'brand') {
                $('#resource-brand').show()
            } else if (data === 'category') {
                $('#resource-category').show()
            }
              else if (data === 'sub_category') {
                $('#resource-sub_category').show()
            }
             else if (data === 'shop') {
                $('#resource-shop').show()
            }
            else if (data === 'deals') {
                $('#resource-deals').show()
            }
        }
    </script>

    <script>
        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append(
                '<div class="col-md-6"><div class="form-group"><input type="hidden" name="choice_no[]" value="' + i + '"><label class="title-color">' + n + '</label><input type="text" name="choice[]" value="' + n +
                '" hidden><div class=""><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{ translate('enter_choice_values') }}" data-role="tagsinput" onchange="update_sku()"></div></div></div>'
            );

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        $('#main-custom_page-add').on('click', function () {
            $('#main-custom_page').show();
        });

        $('.cancel').on('click', function () {
            $('.custom_page_form').attr('action', "{{route('admin.business-settings.custom-page.store')}}");
            $('#main-custom_page').hide();
        });

        $('.custom_page_status_form').on('submit', function(event){
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
          
        });

       
    </script>
    <!-- Page level plugins -->
    <!-- New Added JS - Start -->
    <script>
        $('#custom_page_type_select').on('change',function(){
            let input_value = $(this).val();

            if (input_value == "Main custom_page") {
                $('.input_field_for_main_custom_page').removeClass('d-none');
            } else {
                $('.input_field_for_main_custom_page').addClass('d-none');
            }
        });
    </script>
    <!-- New Added JS - End -->
@endpush
