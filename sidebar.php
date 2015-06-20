<div class="sidebar-container col-md-3 col-sm-12">
<div class="sidebar widget-area" role="complementary">
	<?php
	/** 
	 * sidebar widget
	 */
	if(!theme_cache::dynamic_sidebar('widget-area-sidebar')){
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="page-tip">
					<?= status_tip('info', ___('Please set some widgets in sidebar.'));?>
				</div>
			</div>
		</div>
	<?php } ?>
</div><!-- /.widget-area -->
</div><!-- /#sidebar-container -->