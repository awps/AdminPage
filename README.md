# WP-Admin-Page
Advanced  WordPress Admin pages(with tabs), the easy way...

##Requirements:

 * WordPress 3.4+
 * PHP 5.3+
 
##How to use:
###Include the files
```php
require_once "AdminPage/Page.class.php";
require_once "AdminPage/Tab.class.php";
```

###Create a page
```php
class ExamplePage extends WPAP\Page{

	public function settings(){
		return array(
			'menu_type'     => 'menu',
			'menu_title'    => __('Example page', 'text-domain'),
		);
	}

	public function page(){
	  echo 'Page content here!';
	}
}
$example_page = new ExamplePage('page-slug');
$example_page->init(); //Initialize this page.
```

The page is available at: *[site_url]/wp-admin/admin.php?page=`page-slug`*

###Create a tab
```php
class ExampleTab extends WPAP\Tab{

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
```

The tab is available at: *[site_url]/wp-admin/admin.php?`page=page-slug&tab=tabid`*
