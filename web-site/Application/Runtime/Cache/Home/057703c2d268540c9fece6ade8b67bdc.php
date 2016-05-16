<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo get_assets_url('css_bootstrap');?>" rel="stylesheet">
    <title>历史预测</title>
  </head>

  <body>
    <div class="container" style="padding-top:30px;"> 
        <p><a href="/lottery/show">新增预测</a></p>
        <?php if(is_array($list)): foreach($list as $key=>$item): ?><p><a href="/lottery/show?batch_num=<?php echo ($item['batch_num']); ?>"><?php echo ($item['batch_num']); ?></a></p><?php endforeach; endif; ?>
    </div>

    <!--[if lt IE 9]>
      <script src="<?php echo get_assets_url('js_html5shiv');?>"></script>
      <script src="<?php echo get_assets_url('js_respond');?>"></script>
    <![endif]-->
    <script src="<?php echo get_assets_url('js_jquery');?>"></script>
    <script src="<?php echo get_assets_url('js_bootstrap');?>"></script>
  </body>

</html>