<?php
/*
Plugin Name: WP WooCommerce Redirect
Plugin URI: http://www.e2soft.com/blog/change-woocommerce-login-register-redirect-url/
Description: WP WooCommerce Redirect is a WordPress plugin to redirect your WooCommerce website after register or login!  You can set any custom page or custom redirect according to user role. 
Version: 1.1
Author: S M Hasibul Islam
Author URI: http://www.e2soft.com/
Copyright: 2016 S M Hasibul Islam http://www.e2soft.com
License URI: license.txt
*/


#######################	WP WooCommerce Redirect ###############################

// Check woocommerce exist or not 
function check_woocommerce_exist_or_not() {
  if ( !is_plugin_active('woocommerce/woocommerce.php') ) {
  
	  // Show required mesage
	  function sample_admin_notice__error() {
			$class = 'notice notice-error';
			$message = __( '<b>An error has occurred. Please active <a href="'.admin_url( 'plugin-install.php?tab=search&s=woocommerce', '' ).'">WooCommerce plugin</a> before active <a href="#">WP WooCommerce Redirect</a></b>', 'sample-text-domain' );
		
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
		}
		add_action( 'admin_notices', 'sample_admin_notice__error' );
	
  }else{
	  return 0;
  }
}
add_action( 'admin_init', 'check_woocommerce_exist_or_not' );


/**
 * Redirect users to custom URL based on their role after login
 **/
function wp_woo_custom_redirect( $redirect, $user ) {
	
	// Get the first of all the roles assigned to the user
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = get_permalink( wc_get_page_id( 'my-account' ) );

	if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		$admin_redirect = get_option('admin_redirect');
		$redirect = $admin_redirect;
		
	} elseif ( $role == 'shop-manager' || $role == 'seller' ) {
		//Redirect shop managers to the dashboard
		$shop_manager_redirect = get_option('shop_manager_redirect');
		$redirect = $shop_manager_redirect;
		
	} elseif ( $role == 'customer' || $role == 'subscriber' ) {
		//Redirect customers and subscribers to the "My Account" page
		$customer_redirect = get_option('customer_redirect');
		$redirect = $customer_redirect;
		
	} else {
		//Redirect any other role to the previous visited page or, if not available, to the home
		$redirect = wp_get_referer() ? wp_get_referer() : home_url();
	}
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wp_woo_custom_redirect', 10, 2 );

//Home redirect for users after logout
add_action('wp_logout',create_function('','wp_redirect(home_url()); exit();'));


// Custom redirect for users after registration
function wp_woo_register_redirect( $redirect, $user ) {
	
	 $role = $user->roles[0];
	 $dashboard = admin_url();
	 $myaccount = get_permalink( wc_get_page_id( 'my-account' ) );
	 
	 if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		$admin_redirect = $dashboard;
		$redirect = $admin_redirect;
	 }
	 
	 elseif ( $role == 'shop-manager' || $role == 'seller' ) {
		//Redirect shop managers to the dashboard
		$shop_manager_redirect = get_option('shop_manager_redirect');
		$redirect = $shop_manager_redirect;
	}
	 
	 elseif( $role == 'customer' || $role == 'subscriber' ){
		$redirect = $myaccount; 
	 }
	 
     return $redirect;
}
add_filter('woocommerce_registration_redirect', 'wp_woo_register_redirect');

// Include all php file
foreach ( glob( plugin_dir_path( __FILE__ )."lib/*.php" ) as $php_file )
    include_once $php_file;

// Register admin style file
function wp_woo_redirect_style()
{
	wp_enqueue_style( 'wp-woo-redirect', plugins_url('/css/wp-woo-redirect.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'wp_woo_redirect_style' ); 

// Redirect after plugin activation
register_activation_hook(__FILE__, 'wp_woo_redirec_active');
add_action('admin_init', 'wp_woo_redirect_plugin_redirect');

function wp_woo_redirec_active() {
    add_option('wp_woo_do_activation_redirect', true);
}

function wp_woo_redirect_plugin_redirect() {
    if (get_option('wp_woo_do_activation_redirect', false)) {
        delete_option('wp_woo_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=wp_woo_redirect");
        }
    }
}
