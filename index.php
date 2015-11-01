<?php get_header();?>
<div class="main-container g">
	<div class="row">
		<div class="g-desktop-3-4">
			<div class="panel">
				<div class="heading">
					<h2 class="title">
						<i class="fa fa-leanpub"></i> 
						<?= ___('Latest posts');?>
					</h2>
				</div>
				<?php if(have_posts()){ ?>
					<div class="row main-card-group">
						<?php
						$i = 0;
						foreach($wp_query->posts as $post){
							setup_postdata($post);
							theme_functions::archive_content([
								'lazyload' => $i <= 6 ? false : true,
							]);
							++$i;
						}
						?>
					</div>
					<?php if($wp_query->max_num_pages > 1){ ?>
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
</div><!-- .container -->
<?php get_footer();?>