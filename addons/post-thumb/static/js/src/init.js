define(function(require, exports){
	'use strict';
	
	var tools = require('modules/tools');
	
	exports.config = {
		lang : {
			M01 : 'Loading, please wait..',
			E01 : 'Sorry, server error please try again later.'
		}
	}
	var config = exports.config,
		cache = {};
		
	exports.init = function(){
		tools.ready(exports.bind);
	}
	exports.bind = function(){
		cache.$btns = document.querySelectorAll('.theme_post_thumb-btn');
		if(!cache.$btns)
			return false;
			
		for(var i = 0, len = cache.$btns.length; i < len; i++){
			cache.$btns[i].addEventListener('click', ajax, false);
		}
	}
	function ajax(){
		var $this = this,
			$number = $this.querySelector('.number'),
			type = $this.getAttribute('data-thumb-type'),
			post_id = $this.getAttribute('data-post-id'),
			xhr = new XMLHttpRequest();

		tools.ajax_loading_tip('loading',config.lang.M01);

		xhr.open('GET',config.process_url + '&type=' + type + '&post-id=' + post_id);
		xhr.send();
		xhr.onload = function(){
			if(xhr.status >= 200 && xhr.status < 400){
				var data;
				try{data = JSON.parse(xhr.responseText);}catch(e){data = xhr.responseText}
				/** success */
				if(data && data.status){
					tools.ajax_loading_tip(data.status,data.msg,5);
					if(data.status === 'success' && data.code !== 'voted')
						$number.innerHTML = data.votes;
				}else{
					tools.ajax_loading_tip('error',data);
				}
			}else{
				tools.ajax_loading_tip('error',config.lang.E01);
			}
		};
		xhr.onerror = function(){
			tools.ajax_loading_tip('error',config.lang.E01);
		};
		return false;
	}
});