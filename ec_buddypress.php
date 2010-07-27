<?php 
add_action( 'bp_setup_nav', 'ec_bp_setup_nav' );

function ec_bp_setup_nav(){
	global $bp;
	$events_link = $bp->displayed_user->domain . 'eventos/';

	bp_core_new_nav_item( array( 'name' => 'Eventos', 
								 'slug' => 'eventos', 
								 'screen_function' => 'ec_show_events_list',
								 'position' => 0));

	bp_core_new_subnav_item( array( 'name' => 'Eventos', 
									'slug' => 'mis-eventos',
									'parent_url' => $events_link, 
									'parent_slug' => 'eventos', 
									'screen_function' => 'ec_show_events_list', 
									'position' => 10  ) );

	bp_core_new_subnav_item( array( 'name' => 'Calendario', 
									'slug' => 'mi-calendario',
									'parent_url' => $events_link, 
									'parent_slug' => 'eventos', 
									'screen_function' => 'ec_show_events_calendar', 
									'position' => 20  ) );

	bp_core_new_subnav_item( array( 'name' => 'Crear Evento', 
									'slug' => 'evento_nuevo',
									'parent_url' => $events_link, 
									'parent_slug' => 'eventos', 
									'screen_function' => 'ec_show_events_editor', 
									'user_has_access' => bp_is_my_profile(),
									'position' => 30  ) );


}

function ec_show_events_calendar(){
	bp_core_load_template('members/single/home');
	add_action( 'bp_before_member_body' , 'ec_show_events_calendar_html');
}

function ec_show_events_list(){
	bp_core_load_template('members/single/home');
	add_action( 'bp_before_member_body' , 'ec_show_events_list_html');
}

function ec_show_events_editor(){
	bp_core_load_template('members/single/home');
	add_action( 'bp_before_member_body' , 'ec_show_events_editor_html');
}

function ec_show_events_calendar_html(){
	include_once(EVENTSCALENDARCLASSPATH.DS."bdpress/header.php");

	$calendar = new EC_Calendar();
	$month = date('m');
	$year = date('Y');
  	if (isset($_GET['EC_action'])) {
		$month = $_GET['EC_action'] == 'switchMonth' ? (int)$_GET['EC_month'] : date('m');
		$year = $_GET['EC_action'] == 'switchMonth' ? (int)$_GET['EC_year'] : date('Y');
	}

	$calendar->displayLarge($year, $month);
}
function ec_show_events_list_html(){
	include_once(EVENTSCALENDARCLASSPATH.DS."bdpress/header.php");

	$calendar = new EC_Calendar();
	$calendar->displayEventList(5);
}

function ec_show_events_editor_html(){
	include_once(EVENTSCALENDARCLASSPATH.DS."bdpress/header.php");

	$calendar = new EC_Management();
	$calendar->display();
}
?>