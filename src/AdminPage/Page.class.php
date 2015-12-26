<?php
/** 
* Admin page
*
* Create a backend page.
* 
* @since 1.0
*
*/
namespace ZeroWP\Admin;

class Page{

	//------------------------------------//--------------------------------------//
	
	/**
	 * The id of this admin page
	 *
	 * The id is used to create the menu slug, and to limit everything else only to this page
	 *
	 * @return string 
	 */
	protected $id;

	//------------------------------------//--------------------------------------//
	
	/**
	 * Construct object
	 *
	 */
	public function __construct($id){
		$this->id = $id;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Init object
	 *
	 */
	public function init(){
		add_action( 'admin_menu', array($this, 'menu'), 30 );
		add_action( 'admin_enqueue_scripts', array($this, 'adminEnqueue'), 30 );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Page Settings
	 *
	 * Define the pages settings.
	 * Designed to be extended in child class.
	 *
	 * @return array 
	 */
	public function settings(){
		return array();
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Admin page
	 *
	 * The admin page HTML.
	 * Designed to be extended in child class.
	 *
	 * @return string The HTML page
	 */
	public function page(){
		_e('Congrats! you\'ve created a new page.', 'ZeroWP');
	}
	
	//------------------------------------//--------------------------------------//
	
	/**
	 * Display page
	 *
	 * Display the final formated page
	 *
	 * @return string The HTML
	 */
	public function displayPage(){
		echo '<div class="wrap">';
		
			$this->showTabs();
			do_action( $this->action('after_tabs') );

			$this->showPages();
			do_action( $this->action('after_page') );

		echo '</div>';
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Admin enqueue
	 *
	 * Admin enqueue scripts and styles.
	 * Designed to be extended in child class.
	 *
	 * @return void 
	 */
	public function enqueue(){}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Admin enqueue only on this page
	 *
	 * Admin enqueue scripts and styles only on this page
	 *
	 * @return void 
	 */
	final public function adminEnqueue(){
		if( isset($_GET['page']) && $_GET['page'] == $this->id ){
			$this->enqueue();
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Show Tabs
	 *
	 * Display tabs on page if their number is 2 or higher
	 *
	 * @return string The HTML 
	 */
	protected function showTabs(){
		if( count($this->tabs()) > 1 ) : 
			echo '<h2 class="nav-tab-wrapper">';
				foreach ($this->tabs() as $tab_key => $tab) {
					$id           = $tab['id'];
					$label        = $tab['label'];
					$active_class = $this->currentTab() == $id ? ' nav-tab-active' : '';
					$class        = ' class="nav-tab'. $active_class .'"';

					echo '<a href="'. add_query_arg( array('tab' => $id), $this->getBaseTabUrl() ) .'"'. $class .'>'. $label .'</a>';
				}
			echo'</h2>';
		endif;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get base tab url
	 *
	 * Removes all args except for 'page'
	 *
	 * @return string The URL 
	 */
	protected function getBaseTabUrl(){
		$page = sanitize_title( $_GET['page'] );
		$url = explode( '?', $_SERVER['REQUEST_URI'] );

		return esc_url( $url[0] . '?page='. $page );
	}

	//------------------------------------//--------------------------------------//

	/**
	 * Show Pages
	 *
	 * Display pages content for by active tab
	 *
	 * @return string The HTML 
	 */
	protected function showPages(){
		foreach ($this->tabs() as $tab_key => $tab) {
			
			$id           = $tab['id'];
			$active_class = $this->currentTab() == $id ? ' tab-container-active' : '';

			if( $id == $this->currentTab() ){
				echo '<div class="tab-container'. $active_class .'">';
					
					if( $id == $this->id ){
						$this->page();
					}
					if( isset($tab['callback']) ){
						$callback = $tab['callback'];
						call_user_func($callback);
					}
					do_action($this->action('tab_' . $id));

				echo '</div>';
			}
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * All tabs
	 *
	 * Get all tabs
	 *
	 * @return array All tabs in an associative array. 
	 */
	protected function tabs(){
		
		$settings = $this->settings();
		if( !empty($settings['default_tab_label']) && trim($settings['default_tab_label']) !== false ){
			$default_tab_label = esc_html( $settings['default_tab_label'] );
		}
		else{
			$default_tab_label = $settings['menu_title'];
		}

		$default_tab[] = array(
			'id' => sanitize_title( $this->id ),
			'label' => $default_tab_label,
		);
		$all_tabs         = apply_filters( $this->filter('add_tabs'), $default_tab);
		$final_tabs       = array();
		$tab_count        = 0;

		// Validate and create tabs
		foreach ($all_tabs as $tab_key => $tab) {
			
			//Tab ID
			if( empty($tab['id']) ) {
				unset($tab_key);
				continue;
			}
			else{
				$final_tabs[$tab_count]['id'] = sanitize_html_class( $tab['id'] );
			}

			//Tab label
			$final_tabs[$tab_count]['label'] = ( empty($tab['label']) ) ? 
				esc_html( $tab['id'] ) :
				esc_html( $tab['label'] );

			//Tab callback
			if( ! empty($tab['callback']) ) {
				$final_tabs[$tab_count]['callback'] = $tab['callback'];
			}

			//Custom query args
			$final_tabs[$tab_count]['query_args'] = !empty($tab['query_args']) ? (array) $tab['query_args'] : array();

			$tab_count++;
		}

		return $final_tabs;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * All possible tabs
	 *
	 * Get all possible tab ids
	 *
	 * @return array All tabs ids in an associative array. 
	 */
	protected function possibleTabs(){
		return wp_list_pluck( $this->tabs(), 'id' );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get current tab ID
	 *
	 * Get current tab ID from URL
	 *
	 * @return string Tab ID
	 */
	protected function currentTab(){
		return isset( $_GET[ 'tab' ] ) && in_array($_GET[ 'tab' ], $this->possibleTabs()) ? $_GET[ 'tab' ] : $this->id;
	}
	
	//------------------------------------//--------------------------------------//

	/**
	 * Add tabs
	 *
	 * Add additional tabs to this admin panel. Hook.
	 *
	 * @return void
	 */
	public function add_tabs( $function_to_add, $priority = 10, $accepted_args = 1 ){
		return $this->add_filter('add_tabs', $function_to_add, $priority, $accepted_args);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add menu
	 *
	 * Create the page menu link
	 *
	 * @return void 
	 */

	public function menu(){
		if( ! $this->_menuExists($this->id) ){ // If menu does not exist, create it.
			$settings = $this->pageSettings( (array) $this->settings() );
			if( $settings['menu_type'] == 'submenu' ){
				add_submenu_page( 
					$settings['parent_slug'],      // Parent page slug
					$settings['page_title'],       // Page title
					$settings['menu_title'],       // Menu title
					$settings['capability'],       // Capability
					$this->id,                     // Menu slug
					array($this, 'displayPage')    // Calback function to display the page contents
				);
			}
			elseif( $settings['menu_type'] == 'menu' ){
				add_menu_page( 
					$settings['page_title'],       // Page title
					$settings['menu_title'],       // Menu title
					$settings['capability'],       // Capability
					$this->id,                     // Menu slug
					array($this, 'displayPage'),   // Calback function to display the page contents
					$settings['menu_icon'],        // The icon url or "Dashicons" class
					$settings['menu_position']     // Menu position
				);
			}
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Page settings
	 *
	 * Define the menu/page settings/content.
	 *
	 * @param array $settings The settings array 
	 * @return array The final settings 
	 */
	public function pageSettings($settings = array()){

		// Menu type. `menu` or `submenu`
		if( !empty($settings['menu_type']) && 
			in_array( $settings['menu_type'], array('menu', 'submenu') )
		){
			$menu_type = trim( $settings['menu_type'] );
		}
		else{
			$menu_type = 'submenu';
		}

		// Parent page menu slug
		$parent_slug = ! empty( $settings['parent_slug'] ) ? trim( $settings['parent_slug'] ) : null;
		
		// Get the correct page title
		$page_title  = ! empty($settings['page_title']) ? trim( $settings['page_title'] ) : '';

		// Get the correct menu title
		$menu_title  = ! empty($settings['menu_title']) ? trim( $settings['menu_title'] ) : '';

		// Check if page title exists, else assign the menu title if possible
		if( empty($page_title) && ! empty($menu_title) ){
			$page_title = $menu_title;
		}

		// Check if menu title exists, else assign the page title if possible
		if( empty($menu_title) && ! empty($page_title) ){
			$menu_title = $page_title;
		}

		// If both page and menu title are empty, stuck on page id(menu slug)
		if( empty($page_title) && empty($menu_title) ){
			$page_title = $menu_title = $this->id;
		}

		// Capability
		$capability = 'manage_options';
		if( ! empty($settings['capability']) && 
			in_array( $settings['capability'], $this->_allPossibleCapabilities() ) ){
			$capability = $settings['capability'];
		}

		// Menu icon
		$menu_icon = ! empty($settings['menu_icon']) ? trim( $settings['menu_icon'] ) : '';

		// Menu Position
		if( ! empty($settings['menu_position']) && is_numeric($settings['menu_position']) ){
			$menu_position = trim( $settings['menu_position'] );
		}
		else{
			$menu_position = null;
		}

		$menu_settings['menu_type']     = $menu_type;         // Menu type
		$menu_settings['parent_slug']   = $parent_slug;       // Parent page slug
		$menu_settings['page_title']    = $page_title;        // Page title
		$menu_settings['menu_title']    = $menu_title;        // Menu title
		$menu_settings['capability']    = $capability;        // Capability
		$menu_settings['menu_icon']     = $menu_icon;         // Icon URL or class name
		$menu_settings['menu_position'] = $menu_position;     // Menu position

		return $menu_settings;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Check if a parent menu exists
	 *
	 * Check if a parent menu exists
	 *
	 * @param string $menu_slug The menu slug to check for.
	 * @return bool Return `true` if exists `false` if not 
	 */
	protected function _menuExists($menu_slug){
		if ( in_array( $menu_slug, $this->_allAdminPageSlugs() ) ) {
			return true;
		} else {
			return false;
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * All admin pages slugs
	 *
	 * Return an array with all page slugs that exist.
	 *
	 * @return array All slugs. (int)key => (string)slug
	 */
	protected function _allAdminPageSlugs(){
		$all_menus = $GLOBALS['submenu'];
		
		$exact_pages = array();
		if( isset($all_menus) ){
			foreach ($all_menus as $key => $par_menu) {
				foreach ($par_menu as $key => $submenu) {
					$exact_pages[] = $submenu[2];
				}
			}
		}

		return $exact_pages;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get all possible capabilities
	 *
	 * Get all possible user capabilities, that allows to perfom an action
	 *
	 * @return array All possible capabilities in an array
	 */
	protected function _allPossibleCapabilities(){
		global $wp_roles; 
		
		$roles = $wp_roles->roles; 

		$capabilities = array();
		foreach ($roles as $role => $role_val) {
			if( isset( $role_val['capabilities'] ) ){
				foreach ($role_val['capabilities'] as $key => $value) {
					$capabilities[$key] = $key;
				}
			}
		}

		return $capabilities;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Action
	 *
	 * Allows to create page actions for `do_action` using the id of the current instance.
	 *
	 * @param string $action The action suffix
	 * @return string The full action hook name
	 */
	public function action($action){
		return $this->id .'_'. $action;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Filter
	 *
	 * Allows to create page filter for `apply_filters` using the id of the current instance.
	 *
	 * @param string $action The action suffix
	 * @return string The full action hook name
	 */
	public function filter($filter){
		return $this->id .'_'. $filter;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add Action
	 *
	 * A shortcut for WP native function `add_action`. This should be used only for current
	 * class to get the right action name by suffix.
	 *
	 * @return void 
	 */
	public function add_action($action, $function_to_add, $priority = 10, $accepted_args = 1){
		return add_action( $this->id .'_'. $action, $function_to_add, $priority, $accepted_args);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add Action Alias
	 *
	 * Alias for $this->add_action()
	 *
	 * @return void 
	 */
	public function addAction($action, $function_to_add, $priority = 10, $accepted_args = 1){
		return $this->add_action( $action, $function_to_add, $priority, $accepted_args);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add Filter
	 *
	 * A shortcut for WP native function `add_filter`. This should be used only for current
	 * class to get the right filter name by suffix.
	 *
	 * @return void 
	 */
	public function add_filter( $filter, $function_to_add, $priority = 10, $accepted_args = 1 ){
		return add_filter( $this->id .'_'. $filter, $function_to_add, $priority, $accepted_args);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Add Filter Alias
	 *
	 * Alias for $this->add_filter()
	 *
	 * @return void 
	 */
	public function addFilter( $filter, $function_to_add, $priority = 10, $accepted_args = 1 ){
		return $this->add_filter( $filter, $function_to_add, $priority, $accepted_args);
	}

}