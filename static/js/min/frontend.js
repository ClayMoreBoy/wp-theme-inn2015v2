
define(function(require,exports,module){'use strict';require.async(['modules/lazyload','modules/bootstrap-without-jq'],function(_a,_b){});var tools=require('modules/tools');exports.config={is_home:false};exports.init=function(){tools.ready(function(){exports.hide_no_js();exports.scroll_menu();exports.search();});};exports.search=function(){var Q=function(s){return document.querySelector(s);},$btn=Q('.main-nav a.search');if(!$btn)
return false;var $fm=Q($btn.getAttribute('data-target')),$input=$fm.querySelector('input[type="search"]'),submit_helper=function(){if($input.value.trim()==='')
return false;};$btn.addEventListener('click',function(){setTimeout(function(){$input.focus();},100);},false);$fm.onsubmit=submit_helper;}
exports.scroll_menu=function(){var $menu=document.querySelector('.main-nav'),y=0,fold=false,st=false,uping=false;if(!$menu)
return false;function hide(){if(!fold){$menu.classList.add('fold');fold=true;}}
function show(){if(fold){$menu.classList.remove('fold');fold=false;}}
function dely_clearst(){clearTimeout(st);}
function delay_show(){if(uping){show();}else{if(uping)
clearTimeout(st);st=setTimeout(function(){if(!uping){uping=true;}},500);}}
window.addEventListener('scroll',function(){if(this.pageYOffset===0){show();}else if(y<=this.pageYOffset){hide();if(uping)
uping=false;}else{delay_show();}
y=this.pageYOffset;},false);}
exports.hide_no_js=function(){var A=function(e){return document.querySelectorAll(e);},$no_js=A('.hide-no-js'),$on_js=A('.hide-on-js');if($no_js[0]){Array.prototype.forEach.call($no_js,function(el){el.style.display='none';});}
if($on_js[0]){Array.prototype.forEach.call($on_js,function(el){el.style.display='block';});}};});