<?php get_header();?>
<div class="main-container container">
	<div class="row">
		<div class="col-sm-12 col-md-9">
			<?php theme_functions::singular_content();?>
			<?php theme_functions::the_related_posts_plus();?>
			<?php comments_template();?>
		</div>
		<?php include __DIR__ . '/sidebar.php';?>
	</div><!-- .row -->
</div><!-- .container -->
<?php get_footer();?>
