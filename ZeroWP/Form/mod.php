<?php
/* 
 * Mod Name:    Form
 * Description: Create admin forms in WordPress
 * Author:      ZeroWP Team
 * Author URI:  http://zerowp.com/
 */

//Do not allow direct access to this file.
if( ! function_exists('add_action') ) 
	die();

/*
-------------------------------------------------------------------------------
Get the root url of this mod
-------------------------------------------------------------------------------
*/
function zerowp_adminform_root_url(){
	return plugin_dir_url(__FILE__);
}

/*
-------------------------------------------------------------------------------
Get the root path of this mod
-------------------------------------------------------------------------------
*/
function zerowp_adminform_root_path(){
	return plugin_dir_path(__FILE__);
}

/*
-------------------------------------------------------------------------------
Define PATH and URI constants
-------------------------------------------------------------------------------
*/
define('ZEROWP_ADMINFORM_PATH', zerowp_adminform_root_path() );
define('ZEROWP_ADMINFORM_URI', zerowp_adminform_root_url() );
define('ZEROWP_ADMINFORM_URL', ZEROWP_ADMINFORM_URI );//alternative for 'ZEROWP_ADMINFORM_URI'

require_once ZEROWP_ADMINFORM_PATH . "functions.php";
require_once ZEROWP_ADMINFORM_PATH . "Create/Create.class.php";
require_once ZEROWP_ADMINFORM_PATH . "RegisterFields/RegisterField.class.php";
require_once ZEROWP_ADMINFORM_PATH . "Field.class.php";

/*
-------------------------------------------------------------------------------
Include custom controls
-------------------------------------------------------------------------------
*/
$custom_fields = glob(ZEROWP_ADMINFORM_PATH .'Fields/*/field.class.php');
foreach ($custom_fields as $field) {
	require_once( $field );
}

/*
-------------------------------------------------------------------------------
Include functions for custom controls
-------------------------------------------------------------------------------
*/
$custom_fields_functions = glob(ZEROWP_ADMINFORM_PATH .'Fields/*/functions.php');
foreach ($custom_fields_functions as $field_functions) {
	require_once( $field_functions );
}