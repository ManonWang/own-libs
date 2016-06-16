var requestObject = {}

requestObject.submitForm = function(target, fromObj, succCall, beforeCall, failCall) {
    var process = target.attr('process') || 'false'
    if ('false' != process) {
        return false;
    }
    target.addClass('disabled').attr('disabled', true).attr('process', 'true');
    if (undefined != beforeCall) {
        if (!beforeCall(target)) {
            return false;
        }
    }
    fromObj.ajaxSubmit({
        url  : target.attr('action'),
        type : 'post',
        dataType : 'json',
        success  : function(data){
            target.removeClass('disabled').attr('disabled', false).attr('process', 'false');
            if(data.code == 0){
               if (undefined != succCall) {
                   return succCall(data, target);
               } else {
                    var showAlert = target.attr('show-alert') || 'true';
                    if ('true' == showAlert) {
                       alert('操作已成功');
                   }
                   var jumpUrl = target.attr('jump-url') || 'false';
                   if ('false' != jumpUrl) {
                       location.href = jumpUrl;
                       return true;
                   }
                   var reload = target.attr('reload') || 'false';
                  if ('true' == reload) {
                       location.reload();
                       return true;
                   }
                   return true;
               }
            }else{
               if (undefined != failCall) {
                   return failCall(data, target); 
               } else {                
                   alert(data.msg == undefined || data.msg.length <= 0 ?  '操作失败，请稍后重试!' : data.msg);
                   return false;
               }
            }
        },
        error : function(){
            target.removeClass('disabled').attr('disabled', false).attr('process', 'false');
            alert('系统错误，操作失败，请稍后再试');
            return false;
        }
    });
}


requestObject.simpleRequest = function (target, succCall, failCall) {
    var process = target.attr('process') || 'false'
    if ('false' != process) {
        return false;
    }

    target.addClass('disabled').attr('disabled', true).attr('process', 'true');
    var data = target.attr('data')
    if (data == 'value') {
        data = 'query=' + target.val()
    }    

    $.ajax({
        type:'post',
        data: data,
        url : target.attr('action'),
        dataType: 'json',
        success: function(data) {
           target.removeClass('disabled').attr('disabled', false).attr('process', 'false');
           if(data.code == 0){
               if (undefined != succCall) {
                  return succCall(data, target);
               } 
               var showAlert = target.attr('show-alert') || 'true';
               if ('true' == showAlert) {
                  alert('操作已成功');
               }
               var jumpUrl = target.attr('jump-url') || 'false';
               if ('false' != jumpUrl) {
                   location.href = jumpUrl;
                   return true;
               }
               var reload = target.attr('reload') || 'true';
               if ('true' == reload) {
                   location.reload();
                   return true;
               }
           } else {
               if (undefined != failCall) {
                   return failCall(data, target)
               } else {
                   alert(data.msg == undefined || data.msg.length <= 0 ?  '操作失败，请稍后重试!' : data.msg);
                   return false;
               }
           }
        },
        error: function(data) {
             alert('系统错误，操作失败，请稍后再试');
             target.removeClass('disabled').attr('disabled', false).attr('process', 'false');
             return false;
        },
   });
}
