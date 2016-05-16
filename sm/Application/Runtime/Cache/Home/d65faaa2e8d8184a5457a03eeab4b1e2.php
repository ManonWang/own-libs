<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/css/mainsite.css" rel="stylesheet">
    
    <link href="/Public/static/vendor/timepicker/css/timepicker.css" rel="stylesheet">

    <title>安全预警审核列表 -- 预警信息管理 -- 研判预警</title>
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
                        <a tabindex="-1" href="javascript:void(0);">机车质量跟踪系统填报</a>
                        <ul class="dropdown-menu thrid-menu">
                        <!--
                             <li><a tabindex="-1" href="/locomotive/add.html">机车质量跟踪系统填报</a></li>
                             <li class="divider"></li>
                        -->
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
                    <li class="dropdown-submenu">
                        <a href="javascript:void(0);">机车质量跟踪</a>
                        <ul class="dropdown-menu thrid-menu">
                             <li><a tabindex="-1" href="/analyse/engine.html">数据填报统计</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/analyseJT6.html">JT6分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/queryJT6.html">JT6查询</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/analyseJT28.html">JT28分析</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/queryJT28.html">JT28查询</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/analyse/queryEngineAll.html">综合查询</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

                        <li role="presentation" class="dropdown first-menu">
                <a role="button" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="true">过程控制<span class="caret"></span></a>

                <ul class="dropdown-menu multi-level second-menu" role="menu">
                    <li><a tabindex="-1" href="/handle/aduit.html">风险审核</a></li>
                    <li class="divider"></li>

                    <li><a tabindex="-1" href="/handle/deal.html">预警响应</a></li>
                    <li class="divider"></li>

                    <li class="dropdown-submenu">
                        <a href="javascript:void(0);">追踪分析</a>
                        <ul class="dropdown-menu thrid-menu">
                             <li><a tabindex="-1" href="/handle/select.html">重点甄别</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/handle/track.html">信息追踪</a></li>
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="/handle/stat.html">追踪统计</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>

                    <li><a tabindex="-1" href="/handle/fix.html">整改处置</a></li>
                    <li class="divider"></li>

                    <li><a tabindex="-1" href="/handle/destroy.html">落实销号</a></li>
                </ul>
            </li>

         </ul>  
        </div>

        <!--content-->
        <div id="content" class="content">
            
<div id="breadcrumb">
 <ol class="breadcrumb">
  <li><a href="/analyse/supervise.html">研判预警</a></li>
  <li><a href="/analyse/audit.html">预警信息管理</a></li>
  <li class="active">预警信息查询</li>
 </ol>
</div>

<div class="inline-form">
   <form id="query-form" class="form-inline">
        <div class="form-group">
           <label for="type">预警类型</label>
           <select name="type" class="form-control" id="type">
              <option value="">全部</option>
              <?php if(is_array($dicLists[$allTypes['alarm_type']])): foreach($dicLists[$allTypes['alarm_type']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($type == $item['id']): ?>selected="selected"<?php endif; ?>>
                    <?php echo ($item['name']); ?>
                </option><?php endforeach; endif; ?>
            </select>
        </div> 
         &nbsp;&nbsp;
        <div class="form-group">
           <label for="fix_dept">预警部门</label>
           <select name="fix_dept" class="form-control" id="fix_dept">
              <option value="">全部</option>
              <?php if(is_array($dicLists[$allTypes['department']])): foreach($dicLists[$allTypes['department']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($fix_dept == $item['id']): ?>selected="selected"<?php endif; ?>>
                    <?php echo ($item['name']); ?>
                </option><?php endforeach; endif; ?>
            </select>
        </div> 
         &nbsp;&nbsp;
        <div class="form-group">
              <label for="start_time">预警时间</label>
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

<p class="page-title">预警信息查询</p>
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
        <th>序号</th>
        <th>预警类型</th>
        <th>预警时间</th>
        <th>预警主题</th>
        <th>落实部门</th>
        <th>响应情况</th>
    </tr>
  </thead>
  <tbody>
    <?php if(is_array($pagedList['data_list'])): foreach($pagedList['data_list'] as $key=>$item): ?><tr>
        <td><?php echo ($item['id']); ?></td>
        <td><?php echo ($item['type_cn']); ?></td>
        <td><?php echo ($item['fix_time']); ?></td>
        <td><?php echo ($item['alarm_title']); ?></td>
        <td><?php echo ($item['fix_dept_cn']); ?></td>
        <td><?php echo ($item['alarm_resp']); ?></td>
    </tr><?php endforeach; endif; ?>
  </tbody>
</table>

<?php if(1 < $pagedList['total_page']): ?><div class="pager-style">
<nav>
  <ul class="pagination">
    <?php if(1 == $pagedList['current_page']): ?><li class="disabled"><a href="javascript:void(0);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($pagedList['paged_url']); echo ($pagedList['current_page'] - 1); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?php endif; ?>

    <?php if(is_array($pagedList['show_num'])): foreach($pagedList['show_num'] as $key=>$index): if($index == $pagedList['current_page']): ?><li class="active"><a href="javascript:void(0);"><?php echo ($index); ?></a></li>
      <?php else: ?>
        <li><a href="<?php echo ($pagedList['paged_url']); echo ($index); ?>"><?php echo ($index); ?></a></li><?php endif; endforeach; endif; ?>

    <?php if($pagedList['total_page'] == $pagedList['current_page']): ?><li class="disabled"><a href="javascript:void(0);" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($pagedList['paged_url']); echo ($pagedList['current_page'] + 1); ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?php endif; ?>
  </ul>
</nav>
</div><?php endif; ?>


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
<script type="text/javascript">
   $(function() {
        $('#start_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});
        $('#end_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});
   });
</script>

    <script type="text/javascript">
        $(function() {
             setInterval(function(){$('#show_time').html(smUtils.get_time())}, 1000);
        })
    </script>
  </body>
</html>