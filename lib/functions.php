<?php
// Redirect page settings
function register_wp_woo_redirect() {
    add_submenu_page(
        'options-general.php',
        'WooCommerce Redirect Settings',
        'WooCommerce Redirect Settings',
        'manage_options',
        'wp_woo_redirect',
        'wp_woo_redirect_page_settings' );
}
add_action('admin_menu', 'register_wp_woo_redirect');


function wp_woo_redirect_page_settings() {
	
	error_reporting(0);
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = get_permalink( wc_get_page_id( 'my-account' ) );
	
	echo '<div class="wp_woo_redirect_wrap">';
	if ( !is_plugin_active('woocommerce/woocommerce.php') ) {
		
	}
		echo '<h1>"WP WooCommerce Redirect" Settings</h1>';
?>

<div id="wp_woo_redirect_left">
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <div class="inside">
    <h3>Set you redirect page after register and login according to user role.</h3>
    <table class="form-table">
      <tr>
        <th><label for="admin_redirect">Admin Redirect to (Login)</label></th>
        <td><input type="text" name="admin_redirect" value="<?php $admin_redirect = get_option('admin_redirect'); if(!empty($admin_redirect)) {echo $admin_redirect;} else {echo admin_url() ;}?>"></td>
      </tr>
      <tr>
        <th><label for="shop_manager_redirect">Shop Manager Redirect to (Login)</label></th>
        <td><input type="text" name="shop_manager_redirect" value="<?php $shop_manager_redirect = get_option('shop_manager_redirect'); if(!empty($shop_manager_redirect)) {echo $shop_manager_redirect;} else {echo home_url('/dashboard') ;}?>"></td>
      </tr>
      <tr>
        <th><label for="customer_redirect">Customer Redirect to (Login)</label></th>
        <td><input type="text" name="customer_redirect" value="<?php $customer_redirect = get_option('customer_redirect'); if(!empty($customer_redirect)) {echo $customer_redirect;} else {echo get_permalink( wc_get_page_id( 'myaccount' ) ) ;}?>"></td>
      </tr>
      <tr>
        <th><label for="register_customer_redirect">Customer Redirect to (Register)</label></th>
        <td><input type="text" name="register_customer_redirect" value="<?php $register_customer_redirect = get_option('register_customer_redirect'); if(!empty($register_customer_redirect)) {echo $register_customer_redirect;} else {echo get_permalink( wc_get_page_id( 'myaccount' ) ) ;}?>"></td>
      </tr>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="admin_redirect, shop_manager_redirect, customer_redirect, register_customer_redirect" />
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" class="button button-primary" />
    </p>
  </form>
</div>
</div>
<div id="wp_woo_redirect_right">
  <div class="nhtWidget">
    <h3>About the Plugin</h3>
    <p>WP WooCommerce Redirect is a wordpress plugin to redirect your woocommerce website after register or login!  You can set any custom page or custom redirect according to user role.</p>
    <p><strong>View live demo & support of <a href="http://www.e2soft.com/blog/wp-woocommerce-redirect/" target="_blank">WP WooCommerce Redirect.</a></strong></p>
    <!--<p>You can make my day by submitting a positive review on <a href="https://wordpress.org/support/view/plugin-reviews/wp-woocommerce-redirect" target="_blank"><strong>WordPress.org!</strong> <img src="<?php //bloginfo('url' ); echo"/wp-content/plugins/news-headline-ticker/img/review.png"; ?>" alt="review" class="review"/></a></p>-->
    <!--<p> With your help I can make Simple Fields even better! $5, $10, $50 â€“ any amount is fine! :)
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="82C6LTLMFLUFW">
      <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal â€“ The safer, easier way to pay online.">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
    </form>
    </p>-->
    <div class="clrFix"></div>
  </div>
  <div class="nhtWidget">
    <div class="clrFix"></div>
    <h3>About the Author</h3>
    <p>My name is <strong><a href="https://www.upwork.com/freelancers/~01bf79370d989b2033" target="_blank">S M Hasibul Islam</a></strong> and I am a <strong>Web Developer, Expert WordPress Developer</strong>. I am regularly available for interesting freelance projects. If you ever need my help, do not hesitate to get in touch <a href="https://www.upwork.com/freelancers/~01bf79370d989b2033" target="_blank">me</a>.<br />
      <strong>Skype:</strong> cse.hasib<br />
      <strong>Email:</strong> cse.hasib@gmail.com<br />
      <strong>Web:</strong> <a href="http://www.e2soft.com/"/>www.e2soft.com</a><br />
    <div class="clrFix"></div>
  </div>
</div>
<div class="clrFix"></div>
<?php		
	echo '</div>';
}
