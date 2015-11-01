<?php get_header();?>
<div class="main-container g">
	<div class="row">
		<div class="g-desktop-3-4">
			<div class="main panel">
				<div class="heading">
					<div class="title">
						<?= theme_functions::get_crumb();?>
					</div>
				</div>
				<?php if(have_posts()){ ?>
					<div class="row main-card-group">
						<?php
						$i = 0;
						while(have_posts()){
							the_post();
							theme_functions::archive_content([
								'lazyload' => $i <= 6 ? false : true,
							]);
							++$i;
						}
						?>
					</div>
					<?php if($GLOBALS['wp_query']->max_num_pages > 1){ ?>
						<?= theme_functions::pagination();?>
					<?php } ?>
					<?php
				}else{
					theme_functions::no_post();
				}
				?>
			</div>
		</div>
		<?php include __DIR__ . '/sidebar.php';?>
	</div><!-- .row -->
</div><!-- .g -->
<?php get_footer();?>
