<!DOCTYPE html><html <?php language_attributes(); ?>><head>
	<meta charset="<?= theme_cache::get_bloginfo( 'charset' ); ?>" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><meta http-equiv="Cache-Control" content="no-transform" /><![endif]-->
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="INN STUDIO" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?= theme_cache::get_bloginfo('pingback_url'); ?>" />
	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>

<div class="main-nav navbar navbar-inverse navbar-fixed-top">
	<div class="container">

		<div class="navbar-header">
			<a href="javascript:;" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".menu-header">
	            <span class="sr-only"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </a>

	        <a href="<?= theme_cache::home_url();?>" class="navbar-brand">
		        <i class="fa fa-home hidden-xs"></i> 
				<?= theme_cache::get_bloginfo('name');?>			
			</a>
		</div>
	
 
		<?php
		/** 
		 * menu menu-header
		 */
		theme_cache::wp_nav_menu([
	        'theme_location'    => 'menu-header',
	        'container'         => 'nav',
	        'container_class'   => 'menu-header navbar-collapse collapse',
	        'menu_class'        => 'menu nav navbar-nav',
	        'menu_id' 			=> 'menu-header',
	        'fallback_cb'       => 'custom_navwalker::fallback',
	        'walker'            => new custom_navwalker
	   	]);
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
		        'menu_class'        => 'menu nav navbar-nav',
		        'menu_id' 			=> 'menu-tools',
		        'fallback_cb'       => 'custom_navwalker::fallback',
		        'walker'            => new custom_navwalker
		   	]);
			?>
			<a class="tool search" href="javascript:;" data-toggle="collapse" data-target=".navbar-collapse-form">
				<i class="fa fa-search fa-fw"></i>
			</a>
		</div><!-- .tools -->

	</div><!-- .container -->
	<div class="container">
		<form class="navbar-form navbar-collapse-form collapse" role="search" action="<?= theme_cache::home_url('/'); ?>" method="get">
			<input name="s" class="form-control" placeholder="<?= ___('Please input search keyword');?>" value="<?= esc_attr(get_search_query())?>" type="search">
        </form>		

	</div>

</div><!-- .main-nav -->