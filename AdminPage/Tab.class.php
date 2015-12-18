<?php
/** 
* Admin page tab
*
* Create a tab on an existing page created with 'Page' class
* 
* @since 1.0
*
*/
namespace WPAP;

class Tab{
	
	public $parent_page_id;
	public $parent_page;
	public $tab_id;

	public function __construct($tab_id, $parent_page_id = false){
		if( isset($parent_page_id) ){
			$this->parent_page = new Page( $parent_page_id );
			$this->parent_page->add_tabs( array( $this, 'tab' ) ); 
		}
		$this->parent_page_id = $parent_page_id;
		$this->tab_id = $tab_id;
		add_action( 'admin_enqueue_scripts', array($this, 'adminEnqueue'), 30 );
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
	public function adminEnqueue(){
		if( isset($_GET['page']) && $_GET['page'] == $this->parent_page_id ){
			$this->enqueue();
		}
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Tab Settings
	 *
	 * Define the tab settings.
	 *
	 * @return array 
	 */
	public function settings(){
		return array();
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * tab settings
	 *
	 * Define the tab settings. To not be used. Use 'settings()' instead
	 *
	 * @return array The final settings 
	 */
	public function getSettings(){
		return wp_parse_args( 
			array( 
				'id' => $this->tab_id, 
				'callback' => array( $this, 'page' ) 
			), 
			$this->settings()
		);
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Tab content page
	 *
	 * This is what the tab should display
	 *
	 * @return array The final settings 
	 */
	public function page(){
		_e('Congrats! you\'ve created a new page tab.', 'WPAP');
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Tab filter
	 *
	 * Add this tab to the list of tabs
	 *
	 * @return array All tabs 
	 */
	public function tab($tabs){
		$tabs[] = $this->getSettings();
		return $tabs;
	}

}