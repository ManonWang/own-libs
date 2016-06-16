<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>表单验证提交组件</title>
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/vendor/myplugin/css/request.css" rel="stylesheet">
    <style>
        input[type="file"] { width:30%; display:inline-block;}
    </style>
  </head>

  <body>
    <div class="container" id="container">
        <form class="form-horizontal" id="form-validate">
          <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="username">英文名</label>
            </div>
            <div class="col-xs-7">
                <input type="text" name="eusername" class="form-control" id="username" placeholder="2-10字符"
                       data-required="true" error-required="英文名不能为空"
                       data-conditional="remote" error-conditional="英文名已存在"  action="/index/remote"
                       desc-target="#desc-eusername"/>
            </div>
            <div id="desc-eusername" class="col-xs-3"></div>
          </div>
          <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="username">用户名</label>
            </div>
            <div class="col-xs-7">
                <input type="text" name="username" class="form-control" id="username" placeholder="2-10字符"
                       data-required="true" error-required="用户名不能为空"
                       data-conditional="length" error-conditional="长度为2~10个字符" min-len = "2" max-len = "10"
                       show-desc="true" desc-target="#desc-username"/>
            </div>
            <div id="desc-username" class="col-xs-3"></div>
          </div>
          <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="mobile">手机号</label>
            </div>
            <div class="col-xs-7">
                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="输入手机号"
                       data-required="true" error-required="手机号不能为空"
                       data-pattern="mobile" error-pattern="手机号码格式错误"
                       data-conditional="userFunc" error-conditional="自定义函数错误"
                       show-desc="true" desc-target="#desc-mobile"/>
            </div>
            <div id="desc-mobile" class="col-xs-3"></div>
          </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="email">邮箱</label>
            </div>
            <div class="col-xs-7">
               <input type="text" name="email" class="form-control" id="email" placeholder="123456789@qq.com"
                      data-required="true" error-required="邮箱不能为空"
                      data-pattern="email" error-pattern="邮箱格式错误"
                      data-conditional="length" error-conditional="不能超过50个字符" max-len="50" show-desc="false"/>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="age">年龄</label>
            </div>
            <div class="col-xs-7">
               <input type="text" name="age" class="form-control" id="age" placeholder="整数"
                      data-required="true" error-required="年龄不能为空" 
                      data-pattern="^[0-9]+$" error-pattern="请输入正确的年龄"
                      data-conditional="between" error-conditional="10-90之间" min-val="10" max-val="90"/>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="url">主页</label>
            </div>
            <div class="col-xs-7">
               <input type="text" name="url" class="form-control" id="url" placeholder="http://www.baidu.com"
                      data-required="true" error-required="主页不能为空" 
                      data-pattern="url" error-pattern="主页格式错误" 
                      data-conditional="length" max-len="255" min-len="20" error-conditional="长度为20-255" desc-target="#desc-url"/>
            </div>
            <div id="desc-url" class="col-xs-3"></div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="password">密码</label>
            </div>
            <div class="col-xs-10">
                <input type="password" name="password" class="form-control" id="password" placeholder="6-20个字符,大小写数字混合"
                       data-required="true" error-required="密码不能为空"
                       data-conditional="length" error-conditional="必须为6-20个字符" min-len="6" max-len="20"/>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="repassword">确认密码</label>
            </div>
            <div class="col-xs-10">
                <input type="password" name="repassword" class="form-control" id="repassword" placeholder="再次输入密码" 
                        data-required="true" error-required="密码不能为空" 
                        data-conditional="confirm" error-conditional="两次输入的密码不一致" confirm-target="#password"/>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="intro">个人简介</label>
            </div>
            <div class="col-xs-10">
                <textarea name="intro" id="intro" class="form-control" placeholder="一段中文介绍自己吧"
                    data-required="true" error-required="介绍不能为空"
                    data-pattern="word" error-pattern="必须为为中文" 
                    data-conditional="length" error-conditional="必须为6-20个字符" min-len="6" max-len="20"></textarea>
            </div>
         </div>

        <div class="form-group">
            <div class="col-xs-2 text-right">
                <label>个人爱好</label>
            </div>
            <div class="col-xs-7">
                <label for="hoppy_1"><input id="hoppy_1" type="checkbox" name="hoppy[]" value="1" data-conditional="groupRequired" error-conditional="请选择兴趣"> 篮球</label>
                <label for="hoppy_2"><input id="hoppy_2" type="checkbox" name="hoppy[]" value="2" data-conditional="groupRequired" error-conditional="请选择兴趣"> 足球</label>
                <label for="hoppy_3"><input id="hoppy_3" type="checkbox" name="hoppy[]" value="3" data-conditional="groupRequired" error-conditional="请选择兴趣"> 羽毛球</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-2 text-right">
                <label>性别</label>
            </div>
            <div class="col-xs-7">
                <label><input type="radio"  value="1" name="sex" data-required="true" error-required="兴趣不能为空" desc-target="#desc-sex"> 男</label>
                <label><input type="radio"  value="2" name="sex" data-required="true" error-required="兴趣不能为空" desc-target="#desc-sex"> 女</label>
            </div>
            <div class="col-xs-3" id="desc-sex"></div>
        </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="city">城市</label>
            </div>
            <div class="col-xs-10">
                <select name="city" id="city"  class="form-control" data-required="true" error-required="请选择城市">
                    <option value="">请选择</option>
                    <option value="0">北京</option>
                    <option value="1">天津</option>
                </select>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="file">文件</label>
            </div>
            <div class="col-xs-10">
                <input type="file" name="file" id="file"  class="form-control"
                       data-required="true" error-required="请上传文件"
                       data-conditional="ext" error-conditional="只允许png格式" in-list="png"/>
            </div>
         </div>

         <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="file">简单异步请求</label>
            </div>
            <div class="col-xs-10">
                <a href="javascript:void(0)" class="ajax-input" event-type="click" data="args=1" action="/index/plugin" succ-reload="false" confirm="确定删除么?">链接1</a> &nbsp;
                <a href="javascript:void(0)" class="ajax-input" event-type="click" action="/index/plugin" >链接2</a> &nbsp;
                <select class="ajax-input" show-desc="false" event-type="change" name="args"  action="/index/plugin" > &nbsp;
                    <option value="aaaa">aaaa</option>
                    <option value="bbbb">bbbb</option>
                </select>
           </div>
         </div>
       <div class="text-center">
          <button type="submit" class="btn btn-primary ajax-form" action="/index/plugin" succ-reload="false">提交</button>
          <button type="submit" class="btn btn-primary ajax-form" action="/index/plugin1">提交</button>
       </div>

    </form>
    </div>

    <script src="/Public/static/vendor/jquery/jquery.min.js"></script>
    <script src="/Public/static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
      <script src="/Public/static/vendor/bootstrap/js/html5shiv.min.js"></script>
      <script src="/Public/static/vendor/bootstrap/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/static/vendor/myplugin/js/request.js"></script>
    <script>
        $(function(){
            $('#container').request({
                conditional : {
                    userFunc : function() {
                        return false;
                    }
                },

/*
                beforeSubmit : function(element, options) {
                    alert(1);
                    return true;
                },
*/

/*
                dataSet : function(element, options) {
                    alert(2);
                    return "aa=bb&cc=dd";
                },
*/

/*             srvSucc : function(data, element, options) {
                    alert(5);
                },
*/

/*
                srvFail : function(data, element, options) {
                    alert(4);
                },
*/

/*
                failSubmit : function(element, options) {
                    alert(3);
                }
*/
            });
        })
    </script>

  </body>
</html>