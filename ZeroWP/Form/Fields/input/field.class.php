<?php
namespace ZeroWP\AdminForm;

zerowp_admin_form_register_field( 'input', __NAMESPACE__ . '\\Input' );

class Input extends Field{
	
	public function defaultSettings(){
		return array(
			'allow_safe_html' => false,
			'size' => 'regular',
			'type_attr' => 'text',
			'text_before' => false,
			'text_after' => false,
		);
	}

	public function render(){
		// Input type
		$type_attr = $this->getSetting( 'type_attr' );
		$type  = 'text';
		
 		if( !empty($type_attr) ){
			if( in_array( $type_attr, array('text', 'password', 'email', 'number', 'url', ) ) ){
				$type = $type_attr;
			}
		}

		// Input width
		$size = $this->getSetting( 'size' );
		$size_class = 'regular-text';

		if( !empty($size) ){
			if( in_array( $size, array('wide', 'widefat', 'large') ) ){
				$size_class = 'widefat';
			}
			elseif( in_array( $size, array('small', 'small-text', 'mini') ) ){
				$size_class = 'small-text';
			}
			elseif( 'none' == $size ){
				$size_class = '';
			}
		}

		return $this->getSetting('text_before') . '<input type="'. $type .'" value="'. esc_attr( $this->getValue() ) .'" name="'. $this->getName() .'" class="'. $size_class .'" />'. $this->getSetting('text_after');
	}

	public function sanitize( $value ){
		$allow_safe_html = $this->getSetting('allow_safe_html');
		return ( !empty($allow_safe_html) ) ? wp_kses_data( $value ) : sanitize_text_field( $value );
	}

}