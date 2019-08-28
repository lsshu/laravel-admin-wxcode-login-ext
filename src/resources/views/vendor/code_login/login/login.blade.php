<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/5/31
 * Time: 上午9:51
 */
?>
@extends('code_login::layouts.main',['title'=>'登录'])
@section('style')
    <style>
        .container{
            text-align: center;
            color:red;
        }
        .container>img{
            display: initial;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <img src="data:image/png;base64, {!! base64_encode($code ?? '') !!} "  class="img-responsive">
        <h3>等待扫码！请稍等！</h3>
        <p>扫码成功自动跳转！如长时间不跳转，请刷新本页面！</p>
    </div>
@endsection
@section('script')
    <script>
        ;(function () {
            var init = function(opt){
                this._initial(opt);
            };
            init.prototype  = {
                _initial:function(opt){
                    var that = this;
                    var o_time = setInterval(function(){
                        that.request('{{$check_login ?? ''}}').then(function (Msg) {
                            try{
                                if(Msg.status == 'success'){
                                    location.href = Msg.redirect;
                                }
                            }catch (e) {

                            }
                        })
                    },3000);
                    setTimeout(function(){
                        clearInterval(o_time);
                    },60000);
                },
                /**
                 * http request 请求
                 * @param {string} url 请求地址
                 * @param {string} data 请求数据（POST）
                 * @param {string} method 请求类型
                 * */
                request:function(url,data,method){
                    var that = this;
                    return new Promise(function(resolve, reject){
                        var xmlhttp;

                        if (window.XMLHttpRequest) {
                            /*IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码*/
                            xmlhttp=new XMLHttpRequest();
                        }else {
                            /*IE6, IE5 浏览器执行代码*/
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=(e)=>{
                            if (xmlhttp.readyState==4) {
                                if(xmlhttp.status==200){
                                    return resolve.call(that,JSON.parse(xmlhttp.responseText));
                                }else{
                                    return reject.call(that,JSON.parse(xmlhttp.responseText));
                                }
                            }
                        };
                        if(method =='POST'){
                            xmlhttp.open("POST",url);
                            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                        }else{
                            xmlhttp.open("GET",url);
                        }

                        if(typeof data!="undefined"){
                            var post_data_string = '';
                            for(var key in data){
                                post_data_string += key + '=' + data[key] + '&';
                            }
                            post_data_string = post_data_string.substring(0, post_data_string.length - 1);
                            xmlhttp.send(post_data_string);
                        }else{
                            xmlhttp.send();
                        }
                    });
                },
                polling:function(url,data,method,time){
                    var that = this;
                    let o_time = setInterval(function(){
                        return that.request(url,data,method);
                    },time);
                    setTimeout(function(){
                        clearInterval(o_time);
                    },60000)
                }
            };
            this.INIT = init;
        })();
        var init = new INIT();
    </script>
@endsection
