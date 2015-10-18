<?php
/**
 * @version 1.0.0
 */
add_filter('theme_addons',function($fns){
	$fns[] = 'theme_adbox::init';
	return $fns;
});
class theme_adbox{

	public static function init(){
		include __DIR__ . '/widget.php';
	}
}