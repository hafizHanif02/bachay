@extends('layouts.back-end.app')

@section('title', 'Q&As')

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
                        <div class="container">
                            <div class="wrapper">
                                @foreach($questions as $question)
                                <div class="comment">
                                    <div>
                                        <div class="content">
                                            <div class="avatar"><img src="{{ $question->user->avatar }}"></div>
                                            <div class="content-comment">
                                                <div class="user">
                                                    <h5>{{ $question->question }}</h5>
                                                </div>
                                                <p>{{ $question->user->f_name.' '.$question->user->l_name }}</p>
                                            </div>
                                        </div>
                                        <div class="footer"></div>
                                    </div>
                                    @foreach($question->answers as $answer)
                                    <div class="subcomment">
                                        <div class="icon">
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 21a1 1 0 0 1-.883.993L19 22h-6.5a3.5 3.5 0 0 1-3.495-3.308L9 18.5V5.415L5.707 8.707a1 1 0 0 1-1.32.083l-.094-.083a1 1 0 0 1-.083-1.32l.083-.094 5-5a1.01 1.01 0 0 1 .112-.097l.11-.071.114-.054.105-.035.118-.025.058-.007L10 2l.075.003.126.017.111.03.111.044.098.052.092.064.094.083 5 5a1 1 0 0 1-1.32 1.497l-.094-.083L11 5.415V18.5a1.5 1.5 0 0 0 1.355 1.493L12.5 20H19a1 1 0 0 1 1 1Z" fill="#969696" />
                                            </svg>
                                        </div>
                                        <div class="other_comments">
                                            <div class="com">
                                                <div class="content">
                                                    <div class="avatar"><img src="{{ $answer->user->avatar }}"></div>
                                                    <div class="content-comment">
                                                        <div class="user">
                                                            <h5>{{ $answer->answer }}</h5>
                                                        </div>
                                                        <p>{{ $answer->user->f_name.' '.$answer->user->l_name }}</p>
                                                        <div class="content-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="sepparator"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap");
.wrapper {
	display: flex;
	flex-direction: column;
	width: 744px;
	.comment {
		display: grid;
		gap: 20px;
		user-select: none;
		.content {
			display: grid;
			grid-template-columns: auto 1fr 110px;
			align-items: flex-start;
			gap: 16px;
			flex: 1;
			.avatar {
				height: 48px;
				width: 48px;
				img {
					max-width: 100%;
					border-radius: 999px;
					object-fit: cover;
				}
			}
			.rate {
				gap: 8px;
				display: flex;
				align-items: center;
				.value {
					font-weight: 500;
					font-size: 13px;
					line-height: 20px;
					text-align: center;
					&.green {
						color: #00ba34;
					}
					&.red {
						color: #e92c2c;
					}
				}
				.btn {
					display: flex;
					align-items: center;
					justify-content: center;
					border: 1px solid #e8e8e8;
					border-radius: 999px;
					width: 32px;
					height: 32px;
					&:hover {
						border-color: #969696;
					}
				}
			}
			&-comment {
				flex: 1;
				display: block;
				.user {
					gap: 12px;
					margin-bottom: 6px;
					align-items: center;
					display: flex;
				}
			}
			&-footer {
				margin-top: 12px;
				gap: 12px;
				display: flex;
				align-items: center;
			}
		}
	}
	.subcomment {
		display: flex;
		align-items: flex-start;
		.icon {
			width: 48px;
			height: 48px;
			color: #969696;
			display: flex;
			margin-right: 16px;
			align-items: center;
			justify-content: center;
		}
		.other_comments {
			flex: 1;
			display: grid;
			gap: 20px;
		}
	}
}
h5 {
	color: #1c1c1c;
	font-weight: 500;
	font-size: 16px;
	line-height: 24px;
}

.sepparator{
    border-top: solid 1px rgb(201, 197, 197); 
}
    </style>
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



