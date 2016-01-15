<?php
/* 
 * Plugin Name: ZeroWp AdminPage Test
 */

require_once dirname(__FILE__) . "/ZeroWP/AdminPage/mod.php";
require_once dirname(__FILE__) . "/ZeroWP/Form/mod.php";


class ExamplePage extends ZeroWP\Admin\Page{

	public function settings(){
		return array(
			'parent_slug'   => 'options-general.php',
			'menu_title'    => __('Example page', 'text-domain'),
		);
	}

	public function page(){
	  echo 'Page content here!';
	}
}
$example_page = new ExamplePage('page-slug');
$example_page->init(); //Initialize this page.




class ExampleTab extends ZeroWP\Admin\Tab{

	public function settings(){
		return array(
			'label' => __('Tab title', 'text-domain')
		);
	}

	public function page(){
		$form = new ZeroWP\AdminForm\Create;

		$form->openForm();

		$form->addField( 'fieldid1', 'input', 19, array(
			'label' => 'Input test',
			'size' => 'small',
			'type_attr' => 'number',
			'text_before' => 'Mark is',
			'text_after' => 'years old',
		) );

		$form->addField( 'fieldid2', 'textarea', 'the value', array(
			'label' => 'Textarea test',
		) );

		$form->addSubmitButton();
		
		$form->closeForm();
	}
}
new ExampleTab('tabid', 'page-slug');

