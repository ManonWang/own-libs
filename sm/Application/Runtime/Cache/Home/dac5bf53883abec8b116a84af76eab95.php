<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/css/mainsite.css" rel="stylesheet">
    
    <link href="/Public/static/vendor/timepicker/css/timepicker.css" rel="stylesheet"> 

    <title>综合查询 -- 机车质量跟踪 -- 研判预警</title>
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
  <li><a href="/analyse/engine.html">机车质量跟踪</a></li>
  <li class="active">综合查询</li>
 </ol>
</div>

<div class="inline-form">
  <form id="query-form" class="form-inline">
    <div class="form-group">
        <label>机车类型</label>
       <select name="type" class="form-control" id="type"  data="value" action="/locomotive/getEngineModel">
         <option value="0">请选择</option>
         <?php if(is_array($dicLists[$allTypes['locomotive_type']])): foreach($dicLists[$allTypes['locomotive_type']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($item['id'] == $type): ?>selected="selected"<?php endif; ?> ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
       </select>
    </div>
    &nbsp;&nbsp;
    <div class="form-group"> 
        <label>机车车型</label>
        <select name="model" class="form-control" id="model" data="value" action="/locomotive/getEngineNumber">
          <option value="0">请选择</option>
        </select>
    </div>
    &nbsp;&nbsp;
    <div class="form-group"> 
        <label>机车号</label>
        <select name="number" class="form-control" id="number">
          <option value="0">请选择</option>
        </select>
    </div>
    &nbsp;&nbsp;
    <div class="form-group">
        <label for="start_time">时间</label>
        <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo ($start_time); ?>">
        <label for="end_time">至</label>
        <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo ($end_time); ?>">
    </div>
    &nbsp;&nbsp;
    <div class="form-group">
       <input type="submit" class="btn btn-primary btn-md form-control" value="查询" />
    </div>
  </form>
  <hr/>
</div>

<p class="page-title">机车质量跟踪系统-综合查询</p>
<table class="table table-striped table-bordered table-hover">
  <caption><strong>JT-6部分</strong></caption>
  <thead>
    <tr>
        <th>车型</th>
        <th>车号</th>
        <th>施修时间</th>
        <th>施修方法</th>
        <th>施修人</th>
        <th>活项归属</th>
        <th>破损处所</th>
        <th>施修情况</th>
    </tr>
  </thead>
  <tbody>
    <?php if(is_array($live6)): foreach($live6 as $key=>$item): ?><tr>
        <td><?php echo ($item['model']); ?></td>
        <td><?php echo ($item['number']); ?></td>
        <td>
            <?php echo ($item['repair_start_time']); ?> <br/>
            <?php echo ($item['repair_end_time']); ?>
        </td>
        <td><?php echo ($item['repair_method']); ?></td>
        <td><?php echo ($staff[$item['repair_user_id']]['name']); ?></td>
        <td><?php echo ($dicLists[$allTypes['live_own']][$item['live_own']]['name']); ?></td>
        <td><?php echo ($item['damage_palce']); ?></td>
        <td><?php echo ($item['repair_detail']); ?></td>
    </tr><?php endforeach; endif; ?>
  </tbody>
</table>

<table class="table table-striped table-bordered table-hover">
  <caption><strong>JT-28部分</strong></caption>
  <thead>
    <tr>
        <th>车型</th>
        <th>车号</th>
        <th>施修时间</th>
        <th>施修方法</th>
        <th>修程</th>
        <th>活项归属</th>
        <!--
        <th>施修部位</th>
        -->
        <th>活项</th>
    </tr>
  </thead>
  <tbody>
    <?php if(is_array($live28)): foreach($live28 as $key=>$item): ?><tr>
        <td><?php echo ($item['model']); ?></td>
        <td><?php echo ($item['number']); ?></td>
        <td><?php echo ($item['report_time']); ?></td>
        <td><?php echo ($item['repair_method']); ?></td>
        <td><?php echo ($dicLists[$allTypes['repair_process']][$item['repair_process']]['name']); ?></td>
        <td><?php echo ($dicLists[$allTypes['live_own']][$item['live_own']]['name']); ?></td>
        <!--
        <td><?php echo ($item['damage_palce']); ?></td>
        -->
        <td><?php echo ($item['live_item']); ?></td>
    </tr><?php endforeach; endif; ?>
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
    $(function(){
        $('#start_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});
        $('#end_time').datepicker({format: 'yyyy-mm-dd', changeMonth: true, changeYear: true});

        $('#type').change(function(){
            $('#model option[value!=0]').remove();
            if ($(this).val() != 0) {
                requestObject.simpleRequest($(this), function(res){
                    for (var idx in res.data) {
                        $('#model').append("<option value='" + res.data[idx].model + "'>" + res.data[idx].model + "</option>")
                    }
                });
            }
        });

        $('#model').change(function(){
            $('#number option[value!=0]').remove();
            if ($(this).val() != 0) {
                requestObject.simpleRequest($(this), function(res){
                    for (var idx in res.data) {
                        $('#number').append("<option value='" + res.data[idx].number + "'>" + res.data[idx].number + "</option>")
                    }
                });
            }
        });

        $('#save-btn').click(function(){ //保存表单
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