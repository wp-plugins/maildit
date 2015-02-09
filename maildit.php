<?php
/*
Plugin Name: Maildit
Plugin URI: http://www.pronamic.eu/plugins/maildit/
Description: Deprecated — With the Maildit WordPress plugin users can easily create digital newsletters within WordPress. 
Version: 1.0.1
Requires at least: 3.0
Author: Pronamic
Author URI: http://www.pronamic.eu/
License: GPL
*/

class Maildit {
	public static function bootstrap() {
		add_action('init', array(__CLASS__, 'initialize'));

		add_action('admin_menu', array(__CLASS__, 'adminMenu'));

		add_filter('pre_get_posts', array(__CLASS__, 'excludeCategory'));
	}

	public static function initialize() {
		register_post_type('maildit_campaign' , array(
			'label' => 'Campaigns' , 
			'labels' => array(
				'name' => _x('Campaigns', 'post type general name'),
				'singular_name' => _x('Campaign', 'post type singular name'),
				'add_new' => _x('Add New', 'project'),
				'add_new_item' => __('Add New Campaign'),
				'edit_item' => __('Edit Campaign'),
				'new_item' => __('New Campaign'),
				'view_item' => __('View Campaign'),
				'search_items' => __('Search Campaigns'),
				'not_found' =>  __('No campaigns found'),
				'not_found_in_trash' => __('No campaigns found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Campaigns'
	
			) , 
			'description' => 'Campaigns' , 
			'public' => true , 
			'publicly_queryable' => true , 
			'show_ui' => true , 
			'show_in_menu' => false , 
			'capability_type' => 'post' , 
			'map_meta_cap' => true , 
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt' , 'trackbacks', 'custom-fields', 'comments', 'revisions') , 
			'has_archive' => true , 
			'rewrite' => array('slug' => 'project') 
		));
	}

	public static function adminMenu() {
		add_menu_page( 'Maildit', 'Maildit', 'manage_options', __FILE__, array(__CLASS__, 'page'));

		// @see _add_post_type_submenus()
		// @see wp-admin/menu.php
		add_submenu_page(__FILE__, 'Campaigns', 'Campaigns', 'manage_options', "edit.php?post_type=maildit_campaign" );

		add_submenu_page(__FILE__, 'Add new', 'Add new', 'manage_options', "post-new.php?post_type=maildit_campaign" );
	}

	public static function page() {
		// @todo CampaignMonitor tag information
		
		
		?>
		Maildit
		<?php
	}

	public static function todo() {
			
		define('DONOTMINIFY', true);
		
		define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
		
		define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
		
		function filter_where($where = '') {
			$where .= " AND post_date < '" . get_the_date('Y-m-d') . "'";
			return $where;
		}
		
		add_filter( 'posts_where', 'filter_where' );
		
		// http://help.campaignmonitor.com/topic.aspx?t=180
		// http://help.campaignmonitor.com/topic.aspx?t=97
		// <fblike></fblike>
		// <tweet></tweet>
	}

	public static function excludeCategory($query) {
		if($query->is_home || $query->is_feed) {
			// @todo should be option
			$query->set( 'cat', '-70' );
		}
	
		return $query;
	}
}

Maildit::bootstrap();
