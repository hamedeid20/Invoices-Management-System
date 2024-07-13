@extends('layouts.master')
@section('title')
تفاصيل الفاتورة
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
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    @if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session()->get('Add')}}
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
    <div class="panel panel-primary tabs-style-2" style="width: 100%;">
        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                    <li><a href="#tab2" class="nav-link" data-toggle="tab">حالة الدفع</a></li>
                    <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="col-xl-12">
                        <div class="card">
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
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>1</td>
                                                <td>{{$invoice->invoice_number}}</td>
                                                <td>{{$invoice->invoice_date}}</td>
                                                <td>{{$invoice->due_date}}</td>
                                                <td>{{$invoice->product}}</td>
                                                <td>{{$invoice->section->section_name}}</td>
                                                <td>{{$invoice->discount}}</td>
                                                <td>{{$invoice->rate_vat}}</td>
                                                <td>{{$invoice->value_vat}}</td>
                                                <td>{{$invoice->total}}</td>
                                                <td>
                                                    @if ($invoice->value_status == 1)
                                                    <span class="badge badge-pill badge-success">{{$invoice->status}}</span>
                                                    @elseif ($invoice->value_status == 2)
                                                    <span class="badge badge-pill badge-danger">{{$invoice->status}}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-warning">{{$invoice->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$invoice->note}}</td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example2" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                <th class="wd-20p border-bottom-0">القسم</th>
                                                <th class="wd-15p border-bottom-0">المنتج</th>
                                                <th class="wd-10p border-bottom-0">الحالة</th>
                                                <th class="wd-10p border-bottom-0">تاريخ الدفع</th>
                                                <th class="wd-10p border-bottom-0">تاريخ الاضافة</th>
                                                <th class="wd-25p border-bottom-0">المستخدم</th>
                                                <th class="wd-25p border-bottom-0">ملاحظات</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $i = 0;
                                            @endphp
                                            @foreach ($invoice_details as $invoice_detail)
                                            @php
                                            $i++;
                                            @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$invoice_detail->invoice_number}}</td>
                                                <td>{{$invoice_detail->sec->section_name}}</td>
                                                <td>{{$invoice_detail->product}}</td>
                                                <td>
                                                    @if ($invoice_detail->value_status == 1)
                                                    <span class="badge badge-pill badge-success">{{$invoice_detail->status}}</span>
                                                    @elseif ($invoice_detail->value_status == 2)
                                                    <span class="badge badge-pill badge-danger">{{$invoice_detail->status}}</span>
                                                    @else
                                                    <span class="badge badge-pill badge-warning">{{$invoice_detail->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$invoice_detail->payment_date}}</td>
                                                <td>{{$invoice->invoice_date}}</td>
                                                <td>{{$invoice_detail->user}}</td>
                                                <td>{{$invoice_detail->note}}</td>

                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <div class="col-xl-12">
                        <div class="card">
                            @can('اضافة مرفق')
                            <div class="card-body">
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ url('/InvoiceAttachments') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name" required>
                                        <input type="hidden" id="customFile" name="invoice_number" value="{{ $invoice->invoice_number }}">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm " name="uploadedFile">تاكيد</button>
                                </form>
                            </div>
                            @endcan
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example3">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">اسم الملف</th>
                                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                <th class="wd-15p border-bottom-0">تاريخ الاضافة</th>
                                                <th class="wd-15p border-bottom-0">المستخدم</th>
                                                <th class="wd-15p border-bottom-0">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 0;
                                            @endphp
                                            @foreach ($invoice_attachments as $invoice_attachment)
                                                @php
                                                $i++;
                                                @endphp
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$invoice_attachment->file_name}}</td>
                                                    <td>{{$invoice_attachment->invoice_number}}</td>
                                                    <td>{{$invoice_attachment->created_at}}</td>
                                                    <td>{{$invoice_attachment->created_by}}</td>
                                                    <td>
                                                        <a class="modal-effect btn btn-sm btn-success" href="{{url('view_file')}}/{{$invoice_attachment->invoice_number}}/{{$invoice_attachment->file_name}}" title="عرض">عرض</a>
                                                        <a class="modal-effect btn btn-sm btn-primary" href="{{url('download_file')}}/{{$invoice_attachment->invoice_number}}/{{$invoice_attachment->file_name}}" title="تحميل">تحميل</a>
                                                        @can('حذف المرفق')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id_file="{{ $invoice_attachment->id }}" data-file_name="{{$invoice_attachment->file_name}}" data-invoice_number="{{$invoice_attachment->invoice_number}}" data-toggle="modal" href="#attachment_delete" title="حذف">حذف</a>
                                                        @endcan
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
            </div>
        </div>
    </div>



    <div class="modal" id="attachment_delete">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('delete_file')}}" method="POST">
                    {{ method_field('DELETE') }}
                    @csrf
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" class="form-control" name="id_file" id="id_file" value="" placeholder="ID">
                        <input type="hidden" class="form-control" name="file_name" id="file_name" placeholder="File Name">
                        <input type="hidden" class="form-control" name="invoice_number" id="invoice_number" placeholder="Invoice Number">
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
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable();
        }
        if (!$.fn.DataTable.isDataTable('#example2')) {
            $('#example2').DataTable();
        }
        if (!$.fn.DataTable.isDataTable('#example3')) {
            $('#example3').DataTable();
        }
    });
</script>
<script>
    $('#attachment_delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_file = button.data('id_file')
        var file_name = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    })
</script>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

@endsection