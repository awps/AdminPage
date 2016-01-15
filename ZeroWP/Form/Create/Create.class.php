<?php
/** 
* Admin page
*
* Create a backend page.
* 
* @since 1.0
*
*/
namespace ZeroWP\AdminForm;

class Create{

	//------------------------------------//--------------------------------------//
	
	/**
	 * Construct
	 *
	 * @return void
	 */
	public function __construct( $name = false ){

	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add Field
	 *
	 * @return string The field HTML
	 */
	public function addField( $id, $type, $value, $settings = false ){
		$all_registered_fields = zerowp_admin_form_fields();

		if( array_key_exists($type, $all_registered_fields) ){
			$class_name = $all_registered_fields[ $type ];
			if( class_exists($class_name) ){
				$class_instance = new $class_name( $id, $value, $settings );
				echo $class_instance->renderField();
			}
		}

	}

	public function addSubmitButton( $text = false ){
		if( $text ){
			echo submit_button( $text );
		}
		else{
			echo submit_button();
		}
	}

	public function openForm(){
		echo '<form method="post">';
	}

	public function closeForm(){
		echo '</form>';
	}
	
}