<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/css/mainsite.css" rel="stylesheet">
    
    <link href="/Public/static/vendor/timepicker/css/timepicker.css" rel="stylesheet">
    <link href="/Public/static/vendor/multiselect/multiselect.css" rel="stylesheet">

    <title>预警信息审核 -- 预警信息管理 -- 研判预警</title>
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
                    
                    <li><a tabindex="-1" href="/analyse/engine.html">机车质量跟踪</a></li>
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
  <li class="active">预警信息审核</li>
 </ol>    
</div>

<p class="page-title">安全预警审核</p>
<form id="add-form">
<table class="table table-bordered form-table">
    <tr>
        <td class="feild-title">预警类型</td>
        <td>
             <?php echo ($dicLists[$allTypes['alarm_type']][$data['type']]['name']); ?>
            <input type="hidden" name="type" value="<?php echo ($alarmType['supervise']['id']); ?>" />
        </td>
    </tr>
    <tr>
        <td class="feild-title">预警时间</td>
        <td><?php echo ($data['alarm_time']); ?></td>
    </tr>
    <tr>
        <td class="feild-title">落实时限</td>
        <td ><?php echo ($data['fix_time']); ?></td>
    </tr>
    <tr>
        <td class="feild-title">预警来源</td>
        <td >
           <?php if(is_array($dicLists[$allTypes['alarm_source']])): foreach($dicLists[$allTypes['alarm_source']] as $key=>$item): if($item['id'] == $data['alarm_source']): echo ($item['name']); endif; endforeach; endif; ?>
        </td>
    </tr>
    <tr>
        <td class="feild-title">落实部门</td>
        <td >
            <?php if(is_array($dicLists[$allTypes['department']])): foreach($dicLists[$allTypes['department']] as $key=>$item): if(in_array($item['id'], $data['fix_dept'])): echo ($item['name']); ?>&nbsp;<?php endif; endforeach; endif; ?>
        </td>
    </tr>
    <tr>
        <td class="feild-title">预警主题</td>
        <td ><?php echo ($data['alarm_title']); ?></td>
    </tr>
    <tr>
        <td class="feild-title">预警内容</td>
        <td ><?php echo ($data['alarm_content']); ?></td>
    </tr>
    <tr>
        <td class="feild-title">整改要求</td>
        <td ><?php echo ($data['fix_method']); ?></td>
    </tr>
    <tr>
        <td class="feild-title">预警响应</td>
        <td >
            <textarea class="form-control" rows="5" cols="45" name="alarm_resp"><?php echo ($data['alarm_resp']); ?></textarea>
        </td>
    </tr>
</table>

<div class="text-center">
    <input type="hidden" name="id" value="<?php echo ($data['id']); ?>" />
    <input type="botton" value="返回" class="btn btn-primary" onclick="history.go(-1);" />
    <input type="botton" value="添加响应" class="btn btn-primary action-btn"  action="/handle/auditResp"  jump-url="/handle/deal.html"/>
</div>
</form>

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
<script src="/Public/static/vendor/multiselect/multiselect.js"></script>
<script>
    $(function(){
        $("#fix_dept").multiselect();
        $('#alarm_time').datetimepicker({format: 'yyyy-mm-dd hh:ii', changeMonth: true, changeYear: true,});
        $('#fix_time').datetimepicker({format: 'yyyy-mm-dd hh:ii', changeMonth: true, changeYear: true,});
        $('.action-btn').click(function(){ //保存表单
            requestObject.submitForm($(this), $('#add-form'))
        });
    })
</script>

    <script type="text/javascript">
        $(function() {
             setInterval(function(){$('#show_time').html(smUtils.get_time())}, 1000);
        })
    </script>
  </body>
</html>