# ZeroWP - AdminPage
Advanced  WordPress Admin pages, the easy way...

###License: GPL
The license allows the usage in any projects(personal or commercial). An attribution link is not required, but very appreciated.

##Requirements:

 * PHP 5.3+
 
##How to use:
###Include the files
```php
require_once dirname(__FILE__) . "/src/AdminPage/mod.php";
```

###Create a page
```php
class ExamplePage extends ZeroWP\Admin\Page{

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
```

The tab is available at: *[site_url]/wp-admin/admin.php?`page=page-slug&tab=tabid`*

###All available settings for pages: `ZeroWP\Admin\Page`

All settings are optional. Use only that you need.

```php
public function settings(){
	return array(
		'menu_title'    => '',
		'page_title'    => '',
		'menu_type'     => 'menu',
		'parent_slug'   => null,
		'capability'    => 'manage_options',
		'menu_icon'     => '',
		'menu_position' => null,
		'default_tab_label' => '',
	);
}
```

* **'menu_title'**<br />
	Default: `''`.  The menu title. If empty the ID will be used(page slug).

* **'page_title'**<br />
	Default: `''`. The text to be displayed in the title tags of the page when the menu is selected. If empty 'menu_title' is used 

* **'menu_type'**<br />
	Default: `'menu'`. The menu type `'menu'` or `'submenu'`. 

* **'parent_slug'**<br />
	Default: `null`.  If 'menu_type' is 'submenu' specify the parent page slug. Eg: tools.php

* **'capability'**<br />
	Default: `'manage_options'`.  Who can access the page. See: https://codex.wordpress.org/Roles_and_Capabilities

* **'menu_icon'**<br />
	Default: `''`. The icon for this menu. Only if 'menu_type' is 'menu'. https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters

* **'menu_position'**<br />
	Default: `null`. The position in the menu order this menu should appear. https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters

* **'default_tab_label'**<br />
	Default: `''`.  Default tab label. Setting this, will change the title of default tab(first tab), else will use the 'menu_title'.

###All available settings for tabs: `ZeroWP\Admin\Tab`

All settings are optional. Use only that you need.

```php
public function settings(){
	return array(
		'label'    => '',
	);
}
```

* **'label'**<br>
	Default: `''`. The tab title. If empty the ID will be used(tab slug).

###Add scripts and styles

`enqueue()`. This method allows to enqueue scripts and styles only on the page that you've created. The scripts and styles will be available in all other tabs that you'll create. This method is also available in `ZeroWP\Admin\Tab` and the rules are the same(the scripts/styles will be available in all other tabs and parent page).

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

This piece of code can be included in plugins as it is and will work without problems, but it is recomended to replace the namespace `ZeroWP` with your own. Doing so you'll avoid conflicts with other plugins that are using this code as well.<br>
Just do a global search&replace in your favorite text editor and you're done!<br>
Happy coding.
