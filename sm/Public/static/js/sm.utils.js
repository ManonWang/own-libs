
var smUtils = {

    satff_suggest : function(name, func) {
       $(name).typeahead({                 
          emptyTemplate: '没有找到"{{query}}"相关内容',
          minLength: 1,
          maxItem: 20,
          dynamic: true,
          order: 'asc',
          hint: true,
          display: ['salary_id', 'work_id', 'name'],
          template: '{{salary_id}} | {{name}} | {{work_id}}',
          correlativeTemplate: true,
          source: {
              users: {
                  ajax : {
                      url : '/staff/suggest?keywords={{query}}',
                      path: 'data',
                   },
              },
          },
          callback : {
              onClickAfter: function(node, a, item, event){
                   func(node, a, item, event)
              }, 
          }
       })
   },
    
   get_time : function () { 
        var week = ['日','一','二','三','四','五','六'];
        var now  = new Date();
        var year  = now.getFullYear();
        var month = now.getMonth() + 1;
        var day = now.getDate();
        var hh = now.getHours();
        var mm = now.getMinutes();
        var ss = now.getSeconds();
        var ww = now.getDay();

        var clock = year + "-";
        if(month < 10) {
            clock += "0";
        }
        clock += month + "-";
       
        if(day < 10) {
            clock += "0";
        }
        clock += day + " ";
       
        if(hh < 10){
            clock += "0";
        }
        clock += hh + ":";

        if (mm < 10) {
            clock += '0'; 
        }
        clock += mm + ":"; 

        if (ss < 10) {
           clock += "0";
        }
        clock += ss + " &nbsp;星期" + week[ww];

        return(clock); 
    },
                     
}
