<?php
/*
Plugin Name: Simple Feedback Widget
Plugin URI: http://www.rekommend.io/simple-feedback-widget
Description: Simple Feedback Widget - simply add this little widget to ask a question on your site.
Version: 1.6.6
Author: rekommend
Author URI: http://www.rekommend.io/
License: GPL2
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function rekommend_widget_enqueues() {
	wp_enqueue_style( 'simple-feedback-widget-style', plugins_url().'/simple-feedback-widget/simple-feedback-widget-css.css' );
	wp_enqueue_style( 'simple-feedback-widget-animate-style', plugins_url().'/simple-feedback-widget/simple-feedback-widget-animate-css.css' );
	wp_enqueue_script( 'simple-feedback-widget-script', plugins_url().'/simple-feedback-widget/simple-feedback-widget-js.js', array( 'jquery' ) );
	//wp_enqueue_script( 'simple-feedback-widget-cookie-script', plugins_url().'/simple-feedback-widget/simple-feedback-widget-cookie-script.js', array( 'jquery' ) );
}

function rekommend_admin_enqueues() {
	wp_enqueue_style( 'simple-feedback-widget-admin-style', plugins_url().'/simple-feedback-widget/simple-feedback-widget-admin-css.css' );
    wp_enqueue_script( 'simple-feedback-widget-admin-js', plugins_url().'/simple-feedback-widget/simple-feedback-widget-admin-js.js', array( 'jquery' ) );
}

function rekommend_create_divs() {

	if (get_option('rekommend_wp_position') == FALSE ) {
		add_option('rekommend_wp_position', 'right', '', 'yes');
	}
	
	if (get_option('rekommend_wp_margin') == FALSE ) {
		add_option('rekommend_wp_margin', '100', '', 'yes');
	}
	
	if (get_option('rekommend_wp_question') == FALSE ) {
		add_option('rekommend_wp_expanded', 'Would you recommend this site?', '', 'yes');
	}
	
	$rekommend_wp_url = get_option( 'rekommend_wp_url' );
	$rekommend_wp_position = get_option( 'rekommend_wp_position' );
	$rekommend_wp_margin = get_option( 'rekommend_wp_margin' );
	$rekommend_wp_question = get_option( 'rekommend_wp_question');

    echo '   
    <div id="rekommend-question-button1" class="rekommend-hidden" style="' . $rekommend_wp_position .': '. $rekommend_wp_margin .'px;">
    	  <a id="rekommend-close-widget1" class="rekommend-close-widget-visible modalCloseImg" title="Close"></a>
    	<div id="rekommend-question-itself1" class="rekommend-question-itself">' . $rekommend_wp_question .'</div>
    </div>

    <div id="rekommend-widget-outer-div1" class="rekommend-hidden" style="' . $rekommend_wp_position .': '. $rekommend_wp_margin .'px;">
    	<div id="rekommend-iframe-header1" class="rekommend-iframe-header">powered by rekommend.io</div>
    	<a id="rekommend-close-widget2" class="rekommend-close-widget-visible modalCloseImg" title="Close"></a>
       <iframe id="rekommend-widget-iframe" src="';
        echo $rekommend_wp_url;
        //echo 'http://localhost:3000/5F46C2FF/472';
        echo '/minwidget" scrolling="no" class="rekommend-widget-iframe"/>
        </iframe>
        </div>
';
	
}

function rekommend_plugin_menu() {
	add_options_page( 'Simple Feedback Widget Options', 'Simple Feedback Widget', 'manage_options', 'simple-feedback-widget-id', 'rekommend_plugin_options' );
}

function rekommend_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$rekommend_wp_url = get_option( 'rekommend_wp_url');
	$rekommend_wp_id = get_option( 'rekommend_wp_id');
	$rekommend_wp_question = get_option( 'rekommend_wp_question');
	$admin_email = get_option( 'admin_email' );


	echo '<div class="div-centred">';
	echo '<img src="'.plugins_url().'/simple-feedback-widget/images/rekommendlogo.png" style="height: 60px;"><br>';
	echo '</div>';
	//echo '<div class="wrap">';
	//echo '<p>Your Question URL is <b>';
	//echo $rekommend_wp_url . '</b> </div>';
	//echo '<hr><form action="http://localhost:3000/widget/change-question" method="get" id="rekommend_settings_form">


	
	echo '
	<form method="post" action="options.php" id="rekommend_settings_form1">';
    settings_fields( "rekommend-option-group" );
    do_settings_sections( "rekommend-option-group" );


    //echo '<h3> Update Question Text: </h3>';

    //echo '<p>
//			<input id="rekommend_wp_question1" type="text" name="rekommend_wp_question" value="'. $rekommend_wp_question .'" class="rekommend_input_form"/>
//		</p><br><br>';

    echo '<h3> Position of Widget: </h3>';
    echo '
      	<p>
			<input name="rekommend_wp_position" type="radio" value="left"';
			if (get_option ("rekommend_wp_position") == "left") { 
				echo 'checked';
			}
	echo '/> Bottom Left
			<br><br>
			<input name="rekommend_wp_position" type="radio" value="right"';
			if (get_option ("rekommend_wp_position") == "right") { 
				echo 'checked';
			}
	echo '/> Bottom Right
		</p>
      Margin from the side:
      <input type="text" name="rekommend_wp_margin" value="'. get_option( "rekommend_wp_margin" ) . '"class="rekommend_margin"/>px
     <br><br>
     <input type="hidden" name="rekommend_wp_id1" value="'. $rekommend_wp_id .'" id="rekommend_wp_id1">
     <br><br>
    <input type="submit" name="update-question" value="Update" class="rekommend_submit_button">
    </form>';

    echo '<br><br><div id="saveResult"></div>';
    echo '
	<br><br>';
	echo '<h3> Rekommend Options: </h3>';
	echo '
	<div>
		<iframe id="rekommend-widget-admin-iframe" src="https://www.rekommend.io/widget/account?email=' . $admin_email . '&authtoken='. $rekommend_wp_id .'" scrolling="yes" class="rekommend-widget-admin-iframe"/>
        </iframe>
        </div>
	<div>
		<p> 
			Questions? Issues? Please check the FAQ / create a ticket here:
			<a href="https://www.rekommend.io/simple-feedback-widget#faq"> FAQ </a>
		</p>
	</div>
	';

}


function setup_rekommend_wp_widget () {

	$rekommend_wp_id = md5(uniqid(rand(), true));
	$admin_email = get_option( 'admin_email' );
	$site_url = get_option( 'siteurl' );


	$rekommend_wp_position = 'right';
	$rekommend_wp_margin = '15';
	$rekommend_wp_question = 'Would you recommend this site?';

	$response = wp_remote_get( 'https://www.rekommend.io/widget/setup?email='. $admin_email .'&id=' . $rekommend_wp_id .'&siteurl=' . $site_url);	
	//$response = wp_remote_get( 'http://localhost:3000/widget/setup?email='. $admin_email .'&id=' . $rekommend_wp_id .'&siteurl=' . $site_url);

	if( is_array($response) ) {
  		$rekommend_wp_url = $response['body'];
	}

	if (get_option('rekommend_wp_id') == FALSE ) {
		add_option('rekommend_wp_id', $rekommend_wp_id, '', 'yes');
	}
	else {
		update_option( 'rekommend_wp_id', $rekommend_wp_id );
	}

	if (get_option('rekommend_wp_url') == FALSE ) {
		add_option('rekommend_wp_url', $rekommend_wp_url, '', 'yes');
	}
	else {
		update_option( 'rekommend_wp_url', $rekommend_wp_url);
	}

	if (get_option('rekommend_wp_position') == FALSE ) {
		add_option('rekommend_wp_position', $rekommend_wp_position, '', 'yes');
	}
	else {
		update_option( 'rekommend_wp_position', $rekommend_wp_position );
	}

	if (get_option('rekommend_wp_margin') == FALSE ) {
		add_option('rekommend_wp_margin', $rekommend_wp_margin, '', 'yes');
	}
	else {
		update_option( 'rekommend_wp_margin', $rekommend_wp_margin );
	}

	if (get_option('rekommend_wp_question') == FALSE ) {
		add_option('rekommend_wp_question', $rekommend_wp_question, '', 'yes');
	}
	else {
		update_option( 'rekommend_wp_question', $rekommend_wp_question );
	}

}

function rekommend_admin_scripts() {
   if ( is_admin() ){ 
         wp_enqueue_script('jquery');
         wp_enqueue_script( 'jquery-form' );

   }
}


function register_rekommend_settings () {
	register_setting( 'rekommend-option-group', 'rekommend_wp_margin' );
  	register_setting( 'rekommend-option-group', 'rekommend_wp_position' );
  	register_setting( 'rekommend-option-group', 'rekommend_wp_expanded' );
  	register_setting( 'rekommend-option-group', 'rekommend_wp_question' );
}

function rekommend_settings_link($links) { 
	$settings_link = '<a href="options-general.php?page=simple-feedback-widget-id">Settings</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'rekommend_settings_link' );

add_action( 'admin_init', 'register_rekommend_settings' );
add_action( 'admin_init', 'rekommend_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'rekommend_admin_enqueues' );
add_action( 'admin_menu', 'rekommend_plugin_menu' );

add_action( 'wp_enqueue_scripts', 'rekommend_widget_enqueues' );
add_action( 'wp_footer', 'rekommend_create_divs' );

register_activation_hook(__FILE__,'setup_rekommend_wp_widget');

?>
