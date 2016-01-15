<?php
namespace ZeroWP\AdminForm;

class RegisterField{
	public $type;
	public $class;

	public function __construct( $type_name, $class_name = false ){
		$this->type = $type_name;
		$this->class = $class_name;
	}

	public function add( $fields_array ){
		if( !array_key_exists($this->type, $fields_array) && !empty($this->class) ){
			$fields_array[ $this->type ] = $this->class;
		}
		return $fields_array;
	}

	public function delete( $fields_array ){
		if( isset($this->type) ){
			unset( $fields_array[ $this->type ] );
		}
		return $fields_array;
	}

	public function register(){
		add_filter( 'zerowp_admin_form_fields', array( $this, 'add' ) );
	}

	public function deregister(){
		add_filter( 'zerowp_admin_form_fields', array( $this, 'delete' ) );
	}
}