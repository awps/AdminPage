<?php

namespace ZeroWP\Options;

class Page extends ZeroWP\Admin\Page{
	
	public function page(){
		$form = new ZeroWP\AdminForm\Create;
		$form->openForm();

		$this->form( $form );

		$form->addSubmitButton();
		$form->closeForm();
	}

	public function form( $form ){
		return false;
	}
}