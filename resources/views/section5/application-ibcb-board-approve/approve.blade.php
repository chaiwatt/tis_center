@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">บันทึกผลเสนอคณะอนุกรรมการ IB/CB #{{ $applicationibcb->id }}</h3>
                        <a class="btn btn-success pull-right" href="{{ url('/section5/application-ibcb-board-approve') }}">
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

                    {!! Form::model($applicationibcb, [
                        'method' => 'PATCH',
                        'url' => ['/section5/application-ibcb-board-approve/approve-save', $applicationibcb->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}


                    @include ('section5.application-ibcb-board-approve.form', ['submitButtonText' => 'Update'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function() {

            //ปิดฟอร์ม ผลเสนอ กมอ.
            $('#box-result').remove();

        });

    </script>
@endpush
