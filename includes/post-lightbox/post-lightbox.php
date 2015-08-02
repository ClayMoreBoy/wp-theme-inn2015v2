<?php
/**
 * @version 1.0.0
 */
add_filter('theme_includes',function($fns){
	$fns[] = 'theme_post_lightbox::init';
	return $fns;
});
class theme_post_lightbox{
	public static $iden = 'theme_post_lightbox';

	public static function init(){
		//add_action( 'wp_enqueue_scripts', __CLASS__  . '::frontend_enqueue_css' );
		add_action('frontend_seajs_use',	__CLASS__ . '::frontend_seajs_use');
		add_filter('frontend_seajs_alias',	__CLASS__ . '::frontend_seajs_alias');
	}
	//public static function frontend_enqueue_css(){
	//	wp_enqueue_style(
	//		self::$iden,
	//		theme_features::get_theme_includes_css(__DIR__),
	//		'frontend',
	//		theme_file_timestamp::get_timestamp()
	//	);
	//}
	public static function frontend_seajs_alias(array $alias = []){
		if(theme_cache::is_singular()){
			$alias['lightbox'] = theme_features::get_theme_includes_js(__DIR__,'lightbox');
			$alias[self::$iden] = theme_features::get_theme_includes_js(__DIR__);
		}
		return $alias;
	}
	public static function frontend_seajs_use(){
		if(!theme_cache::is_singular())
			return false;
			?>
		seajs.use('<?= self::$iden;?>',function(m){
			m.init();
		});
		<?php
	}
}