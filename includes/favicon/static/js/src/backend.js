define(function(require, exports, module){
	'use strict';
	var tools = require('modules/tools');
	require('modules/jquery.filedrop');
	exports.init = function(){
		tools.ready(exports.bind);
	}
	
	exports.config = {
		prefix_id : '#theme_custom_favicon',
		url_id : 'url',
		upload_btn_id : 'upload',
		file_btn_id : 'file',
		attach_id : 'attach-id',
		process_url : '',
		lang : {
			M00001 : 'Loading, please wait...',
			E00001 : 'Server error or network is disconnected.'
		}
	}
	exports.cache = {}
	
	exports.bind = function(){
		exports.cache.$url = jQuery(exports.config.prefix_id + '-' + exports.config.url_id);
		exports.cache.$upload = jQuery(exports.config.prefix_id + '-' + exports.config.upload_btn_id);
		exports.cache.$file = jQuery(exports.config.prefix_id + '-' + exports.config.file_btn_id);
		exports.cache.$attach_id = jQuery(exports.config.prefix_id + '-' + exports.config.attach_id);
		/** 
		 * bind upload event
		 */
		var upload = new exports.file();
		upload.init();
		
	}
	exports.file = function(){		
		this.init = function(){
			var $upload = exports.cache.$upload,
				$area = jQuery(exports.config.prefix_id + '-area'),
				$tip = jQuery(exports.config.prefix_id + '-tip');
			exports.cache.$file.filedrop({
				fallback_id : exports.cache.$file[0].id,
				url : exports.config.process_url,
				paramname : 'img',
				uploadStarted : function(i, file, len){
					$area.hide();
					$tip.html(tools.status_tip('loading',exports.config.lang.M00001)).show();
				},
				uploadFinished: function(i, file, data, time) {
					if(data && data.status === 'success'){
						exports.cache.$url.val(data.url);
						exports.cache.$attach_id.val(data.attach_id);
						$tip.html(tools.status_tip('success',data.msg));
					}else if(data && data.status === 'error'){
						$tip.html(tools.status_tip('error',data.msg));
					}else{
						$tip.html(tools.status_tip('error',data.msg));
					}
					$area.show();
					exports.cache.$file.val('');
				},
				error: function(err, file, i){
					$tip.html(tools.status_tip('error',err));
					$area.show();
					exports.cache.$file.val('');
				}
			});
		}
	}	
});