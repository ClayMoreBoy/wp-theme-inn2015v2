define(function(require, exports){
	'use strict';
	var tools = require('modules/tools');
	
	exports.config = {
		lang : {
			M01 : 'Table of TOC',
			M02 : '[TOC]'
		}
	};
	
	var config = exports.config,
		cache = {};
		
	exports.init = function(){
		tools.ready(exports.bind);
	}
	exports.bind = function(){
		var $post_content = document.querySelector('.post-content');
		
		if(!$post_content)
			return false;

		exports.toc($post_content);
	}
	exports.toc = function($container){
		var $hs = $container.querySelectorAll('h1,h2,h3,h4,h5,h6');
		if(!$hs[1])
			return false;

		var toc_prefix = 'post-toc-',
			$toc_container = document.createElement('div'),
			$toc_title = document.createElement('div'),
			$toc_body = document.createElement('ol');
			
		/**
		 * create toc container
		 */
		$toc_container.id = 'post-toc';
		
		/**
		 * create toc title
		 */
		$toc_title.classList.add('toc-title');
		$toc_title.innerHTML = config.lang.M01 + ' <i class="fa fa-caret-down"></i>';
		/** click to fold */
		$toc_title.addEventListener('click', function (e) {
			if( $toc_container.classList.contains('fold') ){
				$toc_container.classList.remove('fold');
			}else{
				$toc_container.classList.add('fold');
			}
			return true;
		}, false);
		$toc_container.appendChild($toc_title);
		

		/**
		 * create toc content body
		 */
		
		$toc_container.appendChild($toc_body);

		/**
		 * foreach <h*>
		 */
		for(var i = 0, len = $hs.length; i<len; i++){
			var $h = $hs[i];
			if( !$h.id ){
				$h.id = toc_prefix + i;
			}
			/**
			 * create list
			 */
			var $li = document.createElement('li'),
				$link_to = document.createElement('a');
			$link_to.setAttribute('href','#' + $h.id);

			/** set text */
			if( $h.textContent != 'undefined '){
				$link_to.innerHTML = $h.textContent;
			}else{
				$link_to.innerHTML = $h.innerText;
			}
			
			/** appendChild to container */
			$li.appendChild($link_to);
			$toc_body.appendChild($li);

			/**
			 * add back link for h*
			 */
			var $back = document.createElement('a');
			$back.setAttribute('href','#post-toc');
			$back.classList.add('back-to-toc');
			$back.innerHTML = config.lang.M02;
			$h.appendChild($back);
			
		}

		/**
		 * prepend to container
		 */
		$container.insertBefore($toc_container, $container.firstChild);
		
	}
});