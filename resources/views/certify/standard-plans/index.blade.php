@extends('layouts.master')

@push('css')
<link rel="stylesheet" href="{{asset('plugins/components/jquery-datatables-editable/datatables.css')}}" />
<link href="{{asset('plugins/components/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<style>
.pointer {cursor: pointer;}
</style>
@endpush


@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">จัดทำแผนการกำหนดมาตรฐานการตรวจสอบและรับรอง</h3>

                    <div class="pull-right">

                     {{--  @can('edit-'.str_slug('standardplans'))
 

                        <button class="btn btn-success btn-sm btn-outline waves-effect waves-light"   type="button"
                        id="publish">
                            <span class="btn-label"><i class="fa fa-check"></i></span><b>เปิด</b>
                        </button>

                        <button class="btn btn-danger btn-sm btn-outline waves-effect waves-light"  type="button"
                        id="no_publish">
                            <span class="btn-label"><i class="fa fa-close"></i></span><b>ปิด</b>
                        </button>

                      @endcan

                      @can('add-'.str_slug('standardplans'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/certify/standard-plans/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      @can('delete-'.str_slug('standardplans'))
                        <button class="btn btn-danger btn-sm waves-effect waves-light"  type="button"
                        id="bulk_delete">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ปิด</b>
                        </button>
                      @endcan  --}}

                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <div class="row ">
                      <div class="col-md-5 form-group">
                        <div class=" {{ $errors->has('filter_search') ? 'has-error' : ''}}">
                            {!! Form::label('filter_search', 'คำค้น'.' :', ['class' => 'col-md-3 control-label text-right ']) !!}
                            <div class="col-md-9">
                                {!! Form::text('filter_search', null,  ['id' => 'filter_search','class' => 'form-control']) !!}
                            </div>
                         </div>
                      </div><!-- /.col-md-4 -->
                      <div class="col-md-5">
                        <div class=" {{ $errors->has('filter_year') ? 'has-error' : ''}}">
                          {!! Form::label('filter_year', 'ร่างแผนปี'.' :', ['class' => 'col-md-3 control-label text-right ']) !!}
                          <div class="col-md-9">
                              {!! Form::select('filter_year',
                                  HP::Years(), 
                                null, 
                                ['class' => 'form-control', 
                                'id'=>'filter_year',
                                'placeholder' => '-- เลือกร่างแผนปี --']); !!}
                          </div>
                       </div>
                    </div><!-- /.col-md-1 -->
                      <div class="col-md-2"> </div><!-- /.col-md-1 -->
                  </div><!-- /.row -->

  
                  <div class="row ">
                    <div class="col-md-5 form-group ">
                      <div class=" {{ $errors->has('filter_standard_type') ? 'has-error' : ''}}">
                          {!! Form::label('filter_standard_type', 'ประเภท'.' :', ['class' => 'col-md-3 control-label text-right ']) !!}
                          <div class="col-md-9">
                                  {!! Form::select('filter_standard_type',
                                  App\Models\Bcertify\Standardtype::orderbyRaw('CONVERT(title USING tis620)')->pluck('title', 'id'), 
                                  null,
                                  ['class' => 'form-control',
                                  'id'=>'filter_standard_type',
                                  'placeholder'=>'-- เลือกประเภท --']) 
                              !!}
                          </div>
                       </div>
                    </div><!-- /.col-md-4 -->
                    <div class="col-md-5">
                      <div class=" {{ $errors->has('filter_method_id') ? 'has-error' : ''}}">
                        {!! Form::label('filter_method_id', 'วิธีการ'.' :', ['class' => 'col-md-3 control-label text-right ']) !!}
                        <div class="col-md-9">
                              {!! Form::select('filter_method_id',
                                  App\Models\Basic\Method::orderbyRaw('CONVERT(title USING tis620)')->pluck('title', 'id'), 
                                  null,
                                  ['class' => 'form-control',
                                  'id'=>'filter_method_id',
                                   'placeholder'=>'-- เลือกวิธีการ --']) 
                              !!}
                        </div>
                     </div> 
                  </div><!-- /.col-md-1 -->
                    <div class="col-md-2"> </div><!-- /.col-md-1 -->
                </div><!-- /.row -->

  
                <div class="row  ">
                  <div class="col-md-5 form-group ">
                    <div class=" {{ $errors->has('filter_status') ? 'has-error' : ''}}">
                        {!! Form::label('filter_status', 'สถานะ'.' :', ['class' => 'col-md-3 control-label text-right ']) !!}
                        <div class="col-md-9">
                            {!! Form::select('filter_status',
                          ['1'=>'ร่างแผน', '2'=>'อยู่ระหว่างจัดทำแผน', '3'=>'นำส่งแผน', '4'=>'บรรจุแผน', '5'=>'ไม่อนุมัติแผน', '6'=>'แจ้งแก้ไขแผน'], 
                          null, 
                          ['class' => 'form-control', 
                          'id'=>'filter_status',
                          'placeholder' => '-- เลือกสถานะ --']); !!}
                        </div>
                     </div>
                  </div><!-- /.col-md-4 -->
                  <div class="col-md-5 ">  </div><!-- /.col-md-1 -->
                  <div class="col-md-2">
                      <div class="  pull-left">
                          <button type="button" class="btn btn-info waves-effect waves-light" id="button_search"  style="margin-bottom: -1px;">ค้นหา</button>
                      </div>
                      <div class="  pull-left m-l-15">
                          <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                              ล้าง
                          </button>
                      </div>
                  </div><!-- /.col-md-1 -->
              </div><!-- /.row -->

    
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped" id="myTable">
                            <thead>
                            <tr>
                                <th width="1%" class="text-center">#</th>
                                {{-- <th  width="1%" ><input type="checkbox" id="checkall"></th> --}}
                                <th width="10%" class="text-center">ร่างแผนปี</th>
                                <th width="20%" class="text-center">ประเภทมาตรฐาน</th>
                                <th  width="15%" class="text-center">ชื่อมาตรฐาน</th>
                                <th width="10%" class="text-center">วิธีการ</th>
                                <th width="15%" class="text-center">ช่วงเวลาดำเนินการ</th>
                                <th width="15%" class="text-center">สถานะ</th>
                                <th width="10%" class="text-center">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
           
 



                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
<script src="{{asset('plugins/components/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('plugins/components/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/components/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/components/datatables/dataTables.bootstrap.js')}}"></script>
   <!-- input calendar thai -->
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
   <!-- thai extension -->
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
        $(document).ready(function () {


            //ช่วงวันที่
            $('.date-range').datepicker({
              toggleActive: true,
              language:'th-th',
              format: 'dd/mm/yyyy',
            });

            @if(\Session::has('flash_message'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('flash_message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            @endif
            
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{!! url('/certify/standard-plans/data_list') !!}',
                    data: function (d) {
                      
                        d.filter_search = $('#filter_search').val();
                        d.filter_year = $('#filter_year').val();
                        d.filter_standard_type = $('#filter_standard_type').val();
                        d.filter_method_id = $('#filter_method_id').val();
                        d.filter_status = $('#filter_status').val();
                    }
                },
                columns: [
                    { data: 'DT_Row_Index', searchable: false, orderable: false},
                    // { data: 'checkbox', searchable: false, orderable: false},
                    { data: 'draft_year', name: 'draft_year' },
                    { data: 'standard_type', name: 'standard_type' },
                    { data: 'tis_name', name: 'tis_name' }, 
                    { data: 'method', name: 'method' },
                    { data: 'plan_date', name: 'plan_date' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' },
                ],
                columnDefs: [
                    { className: "text-center", targets:[0,-1] }
                ],
                fnDrawCallback: function() {
                    $('#myTable_length').find('.totalrec').remove();
                    var el = ' <span class=" totalrec" style="color:green;"><b>(ทั้งหมด '+ Comma(table.page.info().recordsTotal) +' รายการ)</b></span>';
                    $('#myTable_length').append(el);
                }
            });



            $( "#button_search" ).click(function() {
                 table.draw();
            });

            $( "#filter_clear" ).click(function() {
              $('#filter_search').val('');
              $('#filter_year').val('').select2();
              $('#filter_standard_type').val('').select2();
              $('#filter_method_id').val('').select2();
              $('#filter_status').val('').select2();
              table.draw();
 
           });
 
           $('#checkall').change(function (event) {

                if ($(this).prop('checked')) {//เลือกทั้งหมด
                    $('#myTable').find('input.item_checkbox').prop('checked', true);
                } else {
                    $('#myTable').find('input.item_checkbox').prop('checked', false);
                }

         });


            //เลือกสถานะ เปิด-ปิด
            $('#myTable tbody').on('click', '.js-state', function(){
                var id = $(this).data('id');
          
                var state = $(this).data('state');
                
                $.ajax({
                    method: "POST",
                        url: "{{ url('/certify/standard-plans/update_status') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "state": state
                    },
                    success : function (msg){
                        if (msg == "success") {
                        table.draw();

                        $.toast({
                            heading: 'Success!',
                            position: 'top-center',
                            text: 'บันทึกสำเร็จ',
                            loaderBg: '#70b7d6',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
  
                        }
                    }
                });

            });

 
             //เลือกเปิด-ปิด
            $('#publish, #no_publish').on('click', function () {

                    if($(this).attr('id')=='publish'){
                        var text_alert = 'เปิด';
                        var state = 1;
                    }else if($(this).attr('id')=='no_publish'){
                        var text_alert = 'ปิด';
                        var state = 0;
                    }

                    var arrRowId = [];

                    //Iterate over all checkboxes in the table
                    table.$('.item_checkbox:checked').each(function (index, rowId) {
                        arrRowId.push(rowId.value);
                    });

                    if (arrRowId.length > 0) {

                        if (confirm("ยืนยันการ"+text_alert+" " + arrRowId.length + " แถว นี้ ?")) {

                            $.ajax({
                                method: "POST",
                                url: "{{ url('/certify/standard-plans/update_publish') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id_publish": arrRowId,
                                    "state": state
                                },
                                success : function (msg){
                                    if (msg == "success") {
                                        table.draw();
                                        if(text_alert == 'เปิด'){
                             
                                        $.toast({
                                                heading: 'Success!',
                                                position: 'top-center',
                                                text: 'เปิดการใช้งาน !',
                                                loaderBg: '#70b7d6',
                                                icon: 'success',
                                                hideAfter: 3000,
                                                stack: 6
                                            });

                                        }else{
                                
                                            $.toast({
                                                heading: 'Success!',
                                                position: 'top-center',
                                                text: 'ปิดการใช้งาน !',
                                                loaderBg: '#70b7d6',
                                                icon: 'success',
                                                hideAfter: 3000,
                                                stack: 6
                                            });


                                        }
                                        $('#checkall').prop('checked',false );
                                    }
                                }
                            });
                        }

                    }else {
                        alert("โปรดเลือกอย่างน้อย 1 รายการ");
                    }
            });
 

            //เลือกลบ
            $(document).on('click', '#bulk_delete', function(){

                var id = [];
                $('.item_checkbox:checked').each(function(index, element){
                    id.push($(element).val());
                });

                if(id.length > 0){

                    if (confirm("ยืนยันการลบข้อมูล " + id.length + " แถว นี้ ?")) {
                        $.ajax({
                                type:"POST",
                                url:  "{{ url('/certify/standard-plans/delete') }}",
                                data:{
                                    _token: "{{ csrf_token() }}",
                                    id: id
                                },
                                success:function(data){
                                    table.draw();
                                    toastr.success('ลบสำเร็จ !');
                                    $('#checkall').prop('checked', false);
                                }
                        });
                    }

                }else{
                    alert("โปรดเลือกอย่างน้อย 1 รายการ");
                }
            });
 
 });

        
  function confirm_delete() {
       return confirm("ยืนยันการลบข้อมูล?");
   }

      
        function Comma(Num)
        {
            Num += '';
            Num = Num.replace(/,/g, '');

            x = Num.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
            return x1 + x2;
        }

    </script>

@endpush
