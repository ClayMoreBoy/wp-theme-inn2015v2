<?php
/**
 * @version 1.0.0
 */
add_filter('theme_includes',function($fns){
	$fns[] = 'theme_post_toc::init';
	return $fns;
});
class theme_post_toc{

	public static $iden = 'theme_post_toc';

	public static function init(){

		add_action('frontend_seajs_use',	__CLASS__ . '::frontend_seajs_use');
		add_filter('frontend_seajs_alias',	__CLASS__ . '::frontend_seajs_alias');
	}
	public static function is_enabled(){
		return true;
	}
	private static function is_singular(){
		static $cache = null;
		if($cache === null)
			$cache = is_singular();

		return $cache;
	}
	public static function frontend_seajs_alias(array $alias = []){
		if(self::is_enabled() && self::is_singular()){
			$alias[self::$iden] = theme_features::get_theme_includes_js(__DIR__);
		}
		return $alias;
	}
	public static function frontend_seajs_use(){
		if(!self::is_enabled() || !self::is_singular())
			return false;
			?>
		seajs.use('<?= self::$iden;?>',function(m){
			m.config.lang.M01 = '<?= ___('Table of content');?>';
			m.config.lang.M02 = '<?= ___('[TOC]');?>';
			m.init();
		});
		<?php
	}
	
}