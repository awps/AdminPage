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

###All available settings for pages: `WPAP\Page`
```php
public function settings(){
	return array(
		'menu_title'    => '', // The menu title. If empty the ID will be used(page slug).
		'page_title'    => '', //The text to be displayed in the title tags of the page when the menu is selected. If empty 'menu_title' is used 
		'menu_type'     => 'menu', //Or 'submenu'
		'parent_slug'   => null, // If 'menu_type' is 'submenu' specify the parent page slug. Eg: tools.php
		'capability'    => 'manage_options', // Who can access the page. See: https://codex.wordpress.org/Roles_and_Capabilities
		'menu_icon'     => '', //The icon for this menu. Only if 'menu_type' is 'menu'. https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters
		'menu_position' => null, //The position in the menu order this menu should appear. https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters
	);
}
```

###All available settings for tabs: `WPAP\Tab`
```php
public function settings(){
	return array(
		'label'    => '', // The tab title. If empty the ID will be used(tab slug).
		'callback' => array( $this, 'page' ), // Optional. The function used to display the tab content. Default to method 'page' of he current class. Use it only if needed.
	);
}
```
