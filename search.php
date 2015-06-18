<?php get_header();?>
<div class="container">
	<?= theme_functions::get_crumb();?>
	<div class="row">
		<div id="main" class="col-md-9 col-sm-12">
			<div class="panel panel-default mx-panel">
				<div class="panel-heading">
					<h3 class="panel-title">
						<a href="<?= esc_url(get_search_link(get_search_query()));?>">
							<i class="fa fa-search"></i> 
							<?= esc_html(get_search_query());?>
						</a>
					</h3>
				</div>
				<div class="panel-body">
					<?php
					if(have_posts()){
						?>
						<ul class="row mx-card-body post-img-lists">
							<?php
							$loop_i = 0;
							foreach($wp_query->posts as $post){
								setup_postdata($post);
								theme_functions::archive_img_content(array(
									'classes' => array('col-lg-3 col-md-4 col-xs-6'),
									'lazyload' => $loop_i <= 8 ? false : true,
								));
								++$loop_i;
							}
							?>
						</ul>
					<?php }else{ ?>
						<?= status_tip('info',___('No content yet.'));?>
					<?php } ?>
				</div>
				<div class="panel-footer area-pagination">
					<?php theme_functions::pagination();?>
				</div>
			</div>
		</div><!-- /#main -->
		<?php get_sidebar() ;?>
	</div><!-- /.row -->
</div><!-- /.container -->
<?php get_footer();?>