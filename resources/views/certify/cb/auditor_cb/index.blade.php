@extends('layouts.master')

@push('css')

<style>

  .label-filter{
    margin-top: 7px;
  }
  /*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
	@media
	  only screen
    and (max-width: 760px), (min-device-width: 768px)
    and (max-device-width: 1024px)  {

		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr {
			display: block;
		}

		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

    tr {
      margin: 0 0 1rem 0;
    }

    tr:nth-child(odd) {
      background: #eee;
    }

		td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
		}

		td:before {
			/* Now like a table header */
			/*position: absolute;*/
			/* Top/left values mimic padding */
			top: 0;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
		}

		/*
		Label the data
    You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
		*/
		/*td:nth-of-type(1):before { content: "Column Name"; }*/

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แต่งตั้งคณะผู้ตรวจประเมิน (CB)</h3>

                    <div class="pull-right">

                      {{-- @can('edit-'.str_slug('auditorcb'))

                          <a class="btn btn-success btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(1);">
                            <span class="btn-label"><i class="fa fa-check"></i></span><b>เปิด</b>
                          </a>

                          <a class="btn btn-danger btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(0);">
                            <span class="btn-label"><i class="fa fa-close"></i></span><b>ปิด</b>
                          </a>

                      @endcan --}}

                      @can('add-'.str_slug('auditorcb'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/certify/auditor-cb/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      {{-- @can('delete-'.str_slug('auditorcb'))
                          <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                          </a>
                      @endcan --}}

                    </div>

           
                    <div class="clearfix"></div>
                    <hr>

                    {!! Form::model($filter, ['url' => '/certify/auditor-cb', 'method' => 'get', 'id' => 'myFilter']) !!}
                    <div class="row">
                      <div class="col-md-4 form-group">
                            {!! Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']) !!}
                            <div class="form-group col-md-10">
                              {!! Form::select('filter_status', 
                                 ['0'=>'ขอความเห็นการแต่งตั้งคณะผู้ตรวจประเมิน',
                                  '1'=>'เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน',
                                  '2'=>'ไม่เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน'],
                                null,
                                ['class' => 'form-control',
                                'id'=>'filter_status',
                                'placeholder'=>'-เลือกสถานะ-']) !!}
                           </div>
                      </div><!-- /form-group -->
                      {{-- <div class="col-md-2">
                          <div class="form-group">
                              <button type="button" class="btn btn-primary waves-effect waves-light" data-parent="#capital_detail" href="#search-btn" data-toggle="collapse" id="search_btn_all">
                                  <small>เครื่องมือค้นหา</small> <span class="glyphicon glyphicon-menu-up"></span>
                              </button>
                          </div>
                      </div> --}}
     
                      <div class="col-md-6">
                              {!! Form::label('filter_tb3_Tisno', 'เลขที่คำขอ:', ['class' => 'col-md-3 control-label label-filter text-right']) !!}
                              <div class="form-group col-md-5">
                              {!! Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'','id'=>'filter_search']); !!}
                            </div>
                              <div class="form-group col-md-4">
                                  {!! Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']) !!}
                                  <div class="col-md-8">
                                      {!! Form::select('perPage', 
                                      ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100',
                                       '500'=>'500'], null, ['class' => 'form-control']); !!}
                                  </div>
                              </div>
                      </div><!-- /.col-lg-5 -->
                      <div class="col-md-2">
                        <div class="form-group  pull-left">
                            <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                        </div>

                        <div class="form-group  pull-left m-l-15">
                            <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                ล้าง
                            </button>
                        </div>
                    </div><!-- /.col-lg-1 -->
                  </div><!-- /.row -->
 
                <input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
                <input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

               {!! Form::close() !!}
               <div class="clearfix"></div>

                        <table class="table table-borderless" id="myTable">
                            <thead>
                              <tr>
                                <th class="text-center" width="1%">#</th>
                                <th class="text-center" width="10%">เลขที่คำขอ</th>
                                <th class="text-center" width="10%">คณะผู้ตรวจประเมิน</th>
                                <th class="text-center" width="10%">วันที่ตรวจประเมิน</th>
                                <th class="text-center" width="10%">สถานะ</th>
                                <th class="text-center" width="10%">วันที่บันทึก</th>
                                <th class="text-center" width="10%">ผู้บันทึก</th>
                                <th class="text-center" width="10%">เครื่องมือ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($auditors as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $auditors->perPage() ) }}</td>
                                    <td>
                                        {{  $item->CertiCbCostTo->app_no ?? '-'  }}
                                        @if (!is_null($item->reason_cancel))
                                        <br> <span class="text-danger" title="{{$item->reason_cancel  }}">ยกเลิกคณะผู้ตรวจ</span>
                                       @endif
                                  </td>
                                  <td>
                                    {{  $item->auditor ?? '-'  }}
                              </td>
                                  <td>
                              
                                    {{  $item->CertiCBAuditorsDateTitle ?? '-'  }}
                                </td>
                                  <td>{{ !empty($item->StatusTitle) ? $item->StatusTitle : '-' }}</td>
                                  <td>{{ HP::DateThai($item->created_at) }}</td>
                                  <td>
                                      {{  $item->UserTo->FullName ?? '-'  }}  
                                  </td>
                                  <td  >
                                        @can('edit-'.str_slug('auditorcb'))
                                          <a href="{{ url('certify/auditor-cb/'.$item->id.'/edit') }}" class="btn btn-light btn-primary">
                                            <i class="fa fa-pencil-square-o"></i>
                                          </a>
                                        @endcan
            
                                  @if (is_null($item->CertiCBPayInOneTo)   && $item->status_cancel != 1  || (auth()->user()->isAdmin() === true   && $item->status_cancel != 1))
                                      @can('delete-'.str_slug('auditorcb'))
                                        <button class="btn btn-danger" data-toggle="modal"
                                                                    data-target="#modalDelete{{$item->id}}"
                                        >
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                         @include ('certify/cb/auditor_cb.modaldelete',['id'=>$item->id])
                                      @endcan
                                  @endif
                                  </td>
                                </tr>
                             @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $auditors->appends(['search' => Request::get('search'),
                                                      'sort' => Request::get('sort'),
                                                      'direction' => Request::get('direction'),
                                                      'perPage' => Request::get('perPage'),
                                                      'filter_status' => Request::get('filter_status'),
                                                      'filter_search' => Request::get('filter_search'),
                                                      'filter_state' => Request::get('filter_state')
                                                     ])->render()
                          !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>

    <script>
        $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                window.location.assign("{{url('/certify/auditor-cb')}}");
            });
            @if(\Session::has('flash_message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{session()->get('flash_message')}}',
                    loaderBg: '#33ff33',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            @if(\Session::has('message_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '{{session()->get('message_error')}}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif
            //เลือกทั้งหมด
            $('#checkall').change(function(event) {

              if($(this).prop('checked')){//เลือกทั้งหมด
                $('#myTable').find('input.cb').prop('checked', true);
              }else{
                $('#myTable').find('input.cb').prop('checked', false);
              }

            });

        });

        function Delete(){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
            if(confirm_delete()){
              $('#myTable').find('input.cb:checked').appendTo("#myForm");
              $('#myForm').submit();
            }
          }else{//ยังไม่ได้เลือก
            alert("กรุณาเลือกข้อมูลที่ต้องการลบ");
          }

        }

        function confirm_delete() {
            return confirm("ยืนยันการลบข้อมูล?");
        }

        function UpdateState(state){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
              $('#myTable').find('input.cb:checked').appendTo("#myFormState");
              $('#state').val(state);
              $('#myFormState').submit();
          }else{//ยังไม่ได้เลือก
            if(state=='1'){
              alert("กรุณาเลือกข้อมูลที่ต้องการเปิด");
            }else{
              alert("กรุณาเลือกข้อมูลที่ต้องการปิด");
            }
          }

        }

    </script>

@endpush
