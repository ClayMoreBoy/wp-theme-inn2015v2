<!DOCTYPE html><html <?php language_attributes(); ?>><head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
	<!-- <meta http-equiv="Cache-Control" content="no-transform" /> -->
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width" />
	<meta name="author" content="INN STUDIO" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>

<div class="main-header">
	<div class="main-nav navbar navbar-inverse navbar-fixed-top">
		<div class="container">

			<div class="navbar-header">
				<a href="javascript:;" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".menu-mobile">
		            <span class="sr-only"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		        </a>

		        <a href="<?= home_url();?>" class="navbar-brand">
			        <i class="fa fa-home hidden-xs"></i> 
					<?= get_bloginfo('name');?>			
				</a>
			</div>
		
	 
			<?php
			/** 
			 * menu menu-header
			 */
			theme_cache::wp_nav_menu([
		        'theme_location'    => 'menu-header',
		        'container'         => 'nav navbar-left navbar-collapse collapse',
		        'container_class'   => 'menu-header',
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
			        'container'         => 'nav navbar-collapse collapse',
			        'container_class'   => 'menu-tools',
			        'menu_class'        => 'menu nav navbar-nav',
			        'menu_id' 			=> 'menu-tools',
			        'fallback_cb'       => 'custom_navwalker::fallback',
			        'walker'            => new custom_navwalker
			   	]);
				?>
				<a class="tool search" href="javascript:;" data-target=".navbar-collapse-form">
					<i class="fa fa-search fa-fw"></i>
				</a>
			</div><!-- .tools -->
		</div><!-- .container -->

	</div><!-- .main-nav -->

	<?php if(is_singular()){ ?>
		<div class="container">
			<h2 class="sub-title">
				<?php the_title();?>
			</h2>			
		</div><!-- .container -->
	<?php } ?>
	
</div><!-- .main-header -->