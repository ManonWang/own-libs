<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/css/mainsite.css" rel="stylesheet">
    
    <link href="/Public/static/vendor/timepicker/css/timepicker.css" rel="stylesheet">

    <title>来源分析 -- 数据分析预警 -- 研判预警</title>
  </head>

  <body>
    <div class="container" id="body-container">
        <!--session-->
        <div id="session">
            <div class="col-md-8" id="show_time"><?php echo ($dateTime); ?> &nbsp;星期<?php echo ($dateWeek); ?></div>
            <div class="col-md-4 text-right"> 
                <span>登陆部门:风险办</span> &nbsp;
                <a href="/">修改密码</a> &nbsp;
                <a href="/">退出系统</a>
            </div>
        </div>

        <!--carousel-->
        <div id="carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#carousel" data-slide-to="0" class="active"></li>
              <li data-target="#carousel" data-slide-to="1"></li>
          </ol>   
          <div class="carousel-inner">
              <div class="item active">
                 <a href="/"><img src="/Public/static/img/c0.png" style="width:100%;height:220px"></a> 
              </div>
              <div class="item">
                 <a href="/"><img src="/Public/static/img/c1.png" style="width:100%;height:220px"></a>
              </div>
          </div>
          <a class="carousel-control left"  href="#carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
          <a class="carousel-control right" href="#carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div> 

        <!--nav-->
        <div id="nav"> 
          <ul class="nav nav-pills nav-info">
                        <li role="presentation" class="dropdown first-menu">
                <a role="button" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="true">风险信息<span class="caret"></span></a>

                <ul class="dropdown-menu multi-level second-menu" role="menu">
                    <?php if(is_array($risk_menu)): foreach($risk_menu as $cat_key=>$cat_item): ?><li class="dropdown-submenu">
                        <a tabindex="-1" href="javascript:void(0);"><?php echo ($cat_item['name']); ?></a>
                        <ul class="dropdown-menu thrid-menu">
                          <?php $count = 0;?>
                          <?php if(is_array($cat_item['child'])): foreach($cat_item['child'] as $type_key=>$type_item): $count ++ ;?>
                             <li><a tabindex="-1" href="/risk/add.html?menu_cat=<?php echo ($cat_key); ?>&menu_type=<?php echo ($type_key); ?>"><?php echo ($type_item); ?></a></li>
                             <?php if($count != count($cat_item['child'])): ?><li class="divider"></li><?php endif; endforeach; endif; ?>
                        </ul>
                    </li>
                    <li class="divider"></li><?php endforeach; endif; ?>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="javascript:void(0);">机车质量跟踪分析中心</a>
                        <ul class="dropdown-menu thrid-menu">
                             <li><a tabindex="-1" href="/locomotive/add.html">机车质量跟踪系统填报</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/locomotive/live6.html">机统6活项填写</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/locomotive/live28.html">机统28活项填写</a></li>
                        </ul>
                    </li>
                </ul>

            </li>

                        <li role="presentation" class="dropdown first-menu">
                <a role="button" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="true">研判预警<span class="caret"></span></a>

                <ul class="dropdown-menu multi-level second-menu" role="menu">
                    <li><a tabindex="-1" href="/analyse/supervise.html">监督检查预警</a></li>
                    <li class="divider"></li>

                    <li class="dropdown-submenu">
                        <a href="javascript:void(0);">数据分析预警</a>
                        <ul class="dropdown-menu thrid-menu">
                             <li><a tabindex="-1" href="/analyse/source.html">来源分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/distribute.html">分布分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/region.html">地域分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/weather.html">天气情况分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/time.html">时间段分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/constitute.html">构成分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/stage.html">阶段分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/combine.html">综合分析</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>

                    <li><a tabindex="-1" href="/analyse/staff.html">职工行为预警</a></li>
                    <li class="divider"></li>

                    <li class="dropdown-submenu">
                        <a href="javascript:void(0);">预警信息管理</a>
                        <ul class="dropdown-menu thrid-menu">
                             <li><a tabindex="-1" href="/analyse/audit.html">预警信息审核</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/query.html">预警信息查询</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/stat.html">预警信息统计</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    
                    <li><a tabindex="-1" href="/analyse/engine.html">机车质量跟踪</a></li>
                </ul>
            </li>

         </ul>  
        </div>

        <!--content-->
        <div id="content" class="content">
            
    <div id="breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/analyse/supervise.html">研判预警</a></li>
            <li><a href="/analyse/source.html">数据分析预警</a></li>
            <li class="active">来源分析</li>
        </ol>    
    </div>

    <div class="inline-form">
        <form id="query-form" class="form-inline">
            <div class="form-group">
                <label for="type">统计方式</label>
                <select name="type" class="form-control" id="type">
                    <option value="1">提报平台</option>
                    <option value="2" selected="selected">提报部门</option>
                </select>
            </div> 
            &nbsp;&nbsp;
            <div class="form-group">
                <label for="start_time">时间</label>
                <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo date("Y-m-d", $startTime);?>">
                       <label for="end_time">至</label>
                <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo date("Y-m-d", $endTime);?>">
            </div>
            &nbsp;&nbsp;
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-md form-control" value="查询" />
            </div>
        </form>
        <hr/>
    </div>

    <?php unset($levelData['level_1']); ?>
    <p class="page-title"><?php echo date("Y年m月d日", $startTime);?>至<?php echo date("Y年m月d日", $endTime);?>安全风险问题提报部门分析</p>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>提报部门</th>
        <?php if(is_array($levelData)): foreach($levelData as $levelKey=>$levelItem): ?><th><?php echo ($levelItem['name']); ?></th><?php endforeach; endif; ?>
        <th>合计</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): foreach($data as $deptId=>$deptItem): ?><tr>
                <td><?php echo ($deptData[$deptId]['name']); ?></td>
            <?php if(is_array($levelData)): foreach($levelData as $levelKey=>$levelItem): ?><td>
                    <?php echo ($deptItem[$levelItem['id']]); ?>
                <?php $colStat[$levelKey] = $colStat[$levelKey] + $deptItem[$levelItem['id']]; ?>
                </td><?php endforeach; endif; ?>
            <td><?php echo array_sum($deptItem);?></td>
            </tr><?php endforeach; endif; ?>
        <tr>
            <td>合计</td>
        <?php if(is_array($levelData)): foreach($levelData as $levelKey=>$levelItem): ?><td><?php echo ($colStat[$levelKey]); ?></td><?php endforeach; endif; ?>
        <td><?php echo array_sum($colStat);?></td>
        </tr>
        </tbody>
    </table>

        <div>

        <!--footer-->
        <div id="footer" class="footer">
            <p  class="text-left"><em> Copyright ©  集宁机务段版权所有 </em></p>
            <p  class="text-left"><em> Power By 集宁机务段信息科技术支持</em></p>
        </div>
    </div>
    <!--[if lt IE 9]>
      <script src="/Public/static/vendor/bootstrap/js/html5shiv.min.js"></script>
      <script src="/Public/static/vendor/bootstrap/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/static/vendor/jquery/jquery.min.js"></script>
    <script src="/Public/static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/static/js/jquery.form.js"></script>
    <script src="/Public/static/js/request.util.js"></script>
    <script src="/Public/static/vendor/typeahead/dist/jquery.typeahead.min.js"></script>
    <script src="/Public/static/js/sm.utils.js"></script>
    
    <script src="/Public/static/vendor/timepicker/js/timepicker.js"></script>
    <script>
        $(function() {
            $('#start_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});
            $('#end_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});
        })
    </script>

    <script type="text/javascript">
        $(function() {
             setInterval(function(){$('#show_time').html(smUtils.get_time())}, 1000);
        })
    </script>
  </body>
</html>