<?php
/**
 * @version
 */
add_filter('theme_includes',function($fns){
	$fns[] = 'theme_custom_colorful::init';
	return $fns;
});
class theme_custom_colorful{

	public static $iden = 'theme_custom_colorful';
	public static function init(){

		add_action('page_settings', __CLASS__ . '::display_backend');
		add_filter('theme_options_save', __CLASS__ . '::options_save');
		add_filter('theme_options_default', __CLASS__ . '::options_default');

		//add_action('customize_register', __CLASS__ . '::customize');
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::frontend_css' );
		
		if(!theme_options::is_options_page())
			return false;
			
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::backend_css' );
	}
	public static function get_schemes($key = null){
		static $caches = null;
		if($caches === null){
			$caches = [
				[
					'id' => 'default',
					'text' => ___('Default'),
					'colors' => ['#455A64','#607D8B','#00BCD4'],
				],[
					'id' => 'sunrise',
					'text' => ___('Sun rise'),
					'colors' => ['#b43c38','#cf4944','#ccaf0b'],
				],[
					'id' => 'coffee',
					'text' => ___('Coffee'),
					'colors' => ['#46403c','#59524c','#c7a589'],
				],[
					'id' => 'palette',
					'text' => ___('Palette'),
					'colors' => ['#413256','#523f6d','#a3b745'],
				]
			];
		}
		if($key !== null)
			return isset($caches[$key]) ? $caches[$key] : false;
		return $caches;
	}
	public static function is_random(){
		return self::get_options('scheme') === 'random';
	}
	public static function get_and_set_random_scheme(){
		$cookie_id = self::$iden . current_time('d');
		$rand = isset($_COOKIE[$cookie_id]) ? (int)$_COOKIE[$cookie_id] : false;
		if($rand === false || $rand < 0 || $rand > count(self::get_schemes())){
			$rand = rand(0,$len - 1);
			setcookie($cookie_id,$rand,3600*24);
		}
		return $rand;
	}

	public static function get_options($key = null){
		static $caches = null;
		if($caches === null)
			$caches = theme_options::get_options(self::$iden);
		if($key)
			return isset($caches[$key]) ? $caches[$key] : false;
		return $caches;
	}
	public static function options_save(array $opts = []){
		if(isset($_POST[self::$iden])){
			$opts[self::$iden] = $_POST[self::$iden];
		}
		return $opts;
	}
	public static function options_default(array $opts = []){
		$opts[self::$iden]['scheme'] = 'blue-grey';
		return $opts;
	}
	public static function display_backend(){
		?>
		<fieldset>
			<legend><?= ___('Theme colorful settings');?></legend>
			<p class="description"><?= ___('The theme has some color schemes, you can choose a color scheme you like. Also ,you can try to choose random scheme.')?></p>
			<table class="form-table">
				<tbody>
				<tr>
					<th><?= ___('Schemes');?></th>
					<td>
						<div id="<?= self::$iden;?>">
							<?php foreach(self::get_schemes() as $scheme){
								$checked = self::get_options('scheme') === $scheme['id'] ? 'checked' : null;
								?>
								<div class="<?= self::$iden;?>-item">
									<input type="radio" name="<?= self::$iden;?>[scheme]" id="<?= self::$iden,'-',$scheme['id'];?>" value="<?= $scheme['id'];?>" <?= $checked;?>>
									<label for="<?= self::$iden,'-',$scheme['id'];?>">
										<?php foreach($scheme['colors'] as $color){ 
											?><i style="background-color: <?= $color;?>"></i><?php 
										} ?>
										<span><?= $scheme['text'];?></span>
									</label>
								</div>
							<?php } ?>
							<div class="<?= self::$iden;?>-item">
								<input type="radio" name="<?= self::$iden;?>[scheme]" id="<?= self::$iden;?>-random" value="random" <?= self::get_options('scheme') === 'random' ? 'checked' : null;?>>
								<label for="<?= self::$iden;?>-random">
									<?php foreach(self::get_schemes(1)['colors'] as $color){ 
										?><i></i><?php 
									} ?>
									<span><?= ___('Random daily');?></span>
								</label>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php
	}
	public static function frontend_css(){
		if(self::is_random()){
			$rand = self::get_and_set_random_scheme();
			$scheme = self::get_schemes($rand)['id'];
		}else{
			$scheme = self::get_options('scheme');
		}
		wp_register_style( 
			self::$iden . '-frontend',
			theme_features::get_theme_includes_css(__DIR__,'scheme-' . $scheme),
			['frontend'],
			theme_file_timestamp::get_timestamp()
		);
		wp_enqueue_style(self::$iden . '-frontend');
	}
	public static function backend_css(){
		wp_register_style( 
			self::$iden . '-backend',
			theme_features::get_theme_includes_css(__DIR__,'backend'),
			false,
			theme_file_timestamp::get_timestamp()
		);
		wp_enqueue_style(self::$iden . '-backend');
	}
}