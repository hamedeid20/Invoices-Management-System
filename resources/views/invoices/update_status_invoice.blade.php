@extends('layouts.master')
@section('title')
Update Invoice
@endsection
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
اضافة فاتورة
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة فاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (session()->has('Update'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Update') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- row -->
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('status_update', ['id' => $invoice->id ]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @METHOD('patch')
                    {{ csrf_field() }}
                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <!-- <input type="hidden" name="invoice_id" value="{{$invoice->id}}"> -->
                            <label for="inputName" class="control-label">رقم الفاتورة</label>
                            <input type="text" class="form-control" id="inputName" name="invoice_number" title="يرجي ادخال رقم الفاتورة" value="{{$invoice->invoice_number}}" readonly required>
                        </div>

                        <div class="col">
                            <label>تاريخ الفاتورة</label>
                            <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoice->invoice_date }}" required readonly>
                        </div>

                        <div class="col">
                            <label>تاريخ الاستحقاق</label>
                            <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoice->due_date}}" required readonly>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">القسم</label>
                            <select name="section" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')" readonly>
                                <!--placeholder-->
                                <option value="{{ $invoice->section_id}}" selected> {{ $invoice->section->section_name}} </option>


                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">المنتج</label>
                            <select id="product" name="product" class="form-control" readonly>
                                <option value="{{$invoice->product}}">{{$invoice->product}}</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ التحصيل</label>
                            <input type="text" class="form-control" id="inputName" name="amount_collection" value="{{$invoice->amount_collection}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ العمولة</label>
                            <input type="text" class="form-control form-control-lg" id="Amount_Commission" name="amount_commission" title="يرجي ادخال مبلغ العمولة " value="{{$invoice->amount_commission}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الخصم</label>
                            <input type="text" class="form-control form-control-lg" id="Discount" name="discount" title="يرجي ادخال مبلغ الخصم " value="{{$invoice->discount}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value=0 required readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                            <select name="rate_vat" id="Rate_VAT" class="form-control" onchange="myFunction()" readonly>
                                <!--placeholder-->
                                @php
                                $selectedRateVat = $invoice->rate_vat;
                                $options = ['5%', '10%'];
                                @endphp
                                <option value="" disabled>حدد نسبة الضريبة</option>

                                @foreach ($options as $option)
                                <option value="{{$option}}" {{$selectedRateVat == $option ? 'selected' : ''}}>{{$option}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" class="form-control" id="Value_VAT" name="value_vat" value="{{ $invoice->value_vat}}" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                            <input type="text" class="form-control" id="Total" name="total" value="{{ $invoice->total}}" readonly>
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">ملاحظات</label>
                            <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>{{$invoice->note}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">حالة الدفع</label>
                            <select id="payment_status" name="payment_status" class="form-control" >
                                <option value="مدفوعة">مدفوعة</option>
                                 <option value="مدفوعة جزئيا">مدفوعة جزئيا</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>تاريخ الدفع</label>
                            <input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD" type="text" required>
                        </div>
                        
                    </div>
                    <br>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                    </div>


                </form>
            </div>
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
<!-- Internal Select2 js-->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<!--Internal Fancy uploader js-->
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<!--Internal  Form-elements js-->
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<!--Internal Sumoselect js-->
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>

<script>
    $(document).ready(function() {
        $('select[name="section"]').on('change', function() {
            var SectionId = $(this).val();
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="product"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="product"]').append('<option value="' +
                                value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });

    });
</script>


<script>
    function myFunction() {

        var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
        var Discount = parseFloat(document.getElementById("Discount").value);
        var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
        var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);

        var Amount_Commission2 = Amount_Commission - Discount;


        if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {

            alert('يرجي ادخال مبلغ العمولة ');

        } else {
            var intResults = Amount_Commission2 * Rate_VAT / 100;

            var intResults2 = parseFloat(intResults + Amount_Commission2);

            sumq = parseFloat(intResults).toFixed(2);

            sumt = parseFloat(intResults2).toFixed(2);

            document.getElementById("Value_VAT").value = sumq;

            document.getElementById("Total").value = sumt;

        }

    }
</script>


@endsection