<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo get_assets_url('css_bootstrap');?>" rel="stylesheet">
    <title>本期预测</title>
  </head>

  <body>
    <div class="container" style="padding-top:30px;"> 
        <form class="form-horizontal" role="form" method="post" action="/lottery/result" target="_blank">
           <div class="form-group">
             <label class="col-sm-2 control-label"><a href="/lottery/index">历史预测</a></label>
           </div>
           <div class="form-group">
             <label for="batch_num" class="col-sm-2 control-label">预测期次</label>
             <div class="col-sm-6"><input type="text" class="form-control" name="batch_num" id="batch_num" value="<?php echo ($batch_num); ?>"></div>
             <label for="batch_num" class="control-label">2016036</label>
           </div>
            
           <?php if(is_array($source)): foreach($source as $key=>$item): ?><div class="form-group">
             <label for="<?php echo ($key); ?>" class="col-sm-2 control-label"><?php echo ($item['name']); ?></label>
             <div class="col-sm-6">
                <input type="text" class="form-control" id="<?php echo ($key); ?>" name="<?php echo ($key); ?>" value="<?php echo ((isset($$key) && ($$key !== ""))?($$key):$show[$key]['guess_cxt']); ?>">
             </div>
             <label for="<?php echo ($key); ?>" class="control-label"><a href="<?php echo ($item['link']); ?>" target="_blank">查看</a> <?php echo ($item['example']); ?></label>
           </div><?php endforeach; endif; ?>

           <?php if($show['type_1']['real_result'] != 0): ?><div class="form-group">
             <label for="result" class="col-sm-2 control-label">开奖结果</label>
             <div class="col-sm-6">
                <input type="text" class="form-control" id="result" name="result" 
                value="<?php echo ($show['type_1']['real_result']); ?> <?php echo ($ball['color']); ?> <?php echo ($ball['type']); ?> <?php echo ($ball['zodiac']); ?> <?php echo ($ball['sum']); ?> ">
             </div>
           </div><?php endif; ?>

           <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">查看概率</button></div>
           </div>

        </form>
    </div>

    <!--[if lt IE 9]>
      <script src="<?php echo get_assets_url('js_html5shiv');?>"></script>
      <script src="<?php echo get_assets_url('js_respond');?>"></script>
    <![endif]-->
    <script src="<?php echo get_assets_url('js_jquery');?>"></script>
    <script src="<?php echo get_assets_url('js_bootstrap');?>"></script>
  </body>

</html>