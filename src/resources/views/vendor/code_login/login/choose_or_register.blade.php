<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/6/11
 * Time: 下午3:34
 */
?>
@extends('code_login::layouts.main')
@section('content')
    <div class="container"  style="text-align: center">
        <h3>{{$content}}</h3>
        <p>{{$description}}</p>
    </div>
@endsection
@section('script')
    <script>
        setTimeout(function () {
            location.href = '{{$redirect_url}}';
        },5000)
    </script>
@endsection