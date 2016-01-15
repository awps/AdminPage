<?php
namespace ZeroWP\AdminForm;

zerowp_admin_form_register_field( 'textarea', __NAMESPACE__ . '\\Textarea' );

class Textarea extends Field{
	
	public function defaultSettings(){
		return array(
			'rows' => 5, //number of rows(int)
			'size' => 'large', // 'large' or number of columns(int)
			'allow_html' => true, // true, false, 'raw' or 'limited'
		);
	}

	public function render(){
		//Nuber of rows
		$rows = absint( $this->getSetting( 'rows' ) );
		$rows = $rows > 0 ? $rows : 5;

		// Input width
		$size = $this->getSetting( 'size' );
		$size_attr = '';

		if( !empty($size) && ($size = trim( $size )) ){
			if( in_array( $size, array('wide', 'widefat', 'large') ) ){
				$size_attr = ' class="widefat"';
			}
			elseif( is_numeric( $size ) ){
				$size_attr = ' cols="'. absint( $size ) .'"';
			}
		}

		return '<textarea name="'. $this->getName() .'"'. $size_attr .' rows="'. $rows .'">'. esc_textarea( $this->getValue() ) .'</textarea>';
	}

	public function sanitize( $value ){
		$allow_html = $this->getSetting('allow_html');

		// Sanitize
		if( 'limited' == $allow_html ){
			$value = wp_kses_data( $value ); // Only some inline tags
		}
		elseif( 'raw' == $allow_html ){
			$value = $value; // Any HTML tags and attr, even 'script'. RAW
		}
		elseif( $allow_html === false ){
			$value = strip_tags( $value ); // No tags allowed at all
		}
		else{
			$value = wp_kses_post( $value ); // Default. Can use only the tags that are allowed in posts.
		}

		return $value;
	}

}