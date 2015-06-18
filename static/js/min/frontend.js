
define(function(require,exports,module){'use strict';require.async(['modules/lazyload','modules/bootstrap-without-jq'],function(_a,_b){});var tools=require('modules/tools');exports.config={is_home:false};exports.init=function(){tools.ready(function(){exports.hide_no_js();exports.scroll_menu();});};exports.scroll_menu=function(){var $menu=document.querySelector('.main-nav'),y=0,fold=false,st=false;if(!$menu)
return false;window.addEventListener('scroll',function(e){if(y<=this.pageYOffset){if(!fold){$menu.classList.add('fold');fold=true;}}else{if(fold){$menu.classList.remove('fold');fold=false;}}
y=this.pageYOffset;},false);}
exports.hide_no_js=function(){var A=function(e){return document.querySelectorAll(e);},$no_js=A('.hide-no-js'),$on_js=A('.hide-on-js');if($no_js[0]){Array.prototype.forEach.call($no_js,function(el){el.style.display='none';});}
if($on_js[0]){Array.prototype.forEach.call($on_js,function(el){el.style.display='block';});}};});