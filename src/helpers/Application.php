<?
namespace Mercury\Helper;

use \Pimple\Container;
use Mercury\Helper\Core;
use Mercury\Helper\Database;
use Mercury\Helper\View;
use Mercury\Helper\Router;

/**
*
*/
class Application extends Core {

	private $di;

	function __construct() {

		// Start the session if not already started
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		// IMPORTANT!!!
		parent::__construct();

		// Set the custom error handler
		$this->seterrorhandler();

		// Initialize the DI container
		$this->di = new Container();

		// Set the empty config container
		$this->di['config'] = function() {
			return [];
		};

		// Set the current instance of app to di
		$this->di['app'] = $this;

		$this->initconfig();
		$this->initdb();
		$this->initroute();
		$this->initview();
	}


	function __destruct() {
		session_write_close();
	}

	/**
	 * Lets do this until I find a better way
	 * If needed this method can be extended from any controller/model
	 * to implement custom error handlers
	 * @return none
	 */
	public function seterrorhandler() {
		new ErrorHandler();
	}

	/**
	 * Set any custom configuration to DI
	 * @param string $ps_type 	Identifier for the custom configuration, this can be anything
	 * @param mixed $pm_value 	Value to store agains the identifier
	 * @return boolean
	 */
	public function setconfig($ps_type, $pm_value) {

		$this->di['config'] = $this->di->extend('config', function($po_config) use ($ps_type, $pm_value) {

			$po_config->setconfig($ps_type, $pm_value);

			return $po_config;
		});

		return true;
	}


	/**
	 * Set any current page to DI
	 * @param  mixed    $po_page 	The page object
	 * @return boolean
	 */
	public function setcurrentpage($po_page) {

		$this->di['currentpage'] = $po_page;

		return true;
	}


	private function initdb() {

		$this->di['database'] = function($di) {

			$lo_database = new Database($di);

			return $lo_database;
		};

		return true;
	}


	private function initroute() {

		$this->di['router'] = function($di) {

			$lo_router = new Router($di);

			return $lo_router;
		};

		return true;
	}


	private function initview() {

		$di = $this->di;

		$this->di['view'] = function() use($di) {

			$lo_view = new View($di);

			return $lo_view;
		};

		return true;
	}


	private function initconfig() {

		$di = $this->di;

		$this->di['config'] = function() use($di) {

			$lo_config = new Configuration($di);

			return $lo_config;
		};
	}


	public function runapp() {

		// Get the url part and check if its admin or site
		$ls_type = $this->geturlparameter(0);

		switch($ls_type) {

			case 'admin':
				$this->runadmin();
			break;

			default:
				$this->runsite();
			break;
		}
	}

	public function runadmin() {

		// Get the route object from DI container
		$lo_router = isset($this->di['router']) ? $this->di['router'] : null;

		// Set the admin routes
		$lo_router->setadminroutes();

		// Execute the route
		$la_params = $lo_router->executeroute();

		if ($la_params === false) {

			// here you can handle 404
			$this->showerrorpage(404);

			return false;
		}

		// Get the page from route
		$po_page = $lo_router->getadminpage();

		// Set this page in DI so we can use this other places
		$this->setcurrentpage($po_page);

		// Execute the page
		$this->executeadminpage($po_page, $la_params);
	}

	public function runsite($ps_route = null, $pb_internalrouting = false) {

		// Get the route object from DI container
		$lo_router = isset($this->di['router']) ? $this->di['router'] : null;

		// Set the site routes
		if(!$pb_internalrouting)
			$lo_router->setsiteroutes();

		// Execute the route
		$la_params = $lo_router->executeroute($ps_route);

		if ($la_params === false) {

			// Show the error page
			$this->showerrorpage(404);

			return false;
		}

		// Get the page from route
		$po_page = $lo_router->getpage();

		// Set this page in DI so we can use this other places
		if(!$pb_internalrouting)
			$this->setcurrentpage($po_page);

		// Execute the page
		$this->executesitepage($po_page, $la_params, $pb_internalrouting);
	}


	public function install() {

		/* Implement */

	}

	private function executeadminpage($po_page, $pa_params) {

		if(!is_object($po_page))
			trigger_error("Invalid page", E_USER_NOTICE);


		$ps_controller = $po_page->controller;
		$ps_action = $po_page->action;

		// Build the namespaced class and action of it
		$ps_class = "Mercury\\Controller\\{$ps_controller}Controller";
		$ps_method = "{$ps_action}Action";

		if (is_callable(array($ps_class, $ps_method))) {

			// Init the controller
			$lo_controller = new $ps_class($this->di);

			// Call the action
			call_user_func_array(array($lo_controller, $ps_method), $pa_params);

			// Get view object from DI
			$lo_view = isset($this->di['view']) ? $this->di['view'] : null;

			// Render the page
			$lo_view->renderpage($po_page);

		} else {
			// Throw an exception in debug, send a 500 error in production
			trigger_error("Trying to call $ps_class::$ps_action with no luck", E_USER_NOTICE);

			// Show the error page
			// $this->showerrorpage(500);
		}
	}


	private function executesitepage($po_page, $pa_params, $pb_internalrouting = false) {

		if(!is_object($po_page))
			trigger_error("Invalid page", E_USER_NOTICE);

		$ps_controller = $po_page->controller;
		$ps_action = $po_page->action;
		$ps_module = $po_page->module;

		// Build the namespaced class and action of it
		$ps_class = "Mercury\\App\\{$ps_module}\\Controllers\\{$ps_controller}Controller";
		$ps_method = "{$ps_action}Action";

		if (is_callable(array($ps_class, $ps_method))) {

			// Init the controller
			$lo_controller = new $ps_class($this->di);

			// Call the action
			call_user_func_array(array($lo_controller, $ps_method), $pa_params);

			// Stop here if its internal routing else the page will be rendered 2wise
			if($pb_internalrouting)
				return true;

			// Get view object from DI
			$lo_view = isset($this->di['view']) ? $this->di['view'] : null;

			// Render the page
			$lo_view->renderpage($po_page);

		} else {
			// Throw an exception in debug, send a  500 error in production
			trigger_error("Trying to call $ps_class::$ps_action with no luck", E_USER_NOTICE);
		}
	}
}