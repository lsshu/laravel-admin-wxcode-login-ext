<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/6/29
 * Time: 16:52
 */
?>
@extends('code_login::layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <h4 style="text-align: center">后台账户信息注册</h4>
            <div class="col-md-8">
                <form>
                    <div class="form-group">
                        <label for="username">登录名</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-heart"></span></span>
                            <input type="text" name="username" class="form-control" id="username" placeholder="UserName:zhangsan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name:张三">
                        </div>
                    </div>
                    <button type="button" class="btn btn-info">注册</button>
                </form>
                <p style="text-align: right;color: red">请认真填写每一项信息。</p>
            </div>
            <div class="col-md-4">
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('button:button').click(function () {
                var username = $('input[name="username"]');
                var name = $('input[name="name"]');
                if(username.val() == ''){
                    username.focus();
                    toastr.warning('登录名不能为空！');
                    return false;
                }
                if(!/^[A-Za-z0-9]+$/.test(username.val())){
                    username.focus();
                    toastr.warning('登录名必需是字母和数字！');
                    return false;
                }

                if(name.val() == ''){
                    name.focus();
                    toastr.warning('姓名不能为空！');
                    return false;
                }
                if(!/^[\u4E00-\u9FA5]{1,5}$/.test(name.val())){
                    name.focus();
                    toastr.warning('姓名必需是中文！');
                    return false;
                }

                $.post("",{username:username.val(),name:name.val(),_token:"{{csrf_token()}}"},function(Msg){
                    try {
                        if(Msg.status == 'success'){
                            toastr.success('注册或者更新成功！正在跳转！');
                            setTimeout(function () {
                                location.href = '{{$redirect_url ?? ""}}';
                            },2000);
                        }else{
                            toastr.error('注册失败！');
                        }
                    }catch (e) {
                        toastr.error('请求失败！');
                    }

                });
            });
        });
    </script>
@endsection
