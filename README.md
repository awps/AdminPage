# ZeroWP
Advanced  WordPress Admin pages, the easy way...

##This project is currently in `alpha` stage. The current code is fully functional, but may expect radical changes in the future!

###License: GPL
The license allows the usage in any projects(personal or commercial). An attribution link is not required, but very appreciated.

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
class ExamplePage extends ZeroWP\Page{

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
class ExampleTab extends ZeroWP\Tab{

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

###All available settings for pages: `ZeroWP\Page`
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

###All available settings for tabs: `ZeroWP\Tab`
```php
public function settings(){
	return array(
		'label'    => '', // The tab title. If empty the ID will be used(tab slug).
		'callback' => array( $this, 'page' ), // Optional. The function used to display the tab content. Default to method 'page' of the current class. Use it only if needed.
	);
}
```

###Add scripts and styles

`enqueue()`. This method allows to enqueue scripts and styles only on the page that you've created. The scripts and styles will be available in all other tabs that you'll create. This method is available in `ZeroWP\Tab` as well and the rules are the same(the scripts/styles will be available in all other tabs and parent page).

Here is a basic example:
```php
public function enqueue(){
	wp_register_style( 'example-css', 'example.css' );
	wp_enqueue_style( 'example-css' );

	wp_register_script( 'example-js', 'example.js' );
	wp_enqueue_script( 'example-js' );
}
```

###Using in plugins:

This piece of code can be included in plugins as it is and will work without problems, but it is recomended to replace the namespace `ZeroWP` and the text domain, which is the same `ZeroWP`, with your own. Doing so you'll avoid conflicts with other plugins using this code as well.<br>
To do this, just do a global search&replace in your favorite text editor.<br>
Happy coding.
