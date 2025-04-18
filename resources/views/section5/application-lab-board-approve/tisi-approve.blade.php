@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">บันทึกผลเสนอ กมอ. (LAB) #{{ $applicationlab->id }}</h3>
                        <a class="btn btn-success pull-right" href="{{ url('/section5/application-lab-board-approve') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ</a>

                    <div class="clearfix"></div>
                    <hr>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($applicationlab, [
                        'method' => 'PATCH',
                        'url' => ['/section5/application-lab-board-approve/tisi-approve-save', $applicationlab->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('section5.application-lab-board-approve.form', ['submitButtonText' => 'Update'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function() {
            //ปิดฟอร์ม ผลเสนอคณะอนุกรรมการ
            $('#box-approve').find('button[type="submit"]').closest('.row').remove();//กรอบบันทึก/ยกเลิก
            $('#box-approve').find('button[type="button"]').remove();//ปุ่มเพิ่ม/ลบ ไฟล์
            $('#box-approve').find('input[type="radio"]:not(:checked)').prop('disabled', true);
            $('#box-approve').find('input[type="text"], input[type="file"], textarea').prop('disabled', true);
            $('#box-approve').find('.show_tag_a').hide();

        });

    </script>
@endpush
