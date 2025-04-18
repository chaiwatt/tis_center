@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <!-- .row -->
  <div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title pull-left">ICS {{ $ics->id }}</h3>
        @can('view-'.str_slug('ics'))
        <a class="btn btn-success pull-right" href="{{ url('/basic/ics') }}">
          <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
        </a>
        @endcan
        <div class="clearfix"></div>
        <hr>
        <div class="table-responsive">
          <table class="table table">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $ics->id }}</td>
              </tr>
              <tr>
                <th> Code </th>
                <td> {{ $ics->code }} </td>
              </tr>
              <tr>
                <th> ชื่อ ICS </th>
                <td> {{ $ics->title }} </td>
              </tr>
              <tr>
                <th> ชื่อ ICS (EN) </th>
                <td> {{ $ics->title_en }} </td>
              </tr>
              <tr>
                <th> Category </th>
                <td> {{ $ics->category }} </td>
              </tr>
              <tr>
                <th> สถานะ </th>
                <td> {!! $ics->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
              </tr>
              <tr>
                <th> ผู้สร้าง </th>
                <td> {{ $ics->createdName }} </td>
              </tr>
              <tr>
                <th> วันเวลาที่สร้าง </th>
                <td> {{ HP::DateTimeThai($ics->created_at) }} </td>
              </tr>
              <tr>
                <th> ผู้แก้ไข </th>
                <td> {{ $ics->updatedName }} </td>
              </tr>
              <tr>
                <th> วันเวลาที่แก้ไข </th>
                <td> {{ HP::DateTimeThai($ics->updated_at) }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
