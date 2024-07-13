@extends('layouts.master')
@section('title')
المنتجات
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header pb-0">
				@if ($errors->any())
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
				@endif
				@if (session()->has('Add'))

				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{session()->get('Add')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (session()->has('Error'))
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					{{session()->get('Error')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (session()->has('Edit'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{session()->get('Edit')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (session()->has('Delete'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{session()->get('Delete')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@can('اضافة منتج')
				<div class="d-flex justify-content-between">
					<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
				</div>
				@endcan
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table text-md-nowrap" id="example1" data-page-length="50">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">#</th>
								<th class="wd-15p border-bottom-0">اسم المنتج</th>
								<th class="wd-20p border-bottom-0">اسم القسم</th>
								<th class="wd-20p border-bottom-0">ملاحظات</th>
								<th class="wd-15p border-bottom-0">العمليات</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($products as $product)
								<?php $i++; ?>
								<tr>
									<td>{{$i}}</td>
									<td>{{$product->product_name}}</td>
									<td>{{$product->section->section_name}}</td>
									<td>{{$product->description}}</td>
									<td>
										@can('تعديل منتج')
										<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}" data-description="{{ $product->description }}" data-section_id="{{$product->section_id}}" data-toggle="modal" href="#product_update" title="تعديل"><i class="las la-pen"></i></a>
										@endcan
										@can('حذف منتج')
										<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}" data-toggle="modal" href="#product_delete" title="حذف"><i class="las la-trash"></i></a>
										@endcan
									</td>
								</tr>

							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="{{route('products.store')}}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="form-group">
								<label for="product_name">اسم المنتج</label>
								<input type="text" id="product_name" name="product_name" class="form-control">
							</div>
							<div class="form-group">
								<label for="section_id">القسم</label>
								<select name="section_id" class="form-control SlectBox">
									@foreach ($sections as $section)
									<option value="{{$section->id}}">{{$section->section_name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="description">ملاحظات</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<input class="btn ripple btn-primary" type="submit" value="تأكيد">
							<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="product_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<form action="{{url('products/update')}}" method="POST" autocomplete="off">
							{{method_field('patch')}}
							@csrf
							<div class="form-group">
								<input type="hidden" name="id" id="id" value="">
								<label for="product_name">اسم المنتج</label>
								<input type="text" id="product_name" name="product_name" class="form-control">
							</div>
							<div class="form-group">
								<label for="section_id">القسم</label>
								<select name="section_id" id="section_id_update" class="form-control SlectBox">
									@foreach ($sections as $section)
									<option value="{{$section->id}}">{{$section->section_name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="description">ملاحظات</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">تاكيد</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal" id="product_delete">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="{{url('products/destroy')}}" method="post">
						{{method_field('delete')}}
						@csrf
						<div class="modal-body">
							<p>هل انت متاكد من عملية الحذف ؟</p><br>
							<input type="hidden" name="id" id="id" value="">
							<input class="form-control" name="product_name" id="product_name" type="text" readonly>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
							<button type="submit" class="btn btn-danger">تاكيد</button>
						</div>
				</div>
				</form>
			</div>
		</div>

	</div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
	$('#product_update').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var product_name = button.data('product_name')
		var description = button.data('description')
		var section_id = button.data('section_id')

		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #product_name').val(product_name);
		modal.find('.modal-body #section_id_update').val(section_id);
		modal.find('.modal-body #description').val(description);
	})
</script>
<script>
	$('#product_delete').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var product_name = button.data('product_name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #product_name').val(product_name);
	})
</script>
@endsection