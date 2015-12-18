# WP-Admin-Page
Advanced  WordPress Admin pages(with tabs), the easy way...

####Requirements:

 * WordPress 3.4+
 * PHP 5.3+
 
####How to use:

**1. Include the files:**
```php
require_once "Page.class.php";
require_once "Tab.class.php";
```

**2. Create a new page(minimum requierements):**
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

**3. See it in action:**

Actually this is not the step 3. 

You can see your page on: *[site_url]/wp-admin/admin.php?page=`page-slug`*
