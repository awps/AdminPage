<?php
function zerowp_admin_form_fields(){
	return apply_filters( 'zerowp_admin_form_fields', array() );
}
function zerowp_admin_form_register_field( $type_name, $class_name ){
	$log_field = new ZeroWP\AdminForm\RegisterField( $type_name, $class_name );
	$log_field->register();
}

function zerowp_admin_form_deregister_field( $type_name ){
	$log_field = new ZeroWP\AdminForm\RegisterField( $type_name );
	$log_field->deregister();
}
