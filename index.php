<?php get_header();?>
<div class="main-container container">
	<div class="row">
		
	</div>
	<div class="col-sm-12 col-md-9">
		<div class="main panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<i class="fa fa-leanpub"></i> 
					<?= ___('Latest posts');?>
				</h2>
			</div>
			<?php if(have_posts()){ ?>
				<ul class="archive-group list-group">
					<?php
					while(have_posts()){
						the_post();
						theme_functions::archive_content();
					}
					?>
				</ul>
				<?php
			}else{
				include __DIR__ . '/no-content.php';
			}
			?>
		</div>
	</div>
	<?php get_sidebar();?>
</div>
<?php get_footer();?>
