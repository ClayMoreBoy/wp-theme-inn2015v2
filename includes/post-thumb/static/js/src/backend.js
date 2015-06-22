define(function(require, exports, module){
	'use strict';

	var tools = require('modules/tools');
	
	exports.config = {
		lang : {
			M01 : 'Loading, please wait...',
			E01 : 'Sorry, server error please try again later.'
		},
		process_url : ''
	};

	var config = exports.config,
		cache = {},
		I = function(s){
			return document.getElementById(s);
		};
		
	exports.init = function(){
		tools.ready(exports.bind);
	};
	exports.bind = function(){
		cache.$btn = I('theme_post_thumb-convert');
		cache.$area = I('theme_post_thumb-btn-area');
		cache.$tip = I('theme_post_thumb-tip');


		if(!cache.$btn || !cache.$tip ||!cache.$area)
			return false;
		cache.$btn.addEventListener('click', ajax, false);
	}
	function ajax(){
		
		tip('loading',config.lang.M01);
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET',config.process_url + '&type=convert');
		xhr.send();
		xhr.onload = function(){
			if(xhr.status >= 200 && xhr.status < 400){
				var data;
				try{data = JSON.parse(xhr.responseText);}catch(e){data = xhr.responseText}
				if(data && data.status){
					tip(data.status,data.msg);
				}else{
					tip('error',data);
				}
			}else{
				tip('error',config.lang.E01);
			}
		};
		xhr.onerror = function(){
			tip('error',config.lang.E01);
		};
		return false;
	}
	function tip(t,s){
		if(t === 'hide'){
			cache.$tip.style.display = 'none';
			return;
		}
		if(t === 'loading'){
			cache.$area.style.display = 'none';
		}else{
			cache.$area.style.display = 'block';
		}
		cache.$tip.innerHTML = tools.status_tip(t,s);
		cache.$tip.style.display = 'block';
	}
	
});