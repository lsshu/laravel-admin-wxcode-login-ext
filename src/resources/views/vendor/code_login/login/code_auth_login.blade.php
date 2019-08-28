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
    <div class="container" style="text-align: center">
        <h3>{{$content}}</h3>
        <p style="color:red">{{$description}}</p>
    </div>
@endsection
