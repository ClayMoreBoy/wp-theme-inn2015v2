<?php get_header();?>
<div class="main-container container">
	<div class="row">
		<div class="col-sm-12 col-md-9">
			<div class="main panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<?= theme_functions::get_crumb();?>
					</div>
				</div>
				<?php if(have_posts()){ ?>
					<ul class="archive-group list-group">
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
					</ul>
					<?php if($GLOBALS['wp_query']->max_num_pages > 1){ ?>
						<div class="panel-footer">
							<?= theme_functions::pagination();?>
						</div>
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
</div><!-- .container -->
<?php get_footer();?>
