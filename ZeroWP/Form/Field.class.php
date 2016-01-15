<?php
namespace ZeroWP\AdminForm;

class Field{
	
	protected $id;
	protected $value; 
	protected $settings;

	public function __construct( $id, $value = '', $settings = array() ){
		$this->id = $id;
		$this->value = $value;
		$this->settings = $settings;
	}

	public function enqueue(){
		return false;
	}

	public function defaultSettings(){
		return array();
	}

	public function settings(){
		$default_settings = wp_parse_args( $this->defaultSettings(), array(
			'label' => '',
			'description' => '',
		) );
		return wp_parse_args( $this->validateSettings( $this->settings ), $default_settings );
	}

	public function validateSettings( $settings ){
		return (array) $settings;
	}

	public function render(){
		return false;
	}

	public function renderField(){
		$settings = $this->settings();
		$field = '';
		$field .= '<div class="zerowp-adminform-field-block">';

			if( !empty($settings['label']) ){
				$label = esc_html( $settings['label'] );
			}
			else{
				$label = $this->id;
			}

			$field .= '<div class="zerowp-adminform-field-label">'. $label .'</div>';

			$field .= '<div class="zerowp-adminform-field-block">';
				$field .= '<div class="zerowp-adminform-field">'. $this->render() .'</div>';
				if( !empty($settings['description']) ){
					$field .= '<div class="zerowp-adminform-field-description">'. $settings['description'] .'</div>';
				}
			$field .= '</div>';
			
		$field .= '</div>';

		return $field;
	}

	public function validate( $value ){
		return false;
	}

	public function sanitize( $value ){
		return $value;
	}

	public function getSetting( $setting_key ){
		$settings = $this->settings();
		return ( isset($settings[ $setting_key ]) ) ? $settings[ $setting_key ] : false;
	}

	public function getName(){
		return esc_attr( $this->id );
	}

	public function getValue(){
		return $this->value;
	}


}