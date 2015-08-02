<?php get_header();?>
<div class="main-container container">
	<div class="row">
		<div class="col-sm-12 col-md-9">
			<?php 
			if(have_posts()){
				while(have_posts()){
					the_post();
					theme_functions::page_content();
					comments_template();
				}
			}
			?>
		</div>
		<?php include __DIR__ . '/sidebar.php';?>
	</div><!-- .row -->
</div><!-- .container -->
<?php get_footer();?>
