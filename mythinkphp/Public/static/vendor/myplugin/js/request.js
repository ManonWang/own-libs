/*  jquery.validate */
;(function(a,b,c,d){var e=['input:not([type]),input[type="color"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="email"],input[type="file"],input[type="hidden"],input[type="month"],input[type="number"],input[type="password"],input[type="range"],input[type="search"],input[type="tel"],input[type="text"],input[type="time"],input[type="url"],input[type="week"],textarea',"select",'input[type="checkbox"],input[type="radio"]'],f=e.join(","),g={},h=function(a,c){var f={required:!0,pattern:!0,conditional:!0},h=b(this),i=h.val()||"",j=h.data("validate"),k=j!==d?g[j]:{},l=h.data("prepare")||k.prepare,m=h.data("pattern")||("regexp"==b.type(k.pattern)?k.pattern:/(?:)/),n=h.attr("data-ignore-case")||h.data("ignoreCase")||k.ignoreCase,o=h.data("mask")||k.mask,p=h.data("conditional")||k.conditional,q=h.data("required"),r=h.data("describedby")||k.describedby,s=h.data("description")||k.description,t=h.data("trim"),u=/^(true|)$/i,v=/^false$/i,s=b.isPlainObject(s)?s:c.description[s]||{};if(q=""!=q?q||!!k.required:!0,t=""!=t?t||!!k.trim:!0,u.test(t)&&(i=b.trim(i)),b.isFunction(l)?i=l.call(h,i)+"":b.isFunction(c.prepare[l])&&(i=c.prepare[l].call(h,i)+""),"regexp"!=b.type(m)&&(n=!v.test(n),m=n?RegExp(m,"i"):RegExp(m)),p!=d)if(b.isFunction(p))f.conditional=!!p.call(h,i,c);else for(var x=p.split(/[\s\t]+/),y=0,z=x.length;z>y;y++)c.conditional.hasOwnProperty(x[y])&&!c.conditional[x[y]].call(h,i,c)&&(f.conditional=!1);if(q=u.test(q),q&&(h.is(e[0]+","+e[1])?!i.length>0&&(f.required=!1):h.is(e[2])&&(h.is("[name]")?0==b('[name="'+h.prop("name")+'"]:checked').length&&(f.required=!1):f.required=h.is(":checked"))),h.is(e[0]))if(m.test(i)){if("keyup"!=a.type&&o!==d){for(var A=i.match(m),B=0,z=A.length;z>B;B++)o=o.replace(RegExp("\\$\\{"+B+"(?::`([^`]*)`)?\\}","g"),A[B]!==d?A[B]:"$1");o=o.replace(/\$\{\d+(?::`([^`]*)`)?\}/g,"$1"),m.test(o)&&h.val(o)}}else q?f.pattern=!1:i.length>0&&(f.pattern=!1);var C=b('[id="'+r+'"]'),D=s.valid;return C.length>0&&"keyup"!=a.type&&(f.required?f.pattern?f.conditional||(D=s.conditional):D=s.pattern:D=s.required,C.html(D||"")),"function"==typeof k.each&&k.each.call(h,a,f,c),c.eachField.call(h,a,f,c),f.required&&f.pattern&&f.conditional?(c.waiAria&&h.prop("aria-invalid",!1),"function"==typeof k.valid&&k.valid.call(h,a,f,c),c.eachValidField.call(h,a,f,c)):(c.waiAria&&h.prop("aria-invalid",!0),"function"==typeof k.invalid&&k.invalid.call(h,a,f,c),c.eachInvalidField.call(h,a,f,c)),f};b.extend({validateExtend:function(a){return b.extend(g,a)},validateSetup:function(c){return b.extend(a,c)}}).fn.extend({validate:function(c){return c=b.extend({},a,c),b(this).validateDestroy().each(function(){var a=b(this);if(a.is("form")){a.data(name,{options:c});var d=a.find(f),g=c.namespace;a.is("[id]")&&(d=d.add('[form="'+a.prop("id")+'"]').filter(f)),d=d.filter(c.filter),c.onKeyup&&d.filter(e[0]).on("keyup."+g,function(a){h.call(this,a,c)}),c.onBlur&&d.on("blur."+g,function(a){h.call(this,a,c)}),c.onChange&&d.on("change."+g,function(a){h.call(this,a,c)}),c.onSubmit&&a.on("submit."+g,function(e){var f=!0;d.each(function(){var a=h.call(this,e,c);a.pattern&&a.conditional&&a.required||(f=!1)}),f?(c.sendForm||e.preventDefault(),b.isFunction(c.valid)&&c.valid.call(a,e,c)):(e.preventDefault(),b.isFunction(c.invalid)&&c.invalid.call(a,e,c))})}})},validateDestroy:function(){var a=b(this),c=a.data(name);if(a.is("form")&&b.isPlainObject(c)&&"string"==typeof c.options.nameSpace){var d=a.removeData(name).find(f).add(a);a.is("[id]")&&(d=d.add(b('[form="'+a.prop("id")+'"]').filter(f))),d.off("."+c.options.nameSpace)}return a}})})({sendForm:!0,waiAria:!0,onSubmit:!0,onKeyup:!1,onBlur:!1,onChange:!1,nameSpace:"validate",conditional:{},prepare:{},description:{},eachField:$.noop,eachInvalidField:$.noop,eachValidField:$.noop,invalid:$.noop,valid:$.noop,filter:"*"},jQuery,window);

/* jquery.from */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):e("undefined"!=typeof jQuery?jQuery:window.Zepto)}(function(e){"use strict";function t(t){var r=t.data;t.isDefaultPrevented()||(t.preventDefault(),e(t.target).ajaxSubmit(r))}function r(t){var r=t.target,a=e(r);if(!a.is("[type=submit],[type=image]")){var n=a.closest("[type=submit]");if(0===n.length)return;r=n[0]}var i=this;if(i.clk=r,"image"==r.type)if(void 0!==t.offsetX)i.clk_x=t.offsetX,i.clk_y=t.offsetY;else if("function"==typeof e.fn.offset){var o=a.offset();i.clk_x=t.pageX-o.left,i.clk_y=t.pageY-o.top}else i.clk_x=t.pageX-r.offsetLeft,i.clk_y=t.pageY-r.offsetTop;setTimeout(function(){i.clk=i.clk_x=i.clk_y=null},100)}function a(){if(e.fn.ajaxSubmit.debug){var t="[jquery.form] "+Array.prototype.join.call(arguments,"");window.console&&window.console.log?window.console.log(t):window.opera&&window.opera.postError&&window.opera.postError(t)}}var n={};n.fileapi=void 0!==e("<input type='file'/>").get(0).files,n.formdata=void 0!==window.FormData;var i=!!e.fn.prop;e.fn.attr2=function(){if(!i)return this.attr.apply(this,arguments);var e=this.prop.apply(this,arguments);return e&&e.jquery||"string"==typeof e?e:this.attr.apply(this,arguments)},e.fn.ajaxSubmit=function(t){function r(r){var a,n,i=e.param(r,t.traditional).split("&"),o=i.length,s=[];for(a=0;o>a;a++)i[a]=i[a].replace(/\+/g," "),n=i[a].split("="),s.push([decodeURIComponent(n[0]),decodeURIComponent(n[1])]);return s}function o(a){for(var n=new FormData,i=0;i<a.length;i++)n.append(a[i].name,a[i].value);if(t.extraData){var o=r(t.extraData);for(i=0;i<o.length;i++)o[i]&&n.append(o[i][0],o[i][1])}t.data=null;var s=e.extend(!0,{},e.ajaxSettings,t,{contentType:!1,processData:!1,cache:!1,type:u||"POST"});t.uploadProgress&&(s.xhr=function(){var r=e.ajaxSettings.xhr();return r.upload&&r.upload.addEventListener("progress",function(e){var r=0,a=e.loaded||e.position,n=e.total;e.lengthComputable&&(r=Math.ceil(a/n*100)),t.uploadProgress(e,a,n,r)},!1),r}),s.data=null;var c=s.beforeSend;return s.beforeSend=function(e,r){r.data=t.formData?t.formData:n,c&&c.call(this,e,r)},e.ajax(s)}function s(r){function n(e){var t=null;try{e.contentWindow&&(t=e.contentWindow.document)}catch(r){a("cannot get iframe.contentWindow document: "+r)}if(t)return t;try{t=e.contentDocument?e.contentDocument:e.document}catch(r){a("cannot get iframe.contentDocument: "+r),t=e.document}return t}function o(){function t(){try{var e=n(g).readyState;a("state = "+e),e&&"uninitialized"==e.toLowerCase()&&setTimeout(t,50)}catch(r){a("Server abort: ",r," (",r.name,")"),s(k),j&&clearTimeout(j),j=void 0}}var r=f.attr2("target"),i=f.attr2("action"),o="multipart/form-data",c=f.attr("enctype")||f.attr("encoding")||o;w.setAttribute("target",p),(!u||/post/i.test(u))&&w.setAttribute("method","POST"),i!=m.url&&w.setAttribute("action",m.url),m.skipEncodingOverride||u&&!/post/i.test(u)||f.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"}),m.timeout&&(j=setTimeout(function(){T=!0,s(D)},m.timeout));var l=[];try{if(m.extraData)for(var d in m.extraData)m.extraData.hasOwnProperty(d)&&l.push(e.isPlainObject(m.extraData[d])&&m.extraData[d].hasOwnProperty("name")&&m.extraData[d].hasOwnProperty("value")?e('<input type="hidden" name="'+m.extraData[d].name+'">').val(m.extraData[d].value).appendTo(w)[0]:e('<input type="hidden" name="'+d+'">').val(m.extraData[d]).appendTo(w)[0]);m.iframeTarget||v.appendTo("body"),g.attachEvent?g.attachEvent("onload",s):g.addEventListener("load",s,!1),setTimeout(t,15);try{w.submit()}catch(h){var x=document.createElement("form").submit;x.apply(w)}}finally{w.setAttribute("action",i),w.setAttribute("enctype",c),r?w.setAttribute("target",r):f.removeAttr("target"),e(l).remove()}}function s(t){if(!x.aborted&&!F){if(M=n(g),M||(a("cannot access response document"),t=k),t===D&&x)return x.abort("timeout"),void S.reject(x,"timeout");if(t==k&&x)return x.abort("server abort"),void S.reject(x,"error","server abort");if(M&&M.location.href!=m.iframeSrc||T){g.detachEvent?g.detachEvent("onload",s):g.removeEventListener("load",s,!1);var r,i="success";try{if(T)throw"timeout";var o="xml"==m.dataType||M.XMLDocument||e.isXMLDoc(M);if(a("isXml="+o),!o&&window.opera&&(null===M.body||!M.body.innerHTML)&&--O)return a("requeing onLoad callback, DOM not available"),void setTimeout(s,250);var u=M.body?M.body:M.documentElement;x.responseText=u?u.innerHTML:null,x.responseXML=M.XMLDocument?M.XMLDocument:M,o&&(m.dataType="xml"),x.getResponseHeader=function(e){var t={"content-type":m.dataType};return t[e.toLowerCase()]},u&&(x.status=Number(u.getAttribute("status"))||x.status,x.statusText=u.getAttribute("statusText")||x.statusText);var c=(m.dataType||"").toLowerCase(),l=/(json|script|text)/.test(c);if(l||m.textarea){var f=M.getElementsByTagName("textarea")[0];if(f)x.responseText=f.value,x.status=Number(f.getAttribute("status"))||x.status,x.statusText=f.getAttribute("statusText")||x.statusText;else if(l){var p=M.getElementsByTagName("pre")[0],h=M.getElementsByTagName("body")[0];p?x.responseText=p.textContent?p.textContent:p.innerText:h&&(x.responseText=h.textContent?h.textContent:h.innerText)}}else"xml"==c&&!x.responseXML&&x.responseText&&(x.responseXML=X(x.responseText));try{E=_(x,c,m)}catch(y){i="parsererror",x.error=r=y||i}}catch(y){a("error caught: ",y),i="error",x.error=r=y||i}x.aborted&&(a("upload aborted"),i=null),x.status&&(i=x.status>=200&&x.status<300||304===x.status?"success":"error"),"success"===i?(m.success&&m.success.call(m.context,E,"success",x),S.resolve(x.responseText,"success",x),d&&e.event.trigger("ajaxSuccess",[x,m])):i&&(void 0===r&&(r=x.statusText),m.error&&m.error.call(m.context,x,i,r),S.reject(x,"error",r),d&&e.event.trigger("ajaxError",[x,m,r])),d&&e.event.trigger("ajaxComplete",[x,m]),d&&!--e.active&&e.event.trigger("ajaxStop"),m.complete&&m.complete.call(m.context,x,i),F=!0,m.timeout&&clearTimeout(j),setTimeout(function(){m.iframeTarget?v.attr("src",m.iframeSrc):v.remove(),x.responseXML=null},100)}}}var c,l,m,d,p,v,g,x,y,b,T,j,w=f[0],S=e.Deferred();if(S.abort=function(e){x.abort(e)},r)for(l=0;l<h.length;l++)c=e(h[l]),i?c.prop("disabled",!1):c.removeAttr("disabled");if(m=e.extend(!0,{},e.ajaxSettings,t),m.context=m.context||m,p="jqFormIO"+(new Date).getTime(),m.iframeTarget?(v=e(m.iframeTarget),b=v.attr2("name"),b?p=b:v.attr2("name",p)):(v=e('<iframe name="'+p+'" src="'+m.iframeSrc+'" />'),v.css({position:"absolute",top:"-1000px",left:"-1000px"})),g=v[0],x={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(t){var r="timeout"===t?"timeout":"aborted";a("aborting upload... "+r),this.aborted=1;try{g.contentWindow.document.execCommand&&g.contentWindow.document.execCommand("Stop")}catch(n){}v.attr("src",m.iframeSrc),x.error=r,m.error&&m.error.call(m.context,x,r,t),d&&e.event.trigger("ajaxError",[x,m,r]),m.complete&&m.complete.call(m.context,x,r)}},d=m.global,d&&0===e.active++&&e.event.trigger("ajaxStart"),d&&e.event.trigger("ajaxSend",[x,m]),m.beforeSend&&m.beforeSend.call(m.context,x,m)===!1)return m.global&&e.active--,S.reject(),S;if(x.aborted)return S.reject(),S;y=w.clk,y&&(b=y.name,b&&!y.disabled&&(m.extraData=m.extraData||{},m.extraData[b]=y.value,"image"==y.type&&(m.extraData[b+".x"]=w.clk_x,m.extraData[b+".y"]=w.clk_y)));var D=1,k=2,A=e("meta[name=csrf-token]").attr("content"),L=e("meta[name=csrf-param]").attr("content");L&&A&&(m.extraData=m.extraData||{},m.extraData[L]=A),m.forceSync?o():setTimeout(o,10);var E,M,F,O=50,X=e.parseXML||function(e,t){return window.ActiveXObject?(t=new ActiveXObject("Microsoft.XMLDOM"),t.async="false",t.loadXML(e)):t=(new DOMParser).parseFromString(e,"text/xml"),t&&t.documentElement&&"parsererror"!=t.documentElement.nodeName?t:null},C=e.parseJSON||function(e){return window.eval("("+e+")")},_=function(t,r,a){var n=t.getResponseHeader("content-type")||"",i="xml"===r||!r&&n.indexOf("xml")>=0,o=i?t.responseXML:t.responseText;return i&&"parsererror"===o.documentElement.nodeName&&e.error&&e.error("parsererror"),a&&a.dataFilter&&(o=a.dataFilter(o,r)),"string"==typeof o&&("json"===r||!r&&n.indexOf("json")>=0?o=C(o):("script"===r||!r&&n.indexOf("javascript")>=0)&&e.globalEval(o)),o};return S}if(!this.length)return a("ajaxSubmit: skipping submit process - no element selected"),this;var u,c,l,f=this;"function"==typeof t?t={success:t}:void 0===t&&(t={}),u=t.type||this.attr2("method"),c=t.url||this.attr2("action"),l="string"==typeof c?e.trim(c):"",l=l||window.location.href||"",l&&(l=(l.match(/^([^#]+)/)||[])[1]),t=e.extend(!0,{url:l,success:e.ajaxSettings.success,type:u||e.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},t);var m={};if(this.trigger("form-pre-serialize",[this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(t.beforeSerialize&&t.beforeSerialize(this,t)===!1)return a("ajaxSubmit: submit aborted via beforeSerialize callback"),this;var d=t.traditional;void 0===d&&(d=e.ajaxSettings.traditional);var p,h=[],v=this.formToArray(t.semantic,h);if(t.data&&(t.extraData=t.data,p=e.param(t.data,d)),t.beforeSubmit&&t.beforeSubmit(v,this,t)===!1)return a("ajaxSubmit: submit aborted via beforeSubmit callback"),this;if(this.trigger("form-submit-validate",[v,this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;var g=e.param(v,d);p&&(g=g?g+"&"+p:p),"GET"==t.type.toUpperCase()?(t.url+=(t.url.indexOf("?")>=0?"&":"?")+g,t.data=null):t.data=g;var x=[];if(t.resetForm&&x.push(function(){f.resetForm()}),t.clearForm&&x.push(function(){f.clearForm(t.includeHidden)}),!t.dataType&&t.target){var y=t.success||function(){};x.push(function(r){var a=t.replaceTarget?"replaceWith":"html";e(t.target)[a](r).each(y,arguments)})}else t.success&&x.push(t.success);if(t.success=function(e,r,a){for(var n=t.context||this,i=0,o=x.length;o>i;i++)x[i].apply(n,[e,r,a||f,f])},t.error){var b=t.error;t.error=function(e,r,a){var n=t.context||this;b.apply(n,[e,r,a,f])}}if(t.complete){var T=t.complete;t.complete=function(e,r){var a=t.context||this;T.apply(a,[e,r,f])}}var j=e("input[type=file]:enabled",this).filter(function(){return""!==e(this).val()}),w=j.length>0,S="multipart/form-data",D=f.attr("enctype")==S||f.attr("encoding")==S,k=n.fileapi&&n.formdata;a("fileAPI :"+k);var A,L=(w||D)&&!k;t.iframe!==!1&&(t.iframe||L)?t.closeKeepAlive?e.get(t.closeKeepAlive,function(){A=s(v)}):A=s(v):A=(w||D)&&k?o(v):e.ajax(t),f.removeData("jqxhr").data("jqxhr",A);for(var E=0;E<h.length;E++)h[E]=null;return this.trigger("form-submit-notify",[this,t]),this},e.fn.ajaxForm=function(n){if(n=n||{},n.delegation=n.delegation&&e.isFunction(e.fn.on),!n.delegation&&0===this.length){var i={s:this.selector,c:this.context};return!e.isReady&&i.s?(a("DOM not ready, queuing ajaxForm"),e(function(){e(i.s,i.c).ajaxForm(n)}),this):(a("terminating; zero elements found by selector"+(e.isReady?"":" (DOM not ready)")),this)}return n.delegation?(e(document).off("submit.form-plugin",this.selector,t).off("click.form-plugin",this.selector,r).on("submit.form-plugin",this.selector,n,t).on("click.form-plugin",this.selector,n,r),this):this.ajaxFormUnbind().bind("submit.form-plugin",n,t).bind("click.form-plugin",n,r)},e.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")},e.fn.formToArray=function(t,r){var a=[];if(0===this.length)return a;var i,o=this[0],s=this.attr("id"),u=t?o.getElementsByTagName("*"):o.elements;if(u&&!/MSIE [678]/.test(navigator.userAgent)&&(u=e(u).get()),s&&(i=e(':input[form="'+s+'"]').get(),i.length&&(u=(u||[]).concat(i))),!u||!u.length)return a;var c,l,f,m,d,p,h;for(c=0,p=u.length;p>c;c++)if(d=u[c],f=d.name,f&&!d.disabled)if(t&&o.clk&&"image"==d.type)o.clk==d&&(a.push({name:f,value:e(d).val(),type:d.type}),a.push({name:f+".x",value:o.clk_x},{name:f+".y",value:o.clk_y}));else if(m=e.fieldValue(d,!0),m&&m.constructor==Array)for(r&&r.push(d),l=0,h=m.length;h>l;l++)a.push({name:f,value:m[l]});else if(n.fileapi&&"file"==d.type){r&&r.push(d);var v=d.files;if(v.length)for(l=0;l<v.length;l++)a.push({name:f,value:v[l],type:d.type});else a.push({name:f,value:"",type:d.type})}else null!==m&&"undefined"!=typeof m&&(r&&r.push(d),a.push({name:f,value:m,type:d.type,required:d.required}));if(!t&&o.clk){var g=e(o.clk),x=g[0];f=x.name,f&&!x.disabled&&"image"==x.type&&(a.push({name:f,value:g.val()}),a.push({name:f+".x",value:o.clk_x},{name:f+".y",value:o.clk_y}))}return a},e.fn.formSerialize=function(t){return e.param(this.formToArray(t))},e.fn.fieldSerialize=function(t){var r=[];return this.each(function(){var a=this.name;if(a){var n=e.fieldValue(this,t);if(n&&n.constructor==Array)for(var i=0,o=n.length;o>i;i++)r.push({name:a,value:n[i]});else null!==n&&"undefined"!=typeof n&&r.push({name:this.name,value:n})}}),e.param(r)},e.fn.fieldValue=function(t){for(var r=[],a=0,n=this.length;n>a;a++){var i=this[a],o=e.fieldValue(i,t);null===o||"undefined"==typeof o||o.constructor==Array&&!o.length||(o.constructor==Array?e.merge(r,o):r.push(o))}return r},e.fieldValue=function(t,r){var a=t.name,n=t.type,i=t.tagName.toLowerCase();if(void 0===r&&(r=!0),r&&(!a||t.disabled||"reset"==n||"button"==n||("checkbox"==n||"radio"==n)&&!t.checked||("submit"==n||"image"==n)&&t.form&&t.form.clk!=t||"select"==i&&-1==t.selectedIndex))return null;if("select"==i){var o=t.selectedIndex;if(0>o)return null;for(var s=[],u=t.options,c="select-one"==n,l=c?o+1:u.length,f=c?o:0;l>f;f++){var m=u[f];if(m.selected){var d=m.value;if(d||(d=m.attributes&&m.attributes.value&&!m.attributes.value.specified?m.text:m.value),c)return d;s.push(d)}}return s}return e(t).val()},e.fn.clearForm=function(t){return this.each(function(){e("input,select,textarea",this).clearFields(t)})},e.fn.clearFields=e.fn.clearInputs=function(t){var r=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var a=this.type,n=this.tagName.toLowerCase();r.test(a)||"textarea"==n?this.value="":"checkbox"==a||"radio"==a?this.checked=!1:"select"==n?this.selectedIndex=-1:"file"==a?/MSIE/.test(navigator.userAgent)?e(this).replaceWith(e(this).clone(!0)):e(this).val(""):t&&(t===!0&&/hidden/.test(a)||"string"==typeof t&&e(this).is(t))&&(this.value="")})},e.fn.resetForm=function(){return this.each(function(){("function"==typeof this.reset||"object"==typeof this.reset&&!this.reset.nodeType)&&this.reset()})},e.fn.enable=function(e){return void 0===e&&(e=!0),this.each(function(){this.disabled=!e})},e.fn.selected=function(t){return void 0===t&&(t=!0),this.each(function(){var r=this.type;if("checkbox"==r||"radio"==r)this.checked=t;else if("option"==this.tagName.toLowerCase()){var a=e(this).parent("select");t&&a[0]&&"select-one"==a[0].type&&a.find("option").selected(!1),this.selected=t}})},e.fn.ajaxSubmit.debug=!1});

/* my plugin */
;(function($, window, document, undefined) {

    var Submiter = function(element, options) { //构造函数
        var errorTextHold = '{req-error-text}';
        var successTextHold = '{req-success-text}';

        this.defaults = {
            'succCode': 0, //成功的错误码

            'retCodeField': 'code', //返回结果中code的字段
            'retMessField': 'msg', //返回结果中msg的字段

            'attrHttpFailAlert': 'error-alert', //http错误是否弹框
            'attrSrvSuccAlert': 'succ-alert', //业务成功是否弹框
            'attrSrvFailAlert': 'fail-alert', //业务错误是否弹框

            'attrBeforeCall': 'before-call', // 默认beforeSubmit, 发送http请求前调用
            'attrErrorCall': 'error-call', // 默认failSubmit, http请求失败情况下调用
            'attrDataCall': 'data-call', // 默认dataSet, 设置要发送的数据
            'attrSuccCall': 'succ-call', // 默认srvSucc, 业务返回成功的状态码时调用
            'attrFailCall': 'fail-call', // 默认srvFail, 业务返回失败的状态码时调用
            'attrEventType': 'event-type', // 默认click, 发生指定事件时触发请求
            'attrHttpLock': 'http-lock', // 默认http-lock, 请求中这个值为true
            'attrAction': 'action', // 默认""，请求的地址
            'attrMethod': 'method', // 默认post, 请求方法
            'attrDataType': 'data-type', // 默认json, 返回数据格式
            'attrData': 'data', // 默认"", 请求的数据
            'attrAsync': 'async', // 默认false, 请求方式
            'attrConfirm': 'confirm', // 弹层确认层

            'attrSuccJump': 'succ-jump', //业务成功时，跳转地址
            'attrSuccReload': 'succ-reload', //业务成功时，刷新本页

            'classAjaxInput': '.ajax-input', //简单请求时候加的class
            'classAjaxForm': '.ajax-form', //表单请求时候加的class

            'msgError': '系统错误，操作失败，请稍后再试', //http失败信息
            'msgFail': '操作失败，请稍后重试', //业务失败信息
            'msgSucc': '操作已成功', //业务成功信息

            'onBlur': true, //失去焦点验证
            'sendForm': false, //表单验证通过后提交方式 true 同步提交 false 异步提交, 结合requset插件使用

            'attrConfirmTarget': 'confirm-target', //确认值的属性，用于再次输入密码
            'attrMinLen': 'min-len', // 最小长度属性
            'attrMaxLen': 'max-len', // 最大长度属性
            'attrMinVal': 'min-val', // 最小值属性
            'attrMaxVal': 'max-val', // 最大值属性
            'attrInList': 'in-list', // 在列表中属性

            'showErrorDesc': 'true', //显示具体错误消息
            'attrShowError': 'show-desc', //这个控件是否显示信息
            'attrDescTarget': 'desc-target', //指定显示错误控件的属性名称
            'attrSuccDesc': 'success-desc', //成功时文本描述

            'errorInputClass': 'req-input-error', //错误时控件的样式
            'descWrapHtml': '<span></span>', //包裹提示信息的html
            'descWrapClass': 'req-desc-info', //包裹提示信息的class

            'errorTextHold': errorTextHold, //错误信息的占位坑
            'successTextHold': successTextHold, //成功信息的占位坑
            'defaultErrorHtml': '<i class="req-error-icon"></i><span class="req-error-text">' + errorTextHold + '</span>', //错误时显示
            'defaultSucceHtml': '<i class="req-success-icon"></i><span class="req-success-text">' + successTextHold + '</span>', //正确时显示

            'regexMap': {} //正则
        };

        this.element = element;
        this.options = $.extend({}, this.defaults, options);
        this.regexMap = {
            'word': '^[\\u4e00-\\u9fa5]{0,}$',
            'id': '^\\d{8,18}|[0-9x]{8,18}|[0-9X]{8,18}?$',
            'url': '^[a-zA-z]+://([\\w-]+\\.)+[\\w-]+(/[\\w-./?%&=]*)?$',
            'email': '^\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*$',
            'money': '^(([1-9][0-9]*)|(([0]\\.\\d{1,2}|[1-9][0-9]*\\.\\d{1,2})))$',
            'mobile': '^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\\d{8}$',
            'domain': '^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$',
            'ip': '^((?:(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d)\\.){3}(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d))$'
        };

        this.options.regexMap = $.extend({}, this.regexMap, this.options.regexMap);
    };

    Submiter.prototype = {
        getConditional: function() {
            var thisObj = this;
            var element = thisObj.element;
            var options = thisObj.options;

            var replaceReg = /(^[,， 　]*)|([ 　,，]*$)/g;
            var splitReg = /[ 　,，]+/g;

            var conditional = {//验证规则
                confirm: function() {//密码验证
                    var thisCtrl = $(this);
                    var cmpTarget = thisCtrl.attr(options.attrConfirmTarget);
                    if (undefined != cmpTarget) {
                        return thisCtrl.val() == $(cmpTarget).val();
                    }
                    return true;
                },
                groupRequired: function() {//组不能为空 checkbox radio
                    var thisCtrl = $(this);
                    return $('[name="' + thisCtrl.attr('name') + '"]:checked', element).size() > 0;
                },
                length: function() {//长度验证
                    var thisCtrl = $(this);
                    var length = thisCtrl.val().length;
                    var minLen = thisCtrl.attr(options.attrMinLen);
                    if (undefined != minLen && length < minLen) {
                        return false;
                    }
                    var maxLen = thisCtrl.attr(options.attrMaxLen);
                    if (undefined != maxLen && length > maxLen) {
                        return false;
                    }
                    return true;
                },
                between: function() {//区间验证
                    var thisCtrl = $(this);
                    var thisVal = Number(thisCtrl.val());
                    var minVal = thisCtrl.attr(options.attrMinVal);
                    if (undefined != minVal && Number(minVal) > thisVal) {
                        return false;
                    }
                    var maxVal = thisCtrl.attr(options.attrMaxVal);
                    if (undefined != maxVal && Number(maxVal) < thisVal) {
                        return false;
                    }
                    return true;
                },
                inclusion: function() {//列表验证
                    var thisCtrl = $(this);
                    var inList = thisCtrl.attr(options.attrInList);
                    if (undefined === inList) {
                        return true;
                    }
                    return -1 != $.inArray(thisCtrl.val(), inList.replace(replaceReg, '').split(splitReg));
                },
                ext: function() {//扩展名验证
                    var thisCtrl = $(this);
                    var inList = thisCtrl.attr(options.attrInList);
                    if (undefined === inList) {
                        return true;
                    }
                    return -1 != $.inArray(thisCtrl.val().split('.').pop(), inList.replace(replaceReg, '').split(splitReg));
                },
                remote: function() {//ajax校验
                    var oldEventSource = options.eventSource;
                    var oldTargetForm = options.targetForm;

                    var thisCtrl = $(this);
                    options.eventSource = thisCtrl;
                    options.targetForm = element;

                    var checkRes = false;
                    thisCtrl.attr(options.attrErrorCall, 'remoteFailSubmit');
                    options.remoteFailSubmit = function() {
                        checkRes = false;
                    };

                    thisCtrl.attr(options.attrSuccCall, 'remoteSrvSucc');
                    options.remoteSrvSucc = function(result) {
                        checkRes = true;
                    };

                    thisCtrl.attr(options.attrFailCall, 'remoteSrvFail');
                    options.remoteSrvFail = function(result) {
                        checkRes = false;
                    };

                    thisObj.inputSubmit();
                    options.eventSource = oldEventSource;
                    options.targetForm = oldTargetForm;
                    return checkRes;
                }
            };

            return $.extend({}, conditional, options.conditional);
        },
        getCheckerOptions: function() {//验证器属性
            var thisObj = this;
            var options = thisObj.options;

            var valiOpt = {onBlur: options.onBlur, sendForm: options.sendForm};
            valiOpt.conditional = thisObj.getConditional();

            valiOpt.eachInvalidField = function(event, ruleRes, validator) { //错误时调用
                var thisCtrl = $(this);
                thisCtrl.addClass(options.errorInputClass);

                var showError = thisCtrl.attr(options.attrShowError) || options.showErrorDesc;
                if ('false' == showError) {
                    return false;
                }

                var errorType = '';
                for (var type in ruleRes) {
                    if (!ruleRes[type]) {
                        errorType = type;
                        break;
                    }
                }

                var errorHtml = options.defaultErrorHtml.replace(options.errorTextHold, thisCtrl.attr('error-' + errorType) || '&nbsp;');
                var targetSelector = thisCtrl.attr(options.attrDescTarget);
                if (undefined != targetSelector && $(targetSelector).length > 0) {
                    $(targetSelector).addClass(options.descWrapClass).html(errorHtml);
                } else {
                    if (thisCtrl.is("input[type='checkbox']") || thisCtrl.is("input[type='radio']")) { //checkbox radio label包裹
                        var parentObj = thisCtrl.parent('label').length > 0 ? thisCtrl.parent('label').parent() : thisCtrl.parent();
                        var descWrapObj = $('.' + options.descWrapClass, parentObj);
                        descWrapObj.length > 0 ? descWrapObj.html(errorHtml) : parentObj.append($(options.descWrapHtml).addClass(options.descWrapClass).append(errorHtml));
                    } else {
                        var descWrapObj = thisCtrl.next('.' + options.descWrapClass);
                        descWrapObj.length > 0 ? descWrapObj.html(errorHtml) : thisCtrl.after($(options.descWrapHtml).addClass(options.descWrapClass).append(errorHtml));
                    }
                }
            };

            valiOpt.eachValidField = function(event, ruleRes, validator) {//正确时调用
                var thisCtrl = $(this);
                thisCtrl.removeClass(options.errorInputClass);

                var showError = thisCtrl.attr(options.attrShowError) || options.showErrorDesc;
                if ('false' == showError) {
                    return false;
                }

                var successHtml = options.defaultSucceHtml.replace(options.successTextHold, thisCtrl.attr(options.attrSuccDesc) || '&nbsp;');
                var targetSelector = thisCtrl.attr(options.attrDescTarget);
                if (undefined != targetSelector && $(targetSelector).length > 0) {
                    $(targetSelector).addClass(options.descWrapClass).html(successHtml);
                } else {
                    if (thisCtrl.is("input[type='checkbox']") || thisCtrl.is("input[type='radio']")) { //checkbox radio label包裹
                        var parentObj = thisCtrl.parent('label').length > 0 ? thisCtrl.parent('label').parent() : thisCtrl.parent();
                        var descWrapObj = $('.' + options.descWrapClass, parentObj);
                        descWrapObj.length > 0 ? descWrapObj.html(successHtml) : parentObj.append($(options.descWrapHtml).addClass(options.descWrapClass).append(successHtml));
                    } else {
                        var descWrapObj = thisCtrl.next('.' + options.descWrapClass);
                        descWrapObj.length > 0 ? descWrapObj.html(successHtml) : thisCtrl.after($(options.descWrapHtml).addClass(options.descWrapClass).append(successHtml));
                    }
                }
            };

            valiOpt.valid = function(event, ruleRes, validator) { //验证通过
                if (options.sendForm) {
                    return true;
                }
                thisObj.formSubmit();
                return false;
            };

            return valiOpt;
        },
        initChecker: function(targetFrom) { //初始化校验器
            var thisObj = this;
            var element = thisObj.element;
            var options = thisObj.options;
            var attrRegex = 'data-pattern';
            $('[' + attrRegex + ']', element).each(function() {
                var regex = $(this).attr(attrRegex);
                if (undefined != options.regexMap[regex]) {
                    $(this).attr(attrRegex, options.regexMap[regex]);
                }
            });
            targetFrom.validate(thisObj.getCheckerOptions());
        },
        initSubmiter: function() { //初始化
            var thisObj = this;
            var element = thisObj.element;
            var options = thisObj.options;

            $(options.classAjaxInput, element).each(function() {
                var eventType = $(this).attr(options.attrEventType) || 'click';
                $(this).bind(eventType, function() {
                    options.eventSource = $(this);
                    options.targetForm = element;
                    thisObj.inputSubmit();
                });
            });

            var ajaxFormBtns = $(options.classAjaxForm, element);
            if (ajaxFormBtns.length <= 0) {
                return element;
            }

            var targetForm = element.is('form') ? element : ajaxFormBtns.parents('form');
            if (targetForm.length <= 0) {
                return element;
            }

            thisObj.initChecker(targetForm);
            ajaxFormBtns.each(function() {
                var eventType = $(this).attr(options.attrEventType) || 'click';
                $(this).bind(eventType, function() {
                    options.eventSource = $(this);
                    options.targetForm = targetForm;
                });
            });

            return element;
        },
        showDialog: function(msg, type) { //展示对话框 type 取值 1 info  2  error 3 confirm
            return 1 == type || 2 == type ? alert(msg) : confirm(msg);
        },
        showConfirm: function() { //展示确认框
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var confirmMsg = eventSource.attr(options.attrConfirm) || 'false';
            return 'false' != confirmMsg ? thisObj.showDialog(confirmMsg, 3) : true;
        },
        isHttpLock: function() { //是否http锁住了
            var thisObj = this;
            var options = thisObj.options;

            var eventSource = options.eventSource;
            var isLock = eventSource.attr(options.attrHttpLock) || 'false';
            return 'true' == isLock;
        },
        addHttpLock: function() { //加httpLock
            var thisObj = this;
            var options = thisObj.options;

            var eventSource = options.eventSource;
            eventSource.addClass('disabled').attr('disabled', 'disabled').attr(options.attrHttpLock, 'true');
        },
        releaseHttpLock: function() {//释放httpLock
            var thisObj = this;
            var options = thisObj.options;

            var eventSource = options.eventSource;
            eventSource.removeClass('disabled').removeAttr('disabled').attr(options.attrHttpLock, 'false');
        },
        beforeHttp: function() { //前置调用
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            thisObj.addHttpLock();
            var beforeSubmit = eventSource.attr(options.attrBeforeCall) || targetForm.attr(options.attrBeforeCall) || 'beforeSubmit';
            if (undefined == options[beforeSubmit]) {
                return true;
            }

            var element = thisObj.element;
            if (options[beforeSubmit](element, options)) {
                return true;
            }

            thisObj.releaseHttpLock();
            return false;
        },
        inputData: function() { //简单请求的post的数据
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            var dataSet = eventSource.attr(options.attrDataCall) || targetForm.attr(options.attrDataCall) || 'dataSet';
            if (undefined != options[dataSet]) {
                var element = thisObj.element;
                return options[dataSet](element, options);
            }

            if (undefined != eventSource.attr(options.attrData)) {
                return eventSource.attr(options.attrData);
            }

            var name = eventSource.attr('name');
            if (undefined == name) {
                return '';
            }

            if (eventSource.is('input[type="checkbox"]')) {
                var param = [];
                $("input[name='" + name + "']:checked").each(function() {
                    param.push(name + "=" + $(this).val());
                });
                return param.join('&');
            }

            return name + '=' + eventSource.val();
        },
        doOnSubmitFail: function() {//http请求失败
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            var failSubmit = eventSource.attr(options.attrErrorCall) || targetForm.attr(options.attrErrorCall) || 'failSubmit';
            if (undefined != options[failSubmit]) {
                var element = thisObj.element;
                options[failSubmit](element, options);
                return true;
            }

            var showAlert = eventSource.attr(options.attrHttpFailAlert) || targetForm.attr(options.attrHttpFailAlert) || 'true';
            if ('true' == showAlert) {
                thisObj.showDialog(options.msgError, 2);
            }
        },
        doOnSrvSuccess: function(result) {//业务错误调用
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            var srvSucc = eventSource.attr(options.attrSuccCall) || targetForm.attr(options.attrSuccCall) || 'srvSucc';
            if (undefined != options[srvSucc]) {
                var element = thisObj.element;
                options[srvSucc](result, element, options);
                return true;
            }

            var showAlert = eventSource.attr(options.attrSrvSuccAlert) || targetForm.attr(options.attrSrvSuccAlert) || 'true';
            if ('true' == showAlert) {
                thisObj.showDialog(options.msgSucc, 1);
            }

            var jumpUrl = eventSource.attr(options.attrSuccJump) || targetForm.attr(options.attrSuccJump) || 'false';
            if ('false' != jumpUrl) {
                location.href = jumpUrl;
                return true;
            }

            var reload = eventSource.attr(options.attrSuccReload) || targetForm.attr(options.attrSuccReload) || 'true';
            if ('false' != reload) {
                location.reload();
            }
        },
        doOnSrvErrors: function(result) {//业务失败调用
            var thisObj = this;
            var options = thisObj.options;
            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            var srvFail = eventSource.attr(options.attrFailCall) || targetForm.attr(options.attrFailCall) || 'srvFail';
            if (undefined != options[srvFail]) {
                var element = thisObj.element;
                options[srvFail](result, element, options);
                return true;
            }

            var showAlert = eventSource.attr(options.attrSrvFailAlert) || targetForm.attr(options.attrSrvFailAlert) || 'true';
            if ('true' == showAlert) {
                var msgField = options.retMessField;
                var errMsg = result[msgField] == undefined || result[msgField].length <= 0 ? options.msgFail : result[msgField];
                thisObj.showDialog(errMsg, 2);
            }
        },
        inputSubmit: function() {//简单ajax
            var thisObj = this;
            if (!thisObj.showConfirm()) {
                return false;
            }

            if (thisObj.isHttpLock()) {
                return false;
            }

            if (!thisObj.beforeHttp()) {
                return false;
            }

            var options = thisObj.options;
            var eventSource = options.eventSource;

            $.ajax({
                data: thisObj.inputData(),
                url: eventSource.attr(options.attrAction) || '',
                type: eventSource.attr(options.attrMethod) || 'post',
                async: eventSource.attr(options.attrAsync) || false,
                dataType: eventSource.attr(options.attrDataType) || 'json',
                success: function(result) {
                    thisObj.releaseHttpLock();
                    var codeField = options.retCodeField;
                    if (options.succCode == result[codeField]) {
                        thisObj.doOnSrvSuccess(result);
                    } else {
                        thisObj.doOnSrvErrors(result);
                    }
                },
                error: function() {
                    thisObj.releaseHttpLock();
                    thisObj.doOnSubmitFail();
                }
            });
        },
        formSubmit: function() {//提交表单
            var thisObj = this;
            var options = thisObj.options;
            if (!thisObj.showConfirm()) {
                return false;
            }

            if (thisObj.isHttpLock()) {
                return false;
            }

            if (!thisObj.beforeHttp()) {
                return false;
            }

            var eventSource = options.eventSource;
            var targetForm = options.targetForm;

            targetForm.ajaxSubmit({
                url: eventSource.attr(options.attrAction) || targetForm.attr(options.attrAction) || '',
                type: eventSource.attr(options.attrMethod) || targetForm.attr(options.attrMethod) || 'post',
                async: eventSource.attr(options.attrAsync) || targetForm.attr(options.attrAsync) || false,
                dataType: eventSource.attr(options.attrDataType) || targetForm.attr(options.attrDataType) || 'json',
                success: function(result) {
                    thisObj.releaseHttpLock();
                    var codeField = options.retCodeField;
                    if (options.succCode == result[codeField]) {
                        thisObj.doOnSrvSuccess(result);
                    } else {
                        thisObj.doOnSrvErrors(result);
                    }
                },
                error: function() {
                    thisObj.releaseHttpLock();
                    thisObj.doOnSubmitFail();
                }
            });
        }

    };

    $.fn.request = function(options) {
        var submiter = new Submiter(this, options);
        return submiter.initSubmiter();
    };

})(jQuery, window, document);
