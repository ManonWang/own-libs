<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/Public/static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/static/css/mainsite.css" rel="stylesheet">
    
    <link href="/Public/static/vendor/typeahead/dist/jquery.typeahead.min.css" rel="stylesheet">
    <link href="/Public/static/vendor/treeview/dist/bootstrap-treeview.min.css" rel="stylesheet">
    <link href="/Public/static/vendor/timepicker/css/timepicker.css" rel="stylesheet">

    <title>安全风险信息审核 -- 风险审核 -- 过程控制</title>
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
  <li><a href="/handle/aduit.html">过程控制</a></li>
  <li class="active">安全风险信息审核</li>
 </ol>
</div>

<p class="page-title">安全风险信息审核</p>
<form id="add-form">
<input type="hidden" name="menu_cat" value="<?php echo ($data['menu_cat']); ?>" />
<input type="hidden" name="menu_type" value="<?php echo ($data['menu_type']); ?>" />
<input type="hidden" name="id" value="<?php echo ($data['id']); ?>" />
<table class="table table-bordered form-table">
    <tr>
        <td class="feild-title" >提报人</td>
        <td>
            <div class="typeahead__container">
               <div class="typeahead__field">
                   <span class="typeahead__query">
                        <input type="text" class="js-typeahead form-control" style="width: 100%!important;" id="report_user_id" autocomplete="off" 
                        value="<?php echo ($staff[$data['report_user_id']]['salary_id']); ?> | <?php echo ($staff[$data['report_user_id']]['name']); ?> | <?php echo ($staff[$data['report_user_id']]['work_id']); ?>"/>
                        <input type="hidden" name="report_user_id" value="<?php echo ($data['report_user_id']); ?>" data="value" action="/staff/department"/>
                    </span>
                </div>
            </div>
        </td>
        <td class="feild-title">来源部门</td>
        <td>
            <select name="from_dept_id" class="form-control">
            <?php if(is_array($dicLists[$allTypes['department']])): foreach($dicLists[$allTypes['department']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($item['id'] == $data['from_dept_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="feild-title" >事件发生时间</td>
        <td class="td-ctr-line">
            <input type="text" name="event_date_time" class="form-control" id="event_date_time" value="<?php echo ($data['event_date_time']); ?>"/>
        </td>
        <td class="feild-title">列车类别</td>
        <td>
             <select name="train_type" class="form-control">
             <?php if(is_array($dicLists[$allTypes['train']])): foreach($dicLists[$allTypes['train']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($item['id'] == $data['train_type']): ?>selected="selected"<?php endif; ?>><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
             </select>
        </td>
    </tr>
    <tr>
        <td class="feild-title" rowspan="2">事件发生地点</td>
        <td colspan="3" class="td-ctr-line" style="border-bottom:none;">
             <input name="event_place_type" type="radio" value="1" <?php if(1 == $data['event_place_type']): ?>checked="checked"<?php endif; ?> /> &nbsp;
             <select name="event_place_line_1" class="form-control" id="event_place_line_1" action="/LineStop/getList" data="value">
               <option value="0">请选择</option>
               <?php if(is_array($dicLists[$allTypes['line']])): foreach($dicLists[$allTypes['line']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($item['id'] == $data['event_place_line'] and 1 == $data['event_place_type']): ?>selected="selected"<?php endif; ?> ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
             </select> <label>线</label>
             <select name="event_place_station" class="form-control" id="event_place_station">
               <option value="0">请选择</option>
               <?php if(1 == $data['event_place_type']): ?><option value="<?php echo ($data['event_place_station']); ?>" selected="selected"><?php echo ($dicLists[$allTypes['station']][$data['event_place_station']]['name']); ?></option><?php endif; ?>
             </select> <label>站/场</label>
         </td>
    </tr>
    <tr>
         <td colspan="3" class="td-ctr-line" style="border-top:none;">
             <input name="event_place_type" type="radio" value="2" <?php if(2 == $data['event_place_type']): ?>checked="checked"<?php endif; ?> /> &nbsp;
             <select name="event_place_line_2" class="form-control" id="event_place_line_2" action="/LineStop/getList" data="value">
               <option value="0">请选择</option>
               <?php if(is_array($dicLists[$allTypes['line']])): foreach($dicLists[$allTypes['line']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($item['id'] == $data['event_place_line'] and 2 == $data['event_place_type']): ?>selected="selected"<?php endif; ?>><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
             </select> <label>线</label>
             <select name="event_place_start" class="form-control" id="event_place_start">
               <option value="0">请选择</option>
               <?php if(2 == $data['event_place_type']): ?><option value="<?php echo ($data['event_place_start']); ?>" selected="selected"><?php echo ($dicLists[$allTypes['station']][$data['event_place_start']]['name']); ?></option><?php endif; ?>
             </select> <label>站至</label>
             <select name="event_place_end" class="form-control" id="event_place_end">
               <option value="0">请选择</option>
               <?php if(2 == $data['event_place_type']): ?><option value="<?php echo ($data['event_place_end']); ?>" selected="selected"><?php echo ($dicLists[$allTypes['station']][$data['event_place_end']]['name']); ?></option><?php endif; ?>
             </select> <label>站/场</label>
         </td>
    </tr>
    <tr>
        <td class="feild-title">天气情况</td>
        <td class="td-ctr-line" colspan="3">
            <?php $weather = explode(',', $data['weather_type']); ?>
            <?php if(is_array($dicLists[$allTypes['weather']])): foreach($dicLists[$allTypes['weather']] as $key=>$item): ?><input type="checkbox" name="weather_type[]" value="<?php echo ($item['id']); ?>" id="weather_<?php echo ($item['id']); ?>" <?php if(in_array($item['id'], $weather)): ?>checked="checked"<?php endif; ?>/>
            <label for="weather_<?php echo ($item['id']); ?>"><?php echo ($item['name']); ?></label> &nbsp;<?php endforeach; endif; ?> 
        </td>
    </tr>
    <tr>
        <td class="feild-title">责任人</td>
        <td>
            <div class="typeahead__container">
               <div class="typeahead__field">
                   <span class="typeahead__query">
                        <input type="text" class="js-typeahead form-control" style="width: 100%!important;" id="resp_user_id" autocomplete="off"
                        value="<?php echo ($staff[$data['resp_user_id']]['salary_id']); ?> | <?php echo ($staff[$data['resp_user_id']]['name']); ?> | <?php echo ($staff[$data['resp_user_id']]['work_id']); ?>"/>
                        <input type="hidden" name="resp_user_id" value="<?php echo ($data['resp_user_id']); ?>" data="value" action="/staff/department"/>
                    </span>
                </div>
            </div>
        </td>
        <td class="feild-title">责任部门</td>
        <td>
            <select name="resp_dept_id" class="form-control">
            <?php if(is_array($dicLists[$allTypes['department']])): foreach($dicLists[$allTypes['department']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($data['resp_dept_id'] == $item['id']): ?>selected="selected"<?php endif; ?>  ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="feild-title" rowspan="2">风险概述</td>
        <td class="td-ctr-line" colspan="3" style="border-bottom:none;"> 
             <input type="button" value="点击选择" class="btn btn-primary form-control" data-toggle="modal" data-target="#modalTree"/> 
             &nbsp; &nbsp; 
             <select name="risk_type" class="form-control" id="risk_type">
             <?php if(is_array($dicLists[$allTypes['risk_type']])): foreach($dicLists[$allTypes['risk_type']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($data['risk_type'] == $item['id']): ?>selected="selected"<?php endif; ?> ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
             </select>
             &nbsp; &nbsp; 
             <select name="risk_level" class="form-control" id="risk_level">
               <?php if(is_array($dicLists[$allTypes['risk_level']])): foreach($dicLists[$allTypes['risk_level']] as $key=>$item): ?><option value="<?php echo ($item['id']); ?>" <?php if($data['risk_level'] == $item['id']): ?>selected="selected"<?php endif; ?> ><?php echo ($item['name']); ?></option><?php endforeach; endif; ?>
             </select>
        </td>
    </tr>  
    <tr>
        <td colspan="3" style="border-top:none;">
            <textarea class="form-control" rows="3" cols="100" name="risk_outline" id="risk_outline"><?php echo ($dicLists[$allTypes['risk_item']][$data['risk_outline_id']]['name']); ?></textarea>
            <input type="hidden" class="form-control" name="risk_outline_id" id="risk_outline_id" value="<?php echo ($data['risk_outline_id']); ?>"/>
        </td>
    </tr>
    <tr>
        <td class="feild-title">风险详述</td>
        <td class="td-ctr-line" colspan="3"> 
            <textarea class="form-control" rows="3" cols="100" name="risk_detail" id="risk_detail"><?php echo ($data['risk_detail']); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="feild-title">风险存储</td>
        <td class="td-ctr-line" colspan="3"> 
            <label for="risk_store_2"><input type="radio" name="risk_store" id="risk_store_2" value="2" <?php if(2 == $data['risk_store']): ?>checked="checked"<?php endif; ?> /> 库内 </label>&nbsp;
            <label for="risk_store_1"><input type="radio" name="risk_store" id="risk_store_1" value="1" <?php if(1 == $data['risk_store']): ?>checked="checked"<?php endif; ?> /> 库外 </label>
        </td>
    </tr>
    <tr>
        <td class="feild-title">是否需要<br/>车间/科室签认</td>
        <td class="td-ctr-line" colspan="3"> 
            <label for="room_sign_2"><input type="radio" name="room_sign" id="room_sign_2" value="2" <?php if(2 == $data['room_sign']): ?>checked="checked"<?php endif; ?> /> 否 </label> &nbsp; 
            <label for="room_sign_1"><input type="radio" name="room_sign" id="room_sign_1" value="1" <?php if(1 == $data['room_sign']): ?>checked="checked"<?php endif; ?> /> 是 </label>
        </td>
    </tr>
    <tr>
        <td class="feild-title">是否需要<br/>分管领导签认</td>
        <td class="td-ctr-line" colspan="3"> 
            <label for="leader_sign_2"><input type="radio" name="leader_sign" id="leader_sign_2" value="2" <?php if(2 == $data['leader_sign']): ?>checked="checked"<?php endif; ?> /> 否 </label> &nbsp; 
            <label for="leader_sign_1"><input type="radio" name="leader_sign" id="leader_sign_1" value="1" <?php if(1 == $data['leader_sign']): ?>checked="checked"<?php endif; ?> /> 是 </label>
        </td>
    </tr>
    <tr>
        <td class="feild-title">是否需要<br/>填写处置落实情况</td>
        <td class="td-ctr-line" colspan="3"> 
            <label for="need_fix_text_2"><input type="radio" name="need_fix_text" id="need_fix_text_2" value="2" <?php if(2 == $data['need_fix_text']): ?>checked="checked"<?php endif; ?> /> 否 </label> &nbsp; 
            <label for="need_fix_text_1"><input type="radio" name="need_fix_text" id="need_fix_text_1" value="1" <?php if(1 == $data['need_fix_text']): ?>checked="checked"<?php endif; ?> /> 是 </label>
        </td>
    </tr>
    <tr>
        <td class="feild-title">是否进入<br/>日分析重点甄选队列</td>
        <td class="td-ctr-line" colspan="3"> 
            <label for="is_stress_2"><input type="radio" name="is_stress" id="is_stress_2" value="2" <?php if(2 == $data['is_stress']): ?>checked="checked"<?php endif; ?> /> 否 </label> &nbsp; 
            <label for="is_stress_1"><input type="radio" name="is_stress" id="is_stress_1" value="1" <?php if(1 == $data['is_stress']): ?>checked="checked"<?php endif; ?> /> 是 </label>
        </td>
    </tr>
</table>
<div class="text-center">
    <input type="botton" value="返回" class="btn btn-primary" onclick="history.go(-1);" />
    <input type="botton" value="删除" class="btn btn-primary action-btn"      action="/handle/auditDeal?act=delete" jump-url="/handle/aduit.html"/>
    <input type="botton" value="修改" class="btn btn-primary action-btn"      action="/handle/auditDeal?act=modify" reload="true"/>
    <input type="botton" value="通过审核" class="btn btn-primary action-btn"  action="/handle/auditDeal?act=audit"  jump-url="/handle/aduit.html"/>
</div>
</form>

<div class="modal fade" id="modalTree" tabindex="-1" role="dialog" aria-labelledby="modalTreeLabel" aria-hidden="true" data-backdrop="false" data-show="false">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="modalTreeLabel">选择风险概述</h4>
         </div>
         <div class="modal-body modal_max">
             <div id="risk_tree"></div> 
         </div>
      </div>
   </div>
</div>

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
    
    <script src="/Public/static/vendor/treeview/dist/bootstrap-treeview.min.js"></script>
    <script src="/Public/static/vendor/timepicker/js/timepicker.js"></script>
    <script type="text/javascript">
        $(function() {
             $('#event_date_time').datetimepicker({format: 'yyyy-mm-dd hh:ii', changeMonth: true, changeYear: true,});

             $('#modalTree').modal(); //模态窗口

             var treeView = $('#risk_tree').treeview({ //树
                  data: <?php echo ($treeData); ?>,
                  onNodeSelected: function(event, node) {
                      if (undefined != node.nodes) {
                          return false;
                      }
                      
                      var cats = []
                      var tnode = node
                      cats.push(tnode.tags.did)
                      while ($.isPlainObject(tnode = treeView.treeview('getParent', tnode))) {
                            cats.push(tnode.tags.did)                            
                      }
                    
                      $('#risk_type option[value='+ cats.pop() +']').attr("selected", "selected")
                      $('#risk_level option[value='+ cats.pop() +']').attr("selected", "selected")

                      $('#risk_outline').text(node.text)
                      $('#risk_outline_id').val(node.tags.did)

                      $('#modalTree').modal('hide')
                  }
             });

             smUtils.satff_suggest('#report_user_id', function (node, a, item, event) {
                $('input[type="hidden"][name="report_user_id"]').val(item.work_id)
                requestObject.simpleRequest($('input[name="report_user_id"]'), function(res){
                    $('select[name="from_dept_id"]').children("option[value='" + res.data.depart_id +"']").attr("selected", "selected")
                })
             });

             smUtils.satff_suggest('#resp_user_id', function (node, a, item, event) {
                $('input[type="hidden"][name="resp_user_id"]').val(item.work_id)
                requestObject.simpleRequest($('input[name="resp_user_id"]'), function(res){
                    $('select[name="resp_dept_id"]').children("option[value='" + res.data.depart_id +"']").attr("selected", "selected")
                })
             });

             $('#event_place_line_1').change(function(){ //发生在某站
                 requestObject.simpleRequest($(this), function(data){
                     $('#event_place_station option').remove()
                     for(i in data.data) {
                       $("<option value='" + data.data[i].station_id + "'>" + data.data[i].station_name + "</option>").appendTo('#event_place_station');
                     }
                 })
             })

             $('#event_place_line_2').change(function(){ //发生在某区间
                 requestObject.simpleRequest($(this), function(data){
                     $('#event_place_start option').remove()
                     $('#event_place_end option').remove()
                     for(i in data.data) {
                       $("<option value='" + data.data[i].station_id + "'>" + data.data[i].station_name + "</option>").appendTo('#event_place_start');
                       $("<option value='" + data.data[i].station_id + "'>" + data.data[i].station_name + "</option>").appendTo('#event_place_end');
                     }
                 })
             })

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