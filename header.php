<!DOCTYPE html><html <?php language_attributes(); ?>><head>
<meta charset="<?= theme_cache::get_bloginfo( 'charset' ); ?>">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta http-equiv="Cache-Control" content="no-transform"><![endif]-->
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<meta name="author" content="INN STUDIO">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?= theme_cache::get_bloginfo('pingback_url'); ?>">
<?php wp_head();?></head>
<body <?php body_class(); ?>>
<?php
/** 
 * menu menu-mobile
 */
if(wp_is_mobile()){
	theme_cache::wp_nav_menu([
		'theme_location'    => 'menu-mobile',
		'container'         => 'nav',
		'container_class'   => 'slide-menu menu-mobile',
		'menu_class'        => 'menu',
		'menu_id' 			=> 'menu-mobile',
		'fallback_cb'       => 'custom_navwalker::fallback',
		'walker'            => new custom_navwalker
	]);
}
?>
<div class="main-nav ">
	<div class="container">
		<?php if(wp_is_mobile()){ ?>
			<a href="javascript:;" class="navicon toggle fa fa-navicon fa-fw" data-mobile-target=".menu-mobile" data-icon-active="fa-arrow-left" data-icon-original="fa-navicon"></a>
		<?php } ?>
		
		<h1>
			<a href="<?= theme_cache::home_url();?>" title="<?= ___('Home page');?>">
			<?= theme_cache::get_bloginfo('name');?></a>
		</h1>
 
		<?php
		/** 
		 * menu menu-header
		 */
		if(!wp_is_mobile()){
			theme_cache::wp_nav_menu([
		        'theme_location'    => 'menu-header',
		        'container'         => 'nav',
		        'container_class'   => 'menu-header',
		        'menu_class'        => 'menu',
		        'menu_id' 			=> 'menu-header',
		        'fallback_cb'       => 'custom_navwalker::fallback',
		        'walker'            => new custom_navwalker
		   	]);
	   	}
	   	?>
		<div class="tools">
			<?php
			/** 
			 * menu menu-tools
			 */
			theme_cache::wp_nav_menu([
		        'theme_location'    => 'menu-tools',
		        'container'         => 'nav',
		        'container_class'   => 'menu-tools',
		        'menu_class'        => 'menu',
		        'menu_id' 			=> 'menu-tools',
		        'fallback_cb'       => 'custom_navwalker::fallback',
		        'walker'            => new custom_navwalker
		   	]);
			?>
			
			<a 
				class="tool search fa fa-search fa-fw" 
				href="javascript:;" 
				data-toggle-target="#fm-search" 
				data-focus-target="#fm-search-s" 
				data-icon-active="fa-arrow-down" 
				data-icon-original="fa-search" 
				title="<?= ___('Search');?>" 
			></a>
			
		</div><!-- .tools -->

	</div><!-- .container -->
	
	<div class="container">
		<form id="fm-search" action="<?= theme_cache::home_url(); ?>/" data-focus-target="#fm-search-s">
			<input id="fm-search-s" name="s" class="form-control" placeholder="<?= ___('Please input search keyword');?>" value="<?= esc_attr(get_search_query())?>" type="search" required>
        </form>		
	</div>

</div><!-- .main-nav -->
<div class="main-nav-placeholder"></div>