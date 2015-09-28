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
			exports.search();
			exports.posts_nav();
			exports.scroll_menu();
			exports.mobile_menu();
			exports.toggle_menu();
		});
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
				$menu.classList.remove('top')
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
				$menu.classList.add('top');
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
	exports.toggle_menu = function(){
		var $toggles = document.querySelectorAll('a[data-toggle-target]');
		if(!$toggles[0])
			return;
		function Q(e){
			return document.querySelector(e);
		}
	
		var $last_click_btn,
			$last_target;

		function show_menu(){
			var icon_active = $last_click_btn.getAttribute('data-icon-active'),
				icon_original =$last_click_btn.getAttribute('data-icon-original');
			$last_target.classList.add('on');
			if(icon_active && icon_original){
				$last_click_btn.classList.remove(icon_original);
				$last_click_btn.classList.add(icon_active);
			}
			var focus_target = $last_click_btn.getAttribute('data-focus-target');
			if(focus_target){
				var $focus_target = Q(focus_target);
				if($focus_target){
					$focus_target.focus();
				}
			}
		}
		function hide_menu(e){
			if(e)
				e.preventDefault();
			var icon_active = $last_click_btn.getAttribute('data-icon-active'),
				icon_original = $last_click_btn.getAttribute('data-icon-original');
				
			$last_target.classList.remove('on');
			if(icon_active && icon_original){
				$last_click_btn.classList.remove(icon_active);
				$last_click_btn.classList.add(icon_original);
			}
		}
		function helper(e){
			if(e)
				e.preventDefault();
			$last_target = Q(this.getAttribute('data-toggle-target'));
			$last_click_btn = this;
			/** hide */
			if($last_target.classList.contains('on')){
				hide_menu();
			}else{
				show_menu();
			}
		}
		for( var i = 0, len = $toggles.length; i < len; i++){
			$toggles[i].addEventListener(tools.click_handler,helper);
		}
	}
	exports.mobile_menu = function(){
		var $toggles = document.querySelectorAll('a[data-mobile-target]');
		if(!$toggles[0])
			return;
		function Q(e){
			return document.querySelector(e);
		}
		/** create layer */
		var $layer = document.createElement('div');
		$layer.id = 'mobile-on-layer';
		
		/** bind layer */
		$layer.addEventListener(tools.click_handler,hide_menu);
		
		/** insert to body */
		document.body.appendChild($layer);
		
		var $last_click_btn,
			$last_target;

		function show_menu(){
			var icon_active = $last_click_btn.getAttribute('data-icon-active'),
				icon_original =$last_click_btn.getAttribute('data-icon-original');
			document.body.classList.add('menu-on');
			$last_target.classList.add('on');
			if(icon_active && icon_original){
				$last_click_btn.classList.remove(icon_original);
				$last_click_btn.classList.add(icon_active);
			}
			var focus_target = $last_click_btn.getAttribute('data-focus-target');
			if(focus_target){
				var $focus_target = Q(focus_target);
				if($focus_target){
					$focus_target.focus();
				}
			}
		}
		function hide_menu(){
			var icon_active = $last_click_btn.getAttribute('data-icon-active'),
				icon_original = $last_click_btn.getAttribute('data-icon-original');
				
			document.body.classList.remove('menu-on');
			$last_target.classList.remove('on');
			if(icon_active && icon_original){
				$last_click_btn.classList.remove(icon_active);
				$last_click_btn.classList.add(icon_original);
			}
		}
		function helper(e){
			if(e)
				e.preventDefault();
			$last_target = Q(this.getAttribute('data-mobile-target'));
			$last_click_btn = this;
			/** hide */
			if($last_target.classList.contains('on')){
				hide_menu();
			}else{
				show_menu();
			}
		}
		for( var i = 0, len = $toggles.length; i < len; i++){
			$toggles[i].addEventListener(tools.click_handler,helper);
		}
	}
	exports.posts_nav = function(){
		var $pns = document.querySelectorAll('.posts-nav');
		if(!$pns[0])
			return;
		function helper(e){
			if(this.value)
				location.href = this.value;
		}
		for(var i=0,len=$pns.length; i<len; i++){
			$pns[i].querySelector('select').addEventListener('change',helper);
		}
	}

	exports.search = function(){
		var Q = function(s){
				return document.querySelector(s);
			},
			$btn = Q('.main-nav a.search');
			
		if(!$btn)
			return false;
			
		var $fm = Q($btn.getAttribute('data-toggle-target')),
			$input = $fm.querySelector('input[type="search"]'),
			submit_helper = function(){
				if($input.value.trim() === '')
					return false;
			};
		function st(e){
			if(e)
				e.preventDefault();
			setTimeout(function(){
				$input.focus();
			},100);
		}
		$btn.addEventListener(tools.click_handler,st);

		$fm.onsubmit = submit_helper;
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