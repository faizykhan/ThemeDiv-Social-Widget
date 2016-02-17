<?php
/*
 * Plugin Name: ThemeDiv Facebook Like Box 
 * Version: 1.0
 * Description: Facebook Like Box Widget And Shortcode
 * Author: Faizan Khan
 * Author URI: http://faizankhan.com/
 */

if (!defined('ABSPATH')) {
	exit();
}

function register_fb_like_script(){
	wp_enqueue_script('main-js',plugins_url().'/themediv-facebook-like-box/js/main.js');
	wp_enqueue_script('google-js','https://apis.google.com/js/platform.js');
}

add_action('wp_enqueue_scripts','register_fb_like_script');


add_action( 'plugins_loaded', 'google_plus_badge_widget_load_textdomain' );
function google_plus_badge_widget_load_textdomain() {
  load_plugin_textdomain( 'google-plus-badge-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/*
* Main Widget Start Here
*/
class WP_register_widget_social extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct(
			'wp_theme_widget_social_links',
			__('Facebook Like Box Widget','wp_theme_widget_social_links'),
			array(
				'classname'		=>	'wp_theme_widget_social_links',
				'description'	=>	__('Input Your Social Links Widgets','wp_theme_widget_social_links'),
			)
		);
	}

	public function form($instance)
	{
		$title 	         = esc_attr($instance['title']);
		$facebook_url    = esc_attr($instance['facebook_url']);
		$show_timeline	 = esc_attr($instance['show_timeline']);
		$show_events	 = esc_attr($instance['show_events']);
		$show_messages	 = esc_attr($instance['show_messages']);
		$facebook_width	 = esc_attr($instance['facebook_width']);
		$facebook_height = esc_attr($instance['facebook_height']);
		$facebook_facepile = esc_attr($instance['facebook_facepile']);
		$facebook_hide_cover = esc_attr($instance['facebook_hide_cover']);
		$facebook_small_header = esc_attr($instance['facebook_small_header']);
		?>
		<!--Title-->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>">
		</p>

		<!--Facebook URL-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_url'); ?>"><?php esc_html_e('Facebook URL:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('facebook_url'); ?>" id="<?php echo $this->get_field_id('facebook_url'); ?>" value="<?php echo esc_attr($facebook_url); ?>">
		</p>

		<!--Facebook Timeline-->
		<p>
			<label for="<?php echo $this->get_field_id('show_timeline'); ?>"><?php esc_html_e('Show Data Tabs:'); ?></label>
		</p>
		<p>
			Timeline: <input type="checkbox" <?php checked( $instance[ 'show_timeline' ], 'on' ); ?> name="<?php echo $this->get_field_name('show_timeline'); ?>">
			Events: <input type="checkbox" <?php checked( $instance[ 'show_events' ], 'on' ); ?> name="<?php echo $this->get_field_name('show_events'); ?>">
			Messages: <input type="checkbox" <?php checked( $instance[ 'show_messages' ], 'on' ); ?> name="<?php echo $this->get_field_name('show_messages'); ?>">
		</p>

		<!--Facebook Like Box Width-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_width'); ?>"><?php esc_html_e('Like Box Width:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('facebook_width'); ?>" id="<?php echo $this->get_field_id('facebook_width'); ?>" placeholder="Enter Width in px" value="<?php echo esc_attr($facebook_width); ?>">
		</p>

		<!--Facebook Like Box Height-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_height'); ?>"><?php esc_html_e('Like Box Height:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('facebook_height'); ?>" id="<?php echo $this->get_field_id('facebook_height'); ?>" placeholder="Enter Height in px" value="<?php echo esc_attr($facebook_height); ?>">
		</p>

		<!--Show profile photos when friends like this-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_facepile'); ?>"><?php esc_html_e('Show profile photos when friends like:'); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance[ 'facebook_facepile' ], 'on' ); ?> name="<?php echo $this->get_field_name('facebook_facepile'); ?>" >
		</p>

		<!--Hide cover photo in the header-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_hide_cover'); ?>"><?php esc_html_e('Hide cover photo in the header:'); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance[ 'facebook_hide_cover' ], 'on' ); ?> name="<?php echo $this->get_field_name('facebook_hide_cover'); ?>" >
		</p>

		<!--Use the small header instead-->
		<p>
			<label for="<?php echo $this->get_field_id('facebook_small_header'); ?>"><?php esc_html_e('Show Small Header'); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance[ 'facebook_small_header' ], 'on' ); ?> name="<?php echo $this->get_field_name('facebook_small_header'); ?>" >
		</p>

		<?php
	}

	public function widget($args,$instance)
	{
		$title 			 = esc_attr($instance['title']);
		$facebook_url    = esc_attr($instance['facebook_url']);
		$show_timeline   = esc_attr($instance[ 'show_timeline' ] ? 'timeline' : 'false');
		$show_events   	 = esc_attr($instance[ 'show_events' ] ? 'events' : 'false');
		$show_messages   = esc_attr($instance[ 'show_messages' ] ? 'messages' : 'false');
		$facebook_width	 = esc_attr($instance['facebook_width']);
		$facebook_height = esc_attr($instance['facebook_height']);
		$facebook_facepile = esc_attr($instance['facebook_facepile'] ? 'true' : 'false');
		$facebook_hide_cover = esc_attr($instance['facebook_hide_cover'] ? 'true' : 'false');
		$facebook_small_header = esc_attr($instance['facebook_small_header'] ? 'true' : 'false');

		echo $args['before_widget'].$args['before_title'].$title.$args['after_title'];

		?>
		<div 
			class="fb-page" 
			data-href="<?php echo esc_html($facebook_url); ?>" 
			data-tabs="<?php echo $show_timeline; ?>,<?php echo $show_events; ?>,<?php echo $show_messages; ?>"
			data-small-header="<?php echo $facebook_small_header; ?>" 
			data-adapt-container-width="true" 
			data-hide-cover="<?php echo $facebook_hide_cover; ?>"
			data-width="<?php echo $facebook_width; ?>" 
			data-height="<?php echo $facebook_height; ?>"
			data-show-facepile="<?php echo $facebook_facepile; ?>"
		>
		<div class="fb-xfbml-parse-ignore">
			<blockquote cite="<?php echo esc_html($facebook_url); ?>">
				<a href="<?php echo esc_html($facebook_url); ?>">Facebook</a>
			</blockquote>
		</div>
		</div>
		<?php

		echo $args['after_widget'];
	}

	public function update($new_instance,$old_instance)
	{
		$instance = $old_instance;

		$instance['title']			=	esc_attr($new_instance['title']);
		$instance['facebook_url'] 	= 	esc_attr($new_instance['facebook_url']);
		$instance['show_timeline']	=	esc_attr($new_instance['show_timeline']);
		$instance['show_events']	=	esc_attr($new_instance['show_events']);
		$instance['show_messages']	=	esc_attr($new_instance['show_messages']);
		$instance['facebook_width'] =	esc_attr($new_instance['facebook_width']);
		$instance['facebook_height'] =	esc_attr($new_instance['facebook_height']);
		$instance['facebook_facepile']	=	esc_attr($new_instance['facebook_facepile']);
		$instance['facebook_hide_cover'] = esc_attr($new_instance['facebook_hide_cover']);
		$instance['facebook_small_header'] = esc_attr($new_instance['facebook_small_header']);

		return $instance;
	}
}


/**
* 
*/
class themedivregister_theme_google_plus extends WP_Widget
{
	
	function __construct()
	{
		parent::__construct(
			'themediv_register_widget_google_plus',
			__('Google Plus Profile Widget','themediv_register_widget_google_plus'),
			array(
				'classname'		=>	'themediv_register_widget_google_plus',
				'description'	=>	__('Google Plus Profile Widget','themediv_register_widget_google_plus')
			)
		);
	}

	public function form($instance)
	{
		$title = esc_attr($instance['title']);
		$google_page_url = esc_attr($instance['google_page_url']);
		$google_plus_width = esc_attr($instance['google_plus_width']);
		$google_plus_layout = esc_attr($instance['google_plus_layout']);
		$google_color_scheme = esc_attr($instance['google_color_scheme']);
		$google_showcoverphoto = esc_attr($instance['google_showcoverphoto']);
		$google_showtagline = esc_attr($instance['google_showtagline']);

		?>
		<!--Google Plus Title-->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>"> 
		</p>

		<!--Google Plus Page URL-->
		<p>
			<label for="<?php echo $this->get_field_id('google_page_url'); ?>"><?php _e('Google+ Page URL:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('google_page_url'); ?>" id="<?php echo $this->get_field_id('google_page_url'); ?>" value="<?php echo esc_attr($google_page_url); ?>"> 
		</p>

		<!--Google Plus width-->
		<p>
			<label for="<?php echo $this->get_field_id('google_plus_width'); ?>"><?php _e('Width:'); ?></label>
		</p>
		<p>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('google_plus_width'); ?>" id="<?php echo $this->get_field_id('google_plus_width'); ?>" value="<?php echo esc_attr($google_plus_width); ?>"> 
		</p>

		<!--Google Plus Layout-->
		<p>
			<label for="<?php echo $this->get_field_id('google_plus_layout'); ?>"><?php _e('Google+ Layout:'); ?></label>
		</p>
		<p>
			<select name="<?php echo $this->get_field_name('google_plus_layout'); ?>" id="<?php echo $this->get_field_id('google_plus_layout'); ?>" style="width:100%;">
				<option <?php  if('portrait' == $instance['google_plus_layout']) echo 'selected="selected"'; ?> value="portrait">Portrait</option>
				<option <?php  if('landscape' == $instance['google_plus_layout']) echo 'selected="selected"'; ?> value="landscape">Landscape</option>
			</select>
		</p>

		<!--Google Plus Color Scheme-->
		<p>
			<label for="<?php echo $this->get_field_id('google_color_scheme'); ?>"><?php _e('Google+ Layout:'); ?></label>
		</p>
		<p>
			<select name="<?php echo $this->get_field_name('google_color_scheme'); ?>" id="<?php echo $this->get_field_id('google_color_scheme'); ?>" style="width:100%;">
				<option <?php  if('light' == $instance['google_color_scheme']) echo 'selected="selected"'; ?> value="light">Light</option>
				<option <?php  if('dark' == $instance['google_color_scheme']) echo 'selected="selected"'; ?> value="dark">Dark</option>
			</select>
		</p>

		<!--Google Plus Show Cover Photo-->
		<p>
			<label for="<?php echo $this->get_field_id('google_showcoverphoto'); ?>"><?php esc_html_e('Show Cover Photo:'); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance[ 'google_showcoverphoto' ], 'on' ); ?> name="<?php echo $this->get_field_name('google_showcoverphoto'); ?>" >
		</p>

		<!--Google Plus Show Tagline-->
		<p>
			<label for="<?php echo $this->get_field_id('google_showtagline'); ?>"><?php esc_html_e('Show Tagline:'); ?></label>
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance[ 'google_showtagline' ], 'on' ); ?> name="<?php echo $this->get_field_name('google_showtagline'); ?>" >
		</p>
		<?php
	}

	public function widget($args,$instance)
	{
		$title = esc_attr($instance['title']);
		$google_page_url = esc_attr($instance['google_page_url']);
		$google_plus_width = esc_attr($instance['google_plus_width']);
		$google_plus_layout = esc_attr($instance['google_plus_layout']);
		$google_color_scheme = esc_attr($instance['google_color_scheme']);
		$google_showcoverphoto = esc_attr($instance['google_showcoverphoto'] ? 'true' : 'false');
		$google_showtagline= esc_attr($instance['google_showtagline'] ? 'true' : 'false');
		echo $args['before_widget'].$args['before_title'].$title.$args['after_title'];
		?>

		<div 
			class="g-person" 
			data-width="<?php echo $google_plus_width; ?>" 
			data-layout="<?php echo $google_plus_layout; ?>"
			data-showcoverphoto="<?php echo $google_showcoverphoto; ?>" 
			data-showtagline="<?php echo $google_showtagline; ?>" 
			data-theme="<?php echo $google_color_scheme; ?>" 
			data-href="<?php echo $google_page_url; ?>" 
			data-rel="author">
		</div>

		<?php
		echo $args['after_widget'];
	}

	public function update($new_instance,$old_instance)
	{
		$instance = $old_instance;
		$instance['title']	=	esc_attr($new_instance['title']);
		$instance['google_page_url'] = esc_attr($new_instance['google_page_url']);
		$instance['google_plus_width'] = esc_attr($new_instance['google_plus_width']);
		$instance['google_plus_layout'] = esc_attr($new_instance['google_plus_layout']);
		$instance['google_color_scheme'] = esc_attr($new_instance['google_color_scheme']);
		$instance['google_showcoverphoto'] = esc_attr($new_instance['google_showcoverphoto']);
		$instance['google_showtagline'] = esc_attr($new_instance['google_showtagline']);
		return $instance;
	}
}

function wp_register_widget_theme(){
	register_widget('WP_register_widget_social');
	register_widget('themedivregister_theme_google_plus');

}

add_action('widgets_init','wp_register_widget_theme');
