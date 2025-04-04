@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
    <style>
        .font_size{
            font-size: 14px;
        }

        .label-height{
            line-height: 16px;
        }
    </style>
@endpush

<input type="hidden" id="id" value="{!! $certificate->id !!}">
<input type="hidden" name="certificate_type" id="certificate_type" value="{!! $certificate->certificate_type !!}">
<input type="hidden" name="certificate_id" id="certificate_id" value="{!! $certificate->certificate_id !!}">

<!-- ประเภทใบรับรอง 1-CB , 2-IB , 3-LAB -->
@if( in_array($certificate->certificate_type, [1]) )
    @include('cerreport.system-certification.form.cb')
@elseif( in_array($certificate->certificate_type, [2]) )
    @include('cerreport.system-certification.form.ib')
@elseif( in_array($certificate->certificate_type, [3]) )
    @include('cerreport.system-certification.form.lab')
@endif

@include('cerreport.system-certification.contract-modal')

<center>
    <div class="form-group">
        @can('view-'.str_slug('cerreport-system-certification'))
            <button class="btn btn-outline btn-success show_tag_a" type="button" id="btn_example">
                <i class="fa fa-file-text-o"></i> แสดงตัวย่าง
            </button>
        @endcan
        {{-- @can('edit-'.str_slug('cerreport-system-certification'))
            <button class="btn btn-outline btn-primary show_tag_a" type="button" id="btn_save">
                <i class="fa fa-save"></i> บันทึกและลงนาม
            </button>
        @endcan --}}
        <a class="btn btn-default show_tag_a" href="{{url('cerreport/system-certification')}}">
            <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
    </div>
</center>

@push('js')
    <script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
    <script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/mask/mask.init.js')}}"></script>
    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
        $(document).ready(function () {

		$('#ContractModal').wrap("<form id='validateForm'></form>");
		var form = $('#validateForm:first').parsley();

            @if ( \Session::has('success_message'))
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                language:'th-th',
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy'
            });

            //บันทึกและลงนาม
            $('body').on('click', '#btn_save', function(){
          
                Swal.fire({
                    title: 'ยืนยันการส่งลงนามใหม่',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2ecc71',
                    cancelButtonColor: '#e74a25',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('#MyForm').submit();

                    }
                });


            });

            //แสดงตัวย่าง
            $('body').on('click', '#btn_example', function(){
                let formData = $('#MyForm input').not("input[name='_method'],input[name='_token'] ").serialize();
                var url      = "{!! url('/') !!}"+'/cerreport/system-certification/preview?'+formData;
                window.open(url,'_blank');
            });
            
            $('#ContractModal').on('shown.bs.modal', function () {
                $('#ContractModal').find('input, select').prop('disabled', false).not('.not_valid').prop('required', true);
            });
            
            $('#ContractModal').on('hide.bs.modal', function () {
                $('#ContractModal').find('input, select').prop('disabled', true).prop('required', false);
            });

            $('body').on('click', '#save-modal', function(){
                form.validate();
                if(form.isValid()){
                    on_saving();
                    let data = $('#ContractModal input, select').serialize() + '&' + $.param({
                        _token: "{{ csrf_token() }}",
                        certificate_type: $('#certificate_type').val()
                    });
                    $.ajax({
                        method: "PATCH",
                        url: "{{ url('cerreport/system-certification/save-modal/'.$certificate->id) }}",
                        dataType: "json",
                        data: data,
                        success: function(res) {
                            
                        }
                    }).done(function(response) {
                        if(response.status == 'success'){
                            if(!!response.data){
                                let data = response.data;
                                $('.contact_name').val(data.contact_name);
                                $('.contact_tel').val(data.contact_tel);
                                $('.contact_mobile').val(data.contact_mobile);
                                $('.contact_email').val(data.contact_email);
                            }
                            $.LoadingOverlay("hide");
                            alert_success();
                            $('#ContractModal').modal('hide');
                            form.destroy();
                        }else{
                            console.log(response.message);
                            $.LoadingOverlay("hide");
                            alert_error();
                            form.destroy();
                        }
                    });
                }
            });

        });

        function alert_success(title="ดำเนินการสำเร็จ", text=''){
            Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        }
        
        function alert_error(title="ดำเนินการไม่สำเร็จ", text=''){
            Swal.fire({
                icon: 'error',
                title: title,
                text: text
            });
        }
        
        function on_saving(text="กำลังบันทึก..."){
            $.LoadingOverlay("show", {
                image       : "",
                text        : text
            });
        }

        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }

    </script>
@endpush