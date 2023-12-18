@extends('layouts.back-end.app')

@section('title', 'Articles')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/Pages.png')}}" alt="">
                {{translate('pages')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.pages-inline-menu')
        <!-- End Inlile Menu -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.article.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">Title </label>
                                        <input type="text" name="title" class="form-control"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">Text </label>
                                        <textarea name="text" class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">Category </label>
                                        <select class="form-control" name="category_id" id="">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <center>
                                            <img class="upload-img-view mb-4" id="viewer"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset('public/assets/admin/img/900x400/img1.jpg')}}"
                                                 alt="image"/>
                                        </center> --}}
                                        <label
                                            class="title-color text-capitalize">Thumbnail</label>
                                        <span class="text-info"></span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="thumbnail" class="custom-file-input" >
                                            <label class="custom-file-label" for="customFileEg1">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">Reset </button>
                                <button type="submit" class="btn btn--primary">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    Article
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12 ml-1"></span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{translate('search_by_title')}}"
                                               aria-label="Search orders" value="" required>
                                        <button type="submit"
                                                class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>S no. </th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-center">{{translate('action')}} </th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <span class="d-block">
                                            {{($article->title)}}
                                        </span>
                                    </td>
                                    <td>
                                        {{($article->text)}}
                                    </td>
                                    <td>
                                        <img class="min-w-75" width="75" height="75"
                                        src="{{ asset('public/assets/images/articles/thumbnail/' . $article->thumbnail) }}" alt="Article Thumbnail">
                                   
                                    </td>
                                    <td>{{ $article->category->name}}</td>
                                    <td>
                                        <form action="" method="post" id="article_status{{$article->id}}_form" class="article_status_form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$article->id}}">
                                            <label class="switcher mx-auto">
                                                <input type="checkbox" class="switcher_input" id="article_status{{$article->id}}" name="status" value="1" {{ $article->status == 1 ? 'checked':'' }} onclick="toogleStatusModal(event,'article_status{{$article->id}}','article-on.png','article-off.png','{{translate('Want_to_Turn_ON_article_Status')}}','{{translate('Want_to_Turn_OFF_article_Status')}}',`<p>{{translate('if_enabled_customers_will_receive_articles_on_their_devices')}}</p>`,`<p>{{translate('if_disabled_customers_will_not_receive_articles_on_their_devices')}}</p>`)">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                    {{-- <td>
                                        <a href="javascript:void(0)" class="btn btn-outline-success square-btn btn-sm"
                                           onclick="resendarticle(this)" data-id="{{ $article->id }}">
                                            <i class="tio-refresh"></i>
                                        </a>
                                    </td> --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline--primary btn-sm edit square-btn"
                                               title="{{translate('edit')}}"
                                               href="">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete"
                                               title="{{translate('delete')}}"
                                               href="javascript:"
                                               id="{{$article->id}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="mt-4">
                            <tfoot>
                            {{-- {!! $articles->links() !!} --}}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>
@endsection

@push('script')
    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('#editor').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
    {{--ck editor--}}
@endpush
