@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มอุตสาหกรรมเป้าหมาย</h3>
                    @can('view-'.str_slug('industry_target'))
                        <a class="btn btn-success pull-right" href="{{url('/basic/industry_target')}}">
                            <i class="icon-arrow-left-circle"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => '/basic/industry_target', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('basic.industry_target.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
