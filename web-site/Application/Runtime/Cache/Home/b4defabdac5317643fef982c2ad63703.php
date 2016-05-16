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
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>号码</th>
                <th>颜色</th>
                <th>数单双</th>
                <th>生肖</th>
                <th>和单双</th>
                <th>概率</th>
            </tr>
            </thead>
            <tbody>
                <?php if(is_array($result)): foreach($result as $key=>$item): ?><tr>
                    <td><?php if($item['number'] == 1): ?><font color="red"><?php echo ($key); ?></font><?php else: echo ($key); endif; ?></td>
                    <td><?php if($item['color'] == 1): ?><font color="red"><?php echo ($data[$key]['color']); ?></font><?php else: echo ($data[$key]['color']); endif; ?></td>
                    <td><?php if($item['type'] == 1): ?><font color="red"><?php echo ($data[$key]['type']); ?></font><?php else: echo ($data[$key]['type']); endif; ?></td>
                    <td><?php if($item['zodiac'] == 1): ?><font color="red"><?php echo ($data[$key]['zodiac']); ?></font><?php else: echo ($data[$key]['zodiac']); endif; ?></td>
                    <td><?php if($item['sum'] == 1): ?><font color="red"><?php echo ($data[$key]['sum']); ?></font><?php else: echo ($data[$key]['sum']); endif; ?></td>
                    <td><?php echo ($item['rate']); ?></td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <!--[if lt IE 9]>
      <script src="<?php echo get_assets_url('js_html5shiv');?>"></script>
      <script src="<?php echo get_assets_url('js_respond');?>"></script>
    <![endif]-->
    <script src="<?php echo get_assets_url('js_jquery');?>"></script>
    <script src="<?php echo get_assets_url('js_bootstrap');?>"></script>
  </body>

</html>