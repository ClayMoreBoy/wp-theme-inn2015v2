<?php
/*
Feature Name:	Post Thumb Up/Down
Feature URI:	http://www.inn-studio.com
Version:		2.0.1
Description:	Agree or not? Just use the Thumb Up or Down to do it.
Author:			INN STUDIO
Author URI:		http://www.inn-studio.com
*/
add_filter('theme_includes',function($fns){
	$fns[] = 'theme_post_thumb::init';
	return $fns;
});
class theme_post_thumb{
	public static $iden = 'theme_post_thumb';
	public static $post_meta = [
		'up' => 'theme_post_thumb_up',
		'down' => 'theme_post_thumb_down',
	];
	public static function init(){
		add_filter('theme_options_save',__CLASS__ . '::options_save');
		add_filter('theme_options_default',__CLASS__ . '::options_default');	
		add_action('page_settings',__CLASS__ . '::display_backend');
		
		add_action('frontend_seajs_use',__CLASS__ . '::frontend_seajs_use');
		add_filter('frontend_seajs_alias',__CLASS__ . '::frontend_seajs_alias');
		
		add_action('backend_seajs_alias',__CLASS__ . '::backend_seajs_alias');
		add_action('after_backend_tab_init',__CLASS__ . '::backend_seajs_use');
		
		add_action('wp_ajax_' . self::$iden,__CLASS__ . '::process');
		add_action('wp_ajax_nopriv_' . self::$iden,__CLASS__ . '::process');
	}

	/**
	 * is_enabled
	 *
	 * @return bool
	 * @version 1.0.2
	 */
	public static function is_enabled(){
		return self::get_options('enabled') == 1 ? true : false;
	}
	public static function get_thumb_tx($type, $array = false){
		if($array === false)
			return stripslashes(self::get_options('text_' . $type));

		return explode("\n",stripslashes(self::get_options('text_' . $type)));
	}
	public static function get_rand_thumb_tx($type){
		$tx_arr = self::get_thumb_tx($type,true);
		$count = count($tx_arr);
		if($count === 0)
			return null;
		if($count === 1)
			return $tx_arr[0];
			
		return $tx_arr[array_rand($tx_arr,1)];
	}
	public static function display_backend(){
		?>
		<fieldset>
			<legend><?= ___('Post Thumb Up or Down Settings');?></legend>
			<p class="description"><?= ___('Agree or not? Just thumb up or down! You can set some sentences to show randomly when votes success. Multiple sentences that please use New Line to split them.');?></p>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="<?= self::$iden;?>-enabled"><?= ___('Enable or not?');?></label></th>
						<td>
							<label for="<?= self::$iden;?>-enabled">
								<input type="checkbox" name="<?= self::$iden;?>[enabled]" id="<?= self::$iden;?>-enabled" value="1"  <?= self::is_enabled() ? 'checked' : null;?> >
								<?= ___('Enable');?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="<?= self::$iden;?>-thumb-up"><?= ___('Thumb up text');?></label></th>
						<td>
							<textarea id="<?= self::$iden;?>-thumb-up" name="<?= self::$iden;?>[text_up]" class="widefat code" title="<?= ___('Thumb up text');?>" cols="30" rows="3"><?= self::get_thumb_tx('up');?></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="<?= self::$iden;?>-thumb-down"><?= ___('Thumb down text');?></label></th>
						<td>
							<textarea id="<?= self::$iden;?>-thumb-down" name="<?= self::$iden;?>[text_down]" class="widefat code" title="<?= ___('Thumb down text');?>" cols="30" rows="3"><?= self::get_thumb_tx('down');?></textarea>
						</td>
					</tr>
					<tr>
						<th><label for="<?= self::$iden;?>-restore"><?= ___('Restore post thumb option?');?></label></th>
						<td>
							<label for="<?= self::$iden;?>-restore">
								<input type="checkbox" name="<?= self::$iden;?>[restore]" id="<?= self::$iden;?>-restore">
								<?= ___('Restore post thumb option');?>
							</label>
						</td>
					</tr>
					<tr>
						<th><?= ___('Convert to new version data');?></th>
						<td>
							<div class="page-tip hide" id="<?= self::$iden;?>-tip"></div>
							<p id="<?=self::$iden;?>-btn-area">
								<a href="javascript:;" class="button" id="<?= self::$iden;?>-convert"><i class="fa fa-share"></i> <?= ___('Start convert');?></a>
							</p>
							
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		<?php
	}
	
	public static function options_default(array $opts = []){
		$opts[self::$iden]['enabled'] = 1;
		$opts[self::$iden]['text_up'] = ___("You thumbed up, I am agree it, too!\nYou are right, I think so.");
		$opts[self::$iden]['text_down'] = ___("You thumbed down, you are a honest guy!\nYou are right, I think so.");
		return $opts;
	}
	public static function options_save(array $opts = []){
		if(isset($_POST[self::$iden])){
			if(!isset($_POST[self::$iden]['restore']))
				$opts[self::$iden] = $_POST[self::$iden];
		}
		return $opts;
	}
	public static function get_options($key = null){
		static $caches = null;
		if($caches === null)
			$caches = theme_options::get_options(self::$iden);

		if($key)
			return isset($caches[$key]) ? $caches[$key] : false;

		return $caches;
	}

	public static function process(){
		theme_features::check_referer();
		$output = [];
		
		$type = isset($_REQUEST['type']) && is_string($_REQUEST['type']) ? $_REQUEST['type'] : false;

		$post_id = isset($_REQUEST['post-id']) && is_numeric($_REQUEST['post-id']) ? (int)$_REQUEST['post-id'] : false;
		
		if($type === 'up' || $type === 'down'){
			/**
			 * check post id
			 */
			if(!$post_id){
				die(theme_features::json_format([
					'status' => 'error',
					'code' => 'invaild_post_id',
					'msg' => ___('Sorry, the post ID is invaild.'),
				]));
			}
			/**
			 * check post exists
			 */
			$post = theme_cache::get_post($post_id);
			if(!$post || ($post->post_type !== 'post' && $post->post_type !== 'page')){
				die(theme_features::json_format([
					'status' => 'error',
					'code' => 'post_not_exist',
					'post-type' => $post->post_type,
					'msg' => ___('Sorry, the post does not exists.'),
				]));
			}
			/**
			 * check voted
			 */
			if(self::is_voted($post_id)){
				die(theme_features::json_format([
					'status' => 'success',
					'code' => 'voted',
					'msg' => ___('You voted the post, thank you.'),
				]));
			}
			/**
			 * set cookie
			 */
			self::set_voted($post_id);
			/**
			 * update vote
			 */
			die(theme_features::json_format([
				'status' => 'success',
				'votes' => self::update_thumb($type,$post_id),
				'msg' => self::get_rand_thumb_tx($type),
			]));
			
		}else if($type === 'convert'){
			if(!current_user_can('manage_options')){
				die(theme_features::json_format([
					'status' => 'error',
					'code' => 'invaild_permission',
					'msg' => ___('Sorry, your permission is invaild.'),
				]));
			}
			self::convert_new_version();
			die(theme_features::json_format([
				'status' => 'success',
				'msg' => ___('Data has been converted.'),
			]));
		}
		die(theme_features::json_format($output));
	}

	
	public static function display_frontend($type,$post_id,$class = null,$tx = null){
		?>
		<a href="javascript:;" class="<?= self::$iden;?>-btn <?= $type;?> <?= $class;?>" data-post-id="<?= $post_id;?>" data-thumb-type="<?= $type;?>">
			<i class="fa fa-thumbs-<?= $type === 'up' ? 'up' : 'o-down';?>"></i> 
			<span class="number"><?= self::get_thumb_count($type,$post_id);?></span> 
			<?= $tx ? '<span class="tx">' . $tx . '</span>' : null;?>
		</a>
		<?php
	}
	private static function update_thumb($type,$post_id){
		$new_count = self::get_thumb_count($type,$post_id) + 1;
		update_post_meta($post_id,self::$post_meta[$type],$new_count);

		return $new_count;
	}
	private static function convert_new_version(){
		global $post;
		$old_meta_up = 'post_thumb_count_up';
		$old_meta_down = 'post_thumb_count_down';

		set_time_limit(0);
		/**
		 * UP
		 */
		$query = new WP_Query([
			'meta_key' => $old_meta_up
		]);
		if($query->have_posts()){
			foreach($query->posts as $post){
				setup_postdata($post);
				
				$old_count = (int)get_post_meta($post->ID,$old_meta_up,true);
				
				delete_post_meta($post->ID,$old_meta_up);
				
				if($old_count != 0){
					$new_count = self::get_thumb_count('up',$post->ID) + $old_count;
					update_post_meta($post->ID,self::$post_meta['up'],$new_count);
				}
			}
			wp_reset_postdata();
		}
		/**
		 * DOWN
		 */
		$query = new WP_Query([
			'meta_key' => $old_meta_down
		]);
		if($query->have_posts()){
			foreach($query->posts as $post){
				setup_postdata($post);
				
				$old_count = (int)get_post_meta($post->ID,$old_meta_down,true);
				
				delete_post_meta($post->ID,$old_meta_down);
				
				if($old_count != 0){
					$new_count = self::get_thumb_count('down',$post->ID) + $old_count;
					update_post_meta($post->ID,self::$post_meta['down'],$new_count);
				}
			}
			wp_reset_postdata();
		}
		
		
	}
	private static function get_thumb_count($type,$post_id){
		return (int)get_post_meta($post_id,self::$post_meta[$type],true);
	}
	private static function get_voted(){
		return isset($_COOKIE[self::$iden]) ? json_decode($_COOKIE[self::$iden],true) : [];
	}
	private static function is_voted($post_id){
		$voted_ids = self::get_voted();
		if(!empty($voted_ids) && in_array($post_id,$voted_ids))	
			return true;
		return false;
	}
	private static function set_voted($post_id){
		$voted_ids = self::get_voted();
		$voted_ids[] = $post_id;
		setcookie(self::$iden,json_encode($voted_ids),time() + 86400);
	}
	public static function get_voted_class($post_id,$class = 'voted'){
		return self::is_voted($post_id) ? $class : null;
	}
	public static function frontend_seajs_alias(array $alias = []){
		if(!self::is_enabled() || !theme_cache::is_singular())
			return $alias;
			
		$alias[self::$iden] = theme_features::get_theme_includes_js(__DIR__);

		return $alias;
	}
	public static function frontend_seajs_use(){
		if(!self::is_enabled() || !theme_cache::is_singular())
			return false;
		?>
		seajs.use('<?= self::$iden;?>',function(m){
			m.config.process_url = '<?= esc_url(theme_features::get_process_url([
				'action'=>self::$iden
			]));?>';
			m.config.lang.M01 = '<?= ___('Loading, please wait...');?>';
			m.config.lang.E01 = '<?= ___('Sorry, server error please try again later.');?>';
			m.init();
		});
	<?php
	}
	public static function backend_seajs_alias(array $alias = []){
		$alias[self::$iden] = theme_features::get_theme_includes_js(__DIR__,'backend');

		return $alias;
	}
	public static function backend_seajs_use(){
		?>
		seajs.use('<?= self::$iden;?>',function(m){
			m.config.process_url = '<?= esc_url(theme_features::get_process_url([
				'action'=>self::$iden
			]));?>';
			m.config.lang.M01 = '<?= ___('Loading, please wait...');?>';
			m.config.lang.E01 = '<?= ___('Sorry, server error please try again later.');?>';
			m.init();
		});
	<?php
	}
}
?>