@extends('layouts.master')
@section('title')
قائمة الفواتير
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
			<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
	@if (session()->has('Delete'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{session()->get('Delete')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	@if (session()->has('Archive'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{session()->get('Archive')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	@if (session()->has('Status_Update'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{session()->get('Status_Update')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header pb-0">
				<!-- <div class="d-flex justify-content-between"> -->
					@can('اضافة فاتورة')
					<a class="modal-effect btn btn-outline-primary btn-block" href="{{route('invoices.create')}}">اضافة فاتورة</a>
					@endcan
					@can('تصدير EXCEL')
					<a class="modal-effect btn btn-outline-primary btn-block" href="{{route('invoices_export')}}">تصدير اكسيل</a>
					@endcan
				<!-- </div> -->
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table text-md-nowrap" id="example1">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">#</th>
								<th class="wd-15p border-bottom-0">رقم الفاتورة</th>
								<th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
								<th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
								<th class="wd-10p border-bottom-0">المنتج</th>
								<th class="wd-25p border-bottom-0">القسم</th>
								<th class="wd-25p border-bottom-0">الخصم</th>
								<th class="wd-25p border-bottom-0">نسبة الضريبة</th>
								<th class="wd-25p border-bottom-0">قيمة الضريبة</th>
								<th class="wd-25p border-bottom-0">الاجمالى</th>
								<th class="wd-25p border-bottom-0">الحالة</th>
								<th class="wd-25p border-bottom-0">ملاحظات</th>
								<th class="wd-25p border-bottom-0">العمليات</th>
							</tr>
						</thead>
						<tbody>
							@php $i = 0; @endphp
							@foreach ($invoices as $invoice)
								@php $i++; @endphp
								<tr>
									<td> {{$i}} </td>
									<td>{{$invoice->invoice_number}}</td>
									<td>{{$invoice->invoice_date}}</td>
									<td>{{$invoice->due_date}}</td>
									<td>{{$invoice->product}}</td>
									<td>
										<a href="{{url('invoice/details')}}/{{$invoice->id}}">{{$invoice->section->section_name}}</a>
									</td>
									<td>{{$invoice->discount}}</td>
									<td>{{$invoice->rate_vat}}</td>
									<td>{{$invoice->value_vat}}</td>
									<td>{{$invoice->total}}</td>
									<td>
										@if ($invoice->value_status == 1)
										<span class="text-success">{{$invoice->status}}</span>
										@elseif ($invoice->value_status == 2)
										<span class="text-danger">{{$invoice->status}}</span>
										@else
										<span class="text-warning">{{$invoice->status}}</span>
										@endif
									</td>
									<td>{{$invoice->note}}</td>
									<td>
										<div class="dropdown">
											<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary" data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات</button>
											<div class="dropdown-menu tx-13">
												@can('تعديل الفاتورة')
												<a class="dropdown-item" href="{{route('invoices.edit', $invoice->id)}}">&nbsp;&nbsp;تعديل</a>
												@endcan
												@can('تغير حالة الدفع')
												<a class="dropdown-item" href="{{url::route('status_show', $invoice->id)}}">&nbsp;&nbsp;تعديل حالة الدفع</a>
												@endcan
												@can('حذف الفاتورة')
												<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#delete_invoice">&nbsp;&nbsp;حذف الفاتورة</a>
												@endcan
												@can('ارشفة الفاتورة')
												<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#move_to_archive">&nbsp;&nbsp;نقل الى الارشيف</a>
												@endcan
												@can('طباعةالفاتورة')
												<a class="dropdown-item" href="{{route('invoice_print', $invoice->id)}}">&nbsp;&nbsp;طباعة فاتورة</a>
												@endcan
											</div>
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
</div>

<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<form action="{{ route('invoices.destroy', 'test') }}" method="post">
					{{ method_field('delete') }}
					{{ csrf_field() }}
			</div>
			<div class="modal-body">
				هل انت متاكد من عملية الحذف ؟
				<input type="hidden" name="invoice_id" id="invoice_id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
				<button type="submit" class="btn btn-danger">تاكيد</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="move_to_archive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">نقل الى الارشيف</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<form action="{{ route('invoices.destroy', 'test') }}" method="post">
					{{ method_field('delete') }}
					{{ csrf_field() }}
			</div>
			<div class="modal-body">
				هل انت متاكد من نقل الفاتورة الى الارشيف ؟
				<input type="hidden" name="invoice_id" id="invoice_id" value="">
				<input type="hidden" name="archive" id="archive" value="1">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
				<button type="submit" class="btn btn-danger">تاكيد</button>
			</div>
			</form>
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
<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>
<script>
    $('#move_to_archive').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>
@endsection