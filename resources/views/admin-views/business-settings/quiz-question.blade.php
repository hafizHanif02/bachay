@extends('layouts.back-end.app')

@section('title', 'Quiz Question')

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
	{{-- @include('admin-views.business-settings.pages-inline-menu') --}}
	<!-- End Inlile Menu -->
	<div class="row gx-2 gx-lg-3">
		<div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
			<div class="card">
				<div class="card-body">
				  <div class="container">
					<form action="{{ route('admin.business-settings.quiz.question.store') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row g-3">
							<div class="col-md-12">
								<div class="form-group">
									<label class="title-color text-capitalize"
										   for="exampleFormControlInput1">Quiz </label>
									<select name="quiz_id" class="form-control" id="" required>
										<option value="" selected disabled> Select Quiz</option>
										@foreach($quizes as $quiz)
										<option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row g-3">
							<div class="col-md-12">
								<div class="form-group">
									<label class="title-color text-capitalize"
										   for="exampleFormControlInput1">Question </label>
									<input type="text" name="question" placeholder="Enter Question"  class="form-control" required>
								</div>
							</div>
						</div>
						<div class="col-md-12">

							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Options</th>
										<th>Actual Answer</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="col-md-10 mt-2">
												<label for="" class="form-label text-center">1</label>
												<input type="text" name="options[0]" id="option1" class="form-control">
											</div>
											<div class="col-md-10 mt-2">
												<label for="" class="form-label text-center">2</label>
												<input type="text" name="options[1]" id="option2" class="form-control">
											</div>
											<div class="col-md-10 mt-2">
												<label for="" class="form-label text-center">3</label>
												<input type="text" name="options[2]" id="option3" class="form-control">
											</div>
											<div class="col-md-10 mt-2">
												<label for="" class="form-label text-center">4</label>
												<input type="text" name="options[3]" id="option4" class="form-control">
											</div>
										</td>
										<td>
											<div class="col-md-2 mt-3">
												<label for="" class="form-label text-center"></label>
												<input type="radio" name="actual_answer" value="1" class="form-control">
										</div>
											<div class="col-md-2 mt-3">
												<label for="" class="form-label text-center"></label>
												<input type="radio" name="actual_answer" value="2" class="form-control">
											</div>
											<div class="col-md-2 mt-3">
												<label for="" class="form-label text-center"></label>
												<input type="radio" name="actual_answer" value="3" class="form-control">
											</div>
											<div class="col-md-2 mt-3">
												<label for="" class="form-label text-center"></label>
												<input type="radio" name="actual_answer" value="4" class="form-control">
											</div>
											<input type="hidden" name="correct_answer">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="d-flex justify-content-end gap-3">
							<button type="reset" class="btn btn-secondary">Reset </button>
							<button type="submit" class="btn btn--primary">Save </button>
						</div>
					</form>
				 </div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
			<div class="card">
				<div class="px-3 py-4">
					<div class="row align-items-center">
						<div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
							<h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
								Quiz
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
						<tr class="text-center">
							<th>S no. </th>
							{{-- <th>Quiz Category</th> --}}
							<th>Quiz</th>
							<th>Question</th>
							<th>Actions</th>
						</tr>
						</thead>

						<tbody>
							@foreach($quiz_questions as $question)
							<tr class="text-center">
								<td>{{ $loop->iteration }}</td>
								<td>{{ $question->quiz->name }}</td>
								<td>{{ $question->question }}</td>
								<td>
									<div class="d-flex justify-content-center gap-2">
										{{-- <a class="btn btn-outline--primary btn-sm edit square-btn"
										    title="View Quiz"
										   href="{{ route('admin.business-settings.quiz.question.edit', $question->id) }}">
										   <i class="tio-edit"></i>
										</a> --}}
										<form action="{{route('admin.business-settings.quiz.question.delete')}}" method="post">
										@csrf
										<input type="hidden" name="id" value="{{$question->id}}">
										<button type="submit" class="btn btn-outline-danger btn-sm delete"
										   title="{{translate('delete')}}"
										   href="javascript:"
										   id="{{$question->id}}')">
											<i class="tio-delete"></i>
										</button>
										</form>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					
				</div>
			</div>
		</div>
		<!-- End Table -->
	</div>
</div>

{{-- 
<div class="accordion">
	<div class="accordion-item">
		<div class="accordion-header">Section 1</div>
		<div class="accordion-content">
			<p>Content for Section 1</p>
		</div>
	</div>
	<div class="accordion-item">
		<div class="accordion-header">Section 2</div>
		<div class="accordion-content">
			<p>Content for Section 2</p>
		</div>
	</div>
	<div class="accordion-item">
		<div class="accordion-header">Section 3</div>
		<div class="accordion-content">
			<p>Content for Section 3</p>
		</div>
	</div>
</div>
<style>
	.accordion {
		width: 300px;
	}

	.accordion-item {
		border: 1px solid #ddd;
		margin-bottom: 5px;
		overflow: hidden;
	}

	.accordion-header {
		background-color: #f1f1f1;
		padding: 10px;
		cursor: pointer;
	}

	.accordion-content {
		padding: 10px;
		display: none;
	}

	.accordion-item.active .accordion-content {
		display: block;
	}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordionItems = document.querySelectorAll('.accordion-item');

        accordionItems.forEach(item => {
            item.addEventListener('click', function () {
                this.classList.toggle('active');
            });
        });
    });
</script> --}}
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
	<script>
		$(document).ready(function() {
			$('input[name="actual_answer"]').change(function() {
				var selectedOption = $('input[name="actual_answer"]:checked').val();
				var optionText = $('#option' + selectedOption).val();
				$('input[name="correct_answer"]').val(optionText);
			});
		});
		</script>
    {{--ck editor--}}
@endpush



