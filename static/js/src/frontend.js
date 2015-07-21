define(function(require, exports, module){
	'use strict';

	require.async(['modules/lazyload','modules/bootstrap-without-jq'],function(_a,_b){});
	
	var tools = require('modules/tools');
	
	
	exports.config = {
		is_home : false
	
	};
	exports.init = function(){
		tools.ready(function(){
			exports.hide_no_js();
			exports.scroll_menu();
			//exports.search();
			exports.menu();
		});
	};
	exports.menu = function(){
		var $toggles = document.querySelectorAll('a[data-target]');
		if(!$toggles)
			return;
		function Q(e){
			return document.querySelector(e);
		}
		function helper(e){
			var $target = Q(this.getAttribute('data-target')),
				icon_active = this.getAttribute('data-icon-active'),
				icon_original = this.getAttribute('data-icon-original');
			/** hide */
			if($target.classList.contains('on')){
				$target.classList.remove('on');
				if(icon_active && icon_original){
					this.classList.remove(icon_active);
					this.classList.add(icon_original);
				}
			}else{
				/** show */
				$target.classList.add('on');
				if(icon_active && icon_original){
					this.classList.remove(icon_original);
					this.classList.add(icon_active);
				}
				var focus_target = this.getAttribute('data-focus-target');
				if(focus_target){
					var $focus_target = Q(focus_target);
					if($focus_target){
						$focus_target.focus();
					}
					
				}
			}
			
		}
		for( var i = 0, len = $toggles.length; i < len; i++){
			$toggles[i].addEventListener('click',helper);
		}
	}
	exports.search = function(){
		var Q = function(s){
				return document.querySelector(s);
			},
			$btn = Q('.main-nav a.search');
			
		if(!$btn)
			return false;
			
		var $fm = Q($btn.getAttribute('data-target')),
			$input = $fm.querySelector('input[type="search"]'),
			submit_helper = function(){
				if($input.value.trim() === '')
					return false;
			};
			
		$btn.addEventListener('click',function(){
			setTimeout(function(){
				$input.focus();
			},100);
		},false);

		$fm.onsubmit = submit_helper;
	}
	exports.scroll_menu = function(){
		var $menu = document.querySelector('.main-nav'),
			y = 0,
			fold = false,
			st = false,
			uping = false;
		if(!$menu)
			return false;

		function hide(){
			if( !fold ){
				$menu.classList.add('fold');
				fold = true;
			}
		}
		function show(){
			if( fold ){
				$menu.classList.remove('fold');
				fold = false;
			}
		}
		function dely_clearst(){
			clearTimeout(st);
		}
		function delay_show(){
			if(uping){
				show();
			}else{
				if(uping)
					clearTimeout(st);
					
				st = setTimeout(function(){
					if(!uping){
						uping = true;
					}
				},500);
			}
			
			
		}
		window.addEventListener('scroll', function () {
			
			if(this.pageYOffset === 0){
				show();
			/**
			 * scroll down
			 */
			}else if( y <= this.pageYOffset ){
				hide();
				if(uping)
					uping = false;
			/**
			 * scroll up
			 */
			}else{
				delay_show();
			}
			y = this.pageYOffset;
			
		}, false);
	}
	exports.hide_no_js = function(){
		var A = function(e){
				return document.querySelectorAll(e);
			},
			$no_js = A('.hide-no-js'),
			$on_js = A('.hide-on-js');
		if($no_js[0]){
			Array.prototype.forEach.call($no_js, function(el){
				el.style.display = 'none';
			});
		}
		if($on_js[0]){
			Array.prototype.forEach.call($on_js, function(el){
				el.style.display = 'block';
			});
		}
	};
});