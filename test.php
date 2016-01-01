<?php
/* 
 * Plugin Name: ZeroWp AdminPage Test
 */

require_once dirname(__FILE__) . "/src/AdminPage/mod.php";


class ExamplePage extends ZeroWP\Admin\Page{

    public function settings(){
        return array(
            'parent_slug'   => null,
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
      echo 'Tab content here!';
    }
}
new ExampleTab('tabid', 'page-slug');