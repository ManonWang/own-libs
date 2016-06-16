<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <title>表单验证提交组件</title>
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/vendor/validation/css/validationEngine.jquery.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
        <form class="form-horizontal" id="form-validate" action="/index/plugin" method="POST">
          <div class="form-group">
            <div class="col-xs-2 text-right">
                <label for="username">用户名</label>
            </div>
            <div class="col-xs-7">
                <input type="text" name="username" class="form-control validate[required] validate[ajax[ajaxName]]" id="username" data-errormessage-value-missing="xxxx"/>
            </div>
          </div>
          <div class="text-center">
              <button type="submit" class="btn btn-primary">提交</button>
          </div>
         </form>
    </div>

    <script src="/Public/static/vendor/jquery/jquery.min.js"></script>
    <script src="/Public/static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
      <script src="/Public/static/vendor/bootstrap/js/html5shiv.min.js"></script>
      <script src="/Public/static/vendor/bootstrap/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/static/vendor/validation/js/jquery.validationEngine-zh_CN.js"></script>
    <script src="/Public/static/vendor/validation/js/jquery.validationEngine.js"></script>
    <script>
        function functionName() {
            alert(1);
        }

        $(function(){
            $('#form-validate').validationEngine('attach', {
                promptPosition: 'centerRight',
                addPromptClass: 'noneaa',
                scroll: false,
                ajaxName: {
                    url: 'phpajax/ajaxValidateFieldUser.php', /* 验证程序地址 */
                    extraData: 'name=eric', /* 额外参数 */
                    alertTextOk: '验证通过时的提示信息',
                    alertText: '验证不通过时的提示信息',
                    alertTextLoad: '正在验证时的提示信息'
                }
             });
        });
    </script>

  </body>
</html>