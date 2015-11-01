<?php get_header();?>
<div class="main-container g">
	<div class="row">
		<div class="g-desktop-3-4">
			<?php if(have_posts()){
				while(have_posts()){
					the_post();
					?>
					<?php theme_functions::singular_content();?>
					<?php theme_functions::the_related_posts();?>
					<?php comments_template();?>
					<?php
				}
			}
			?>
		</div>
		<?php include __DIR__ . '/sidebar.php';?>
	</div><!-- .row -->
</div><!-- .g -->
<?php get_footer();?>
