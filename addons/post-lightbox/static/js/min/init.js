
define(function(require,exports,module){'use strict';var tools=require('modules/tools');exports.init=function(){tools.ready(exports.bind);}
exports.bind=function(){var $post_content=document.querySelector('.post-content');if(!$post_content)
return;var $img=$post_content.querySelectorAll('a > img');if(!$img[0])
return false;for(var i=0,len=$img.length;i<len;i++){var $a=$img[i].parentNode;$a.target='_blank';}}});