<?
namespace Mercury\Controller;

use Mercury\Model\PageModel;
use Mercury\Model\RouteModel;
use Mercury\Model\ModuleModel;

class PagesController extends BaseController {


	public function initcontroller() {

		$this->pagemodel = new PageModel($this->di);
		$this->routemodel = new RouteModel($this->di);
		$this->modulemodel = new ModuleModel($this->di);
	}

	public function controllersAction() {

		$this->setview('pages');

		// Get the controllers
		$la_pages = $this->pagemodel->getpages('CONTROLLER');

		$this->buildresponse(['la_pages' => $la_pages]);
		$this->buildresponse(['ls_pagetitle' => 'Controller']);
		$this->buildresponse(['ls_addurl' => '/admin/controller/add']);
		$this->buildresponse(['ls_editurl' => '/admin/controller/edit']);

	}

	public function controllerAction($ps_action, $pi_id = null) {

		switch($ps_action) {

			case 'add':

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'CONTROLLER';
					$_POST['__created'] = date('Y-m-d H:i:s');

					$this->pagemodel->commitaddfrompost();

					// Create the file
					if($this->postvalue('__core'))
						$ls_file = $this->getdocumentroot() . '/mercury/controllers/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';
					else
						$ls_file = $this->getdocumentroot() . '/application/controllers/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';

					$this->createfile($ls_file);

					// Redirect
					$this->redirect('/admin/controller');
				}

				// Add needs a special view
				$this->setview('addpage');

				$this->buildresponse(['ls_actionurl' => '/admin/controller/add']);

			break;

			case 'edit':

				// Get the models
				$lo_page = $this->pagemodel->getrow(['type' => 'CONTROLLER', 'pageid' => $pi_id]);

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'CONTROLLER';

					$this->pagemodel->commitupdatefrompost('pageid', $pi_id);

					// Create the file
					if($this->postvalue('__core')) {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/controllers/' . ucfirst(strtolower($lo_page->name)) . 'Controller.php';
						$ls_newfile = $this->getdocumentroot() . '/mercury/controllers/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';
					} else {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/controllers/' . ucfirst(strtolower($lo_page->name)) . 'Controller.php';
						$ls_newfile = $this->getdocumentroot() . '/application/controllers/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';
					}

					$this->renamefile($ls_originalfile, $ls_newfile);

					// Redirect
					$this->redirect('/admin/controllers');
				}

				$this->setview('page');
				$this->buildresponse(['ls_actionurl' => '/admin/controller/edit/' . $pi_id]);
				$this->buildresponse(['lo_page' => $lo_page]);

			break;
		}

		// Init placeholders
		$la_modules = [];

		// Get all modules
		$la_rawmodules = $this->modulemodel->getrows();
		foreach($la_rawmodules as $lo_item) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_item->moduleid;
			$lo_row->label = $lo_item->name;

			$la_modules[] = $lo_row;
		}
		$this->buildresponse(['pa_modules' => $la_modules]);

		$this->buildresponse(['ls_pagetitle' => 'Controller']);
	}

	public function modelsAction() {

		$this->setview('pages');

		// Get the models
		$la_pages = $this->pagemodel->getpages('MODEL');

		$this->buildresponse(['la_pages' => $la_pages]);
		$this->buildresponse(['ls_pagetitle' => 'Model']);
		$this->buildresponse(['ls_addurl' => '/admin/model/add']);
		$this->buildresponse(['ls_editurl' => '/admin/model/edit']);

	}

	public function modelAction($ps_action, $pi_id = null) {

		switch($ps_action) {

			case 'add':

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'MODEL';
					$_POST['__created'] = date('Y-m-d H:i:s');

					$this->pagemodel->commitaddfrompost();

					// Create the file
					if($this->postvalue('__core'))
						$ls_file = $this->getdocumentroot() . '/mercury/models/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';
					else
						$ls_file = $this->getdocumentroot() . '/application/models/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Controller.php';

					$this->createfile($ls_file);

					// Redirect
					$this->redirect('/admin/models');
				}

				// Add needs a special view
				$this->setview('addpage');

				$this->buildresponse(['ls_actionurl' => '/admin/model/add']);

			break;

			case 'edit':

				// Get the model
				$lo_page = $this->pagemodel->getrow(['type' => 'MODEL', 'pageid' => $pi_id]);

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'MODEL';

					$this->pagemodel->commitupdatefrompost('pageid', $pi_id);

					// Create the file
					if($this->postvalue('__core')) {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/models/' . ucfirst(strtolower($lo_page->name)) . 'Model.php';
						$ls_newfile = $this->getdocumentroot() . '/mercury/models/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Model.php';
					} else {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/models/' . ucfirst(strtolower($lo_page->name)) . 'Model.php';
						$ls_newfile = $this->getdocumentroot() . '/application/models/' . ucfirst(strtolower($this->postvalue('__name'))) . 'Model.php';
					}

					$this->renamefile($ls_originalfile, $ls_newfile);

					// Redirect
					$this->redirect('/admin/models');
				}

				$this->setview('page');
				$this->buildresponse(['ls_actionurl' => '/admin/model/edit/' . $pi_id]);
				$this->buildresponse(['lo_page' => $lo_page]);

			break;
		}

		// Init placeholders
		$la_modules = [];

		// Get all modules
		$la_rawmodules = $this->modulemodel->getrows();
		foreach($la_rawmodules as $lo_item) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_item->moduleid;
			$lo_row->label = $lo_item->name;

			$la_modules[] = $lo_row;
		}
		$this->buildresponse(['pa_modules' => $la_modules]);

		$this->buildresponse(['ls_pagetitle' => 'Model']);
	}

	public function viewsAction() {

		// Get the controllers
		$la_pages = $this->pagemodel->getviews();

		$this->buildresponse(['la_pages' => $la_pages]);
		$this->buildresponse(['ls_pagetitle' => 'Views']);
		$this->buildresponse(['ls_addurl' => '/admin/view/add']);
		$this->buildresponse(['ls_editurl' => '/admin/view/edit']);

	}

	public function viewAction($ps_action, $pi_id = null) {

		switch($ps_action) {

			case 'add':

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'VIEW';
					$_POST['__created'] = date('Y-m-d H:i:s');

					$this->pagemodel->commitaddfrompost();

					// Get the controller
					$lo_controller = $this->pagemodel->getrow(['type' => 'CONTROLLER', 'pageid' => $this->postvalue('__controllerid')]);
					$lo_module = $this->pagemodel->getrow(['moduleid' => $this->postvalue('__moduleid')]);

					// Create the file
					if($this->postvalue('__core'))
						$ls_file = $this->getdocumentroot() . '/mercury/views/' . strtolower($lo_controller->name) . '/' . strtolower($this->postvalue('__name')) . '.php';
					else
						$ls_file = $this->getdocumentroot() . '/application/'  . strtolower($lo_module->name) . '/views/' . strtolower($lo_controller->name) . '/' . strtolower($this->postvalue('__name')) . '.php';

					$this->createfile($ls_file);

					// Redirect
					$this->redirect('/admin/views');
				}

				// Add needs a special view
				$this->setview('addview');

				$this->buildresponse(['ls_actionurl' => '/admin/view/add']);

			break;

			case 'edit':

				// Get the view
				$lo_page = $this->pagemodel->getrow(['type' => 'VIEW', 'pageid' => $pi_id]);

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'VIEW';

					$this->pagemodel->commitupdatefrompost('pageid', $pi_id);

					// Get the controller
					$lo_controller = $this->pagemodel->getrow(['type' => 'CONTROLLER', 'pageid' => $this->postvalue('__controllerid')]);
					$lo_module = $this->pagemodel->getrow(['moduleid' => $this->postvalue('__moduleid')]);

					// Create the file
					if($this->postvalue('__core')) {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/views/' . strtolower($lo_controller->name) . '/' . strtolower($lo_page->name) . '.php';
						$ls_newfile = $this->getdocumentroot() . '/mercury/views/' . strtolower($lo_controller->name) . '/' . strtolower($this->postvalue('__name')) . '.php';
					} else {
						$ls_originalfile = $this->getdocumentroot() . '/application/'  . strtolower($lo_module->name) . '/views/' . strtolower($lo_controller->name) . '/'. strtolower($lo_page->name) . '.php';
						$ls_newfile = $this->getdocumentroot() . '/application/' . strtolower($lo_module->name) . '/views/' . strtolower($lo_controller->name) . '/' . strtolower($this->postvalue('__name')) . '.php';
					}

					$this->renamefile($ls_originalfile, $ls_newfile);

					// Redirect
					$this->redirect('/admin/views');
				}

				$this->buildresponse(['ls_actionurl' => '/admin/view/edit/' . $pi_id]);
				$this->buildresponse(['lo_page' => $lo_page]);

			break;
		}

		// Init placeholders
		$la_modules = [];
		$la_controllers = [];

		// Get all modules
		$la_rawmodules = $this->modulemodel->getrows();
		foreach($la_rawmodules as $lo_item) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_item->moduleid;
			$lo_row->label = $lo_item->name;

			$la_modules[] = $lo_row;
		}
		$this->buildresponse(['pa_modules' => $la_modules]);

		// Get all pages
		$la_pages = $this->pagemodel->getrows();
		foreach($la_pages as $lo_page) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_page->pageid;
			$lo_row->label = $lo_page->label;

			if($lo_page->type == 'CONTROLLER')
				$la_controllers[] = $lo_row;
		}
		$this->buildresponse(['pa_controllers' => $la_controllers]);

		$this->buildresponse(['ls_pagetitle' => 'View']);
	}

	public function templatesAction() {

		// Get the controllers
		$la_pages = $this->pagemodel->getviews('TEMPLATE');

		$this->setview('pages');

		$this->buildresponse(['la_pages' => $la_pages]);
		$this->buildresponse(['ls_pagetitle' => 'Templates']);
		$this->buildresponse(['ls_addurl' => '/admin/template/add']);
		$this->buildresponse(['ls_editurl' => '/admin/template/edit']);

	}

	public function templateAction($ps_action, $pi_id = null) {

		switch($ps_action) {

			case 'add':

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'TEMPLATE';
					$_POST['__created'] = date('Y-m-d H:i:s');

					$this->pagemodel->commitaddfrompost();

					// Get the controller
					$lo_module = $this->pagemodel->getrow(['moduleid' => $this->postvalue('__moduleid')]);

					// Create the file
					if($this->postvalue('__core'))
						$ls_file = $this->getdocumentroot() . '/mercury/views/templates/' . strtolower($this->postvalue('__name')) . '.php';
					else
						$ls_file = $this->getdocumentroot() . '/application/'  . strtolower($lo_module->name) . '/views/templates/' . strtolower($this->postvalue('__name')) . '.php';

					$this->createfile($ls_file);

					// Redirect
					$this->redirect('/admin/templates');
				}

				// Add needs a special view
				$this->setview('addpage');

				$this->buildresponse(['ls_actionurl' => '/admin/template/add']);

			break;

			case 'edit':

				// Get the view
				$lo_page = $this->pagemodel->getrow(['type' => 'TEMPLATE', 'pageid' => $pi_id]);

				if (isset($_POST) && !empty($_POST)) {

					// Default values here
					$_POST['__type'] = 'TEMPLATE';

					$this->pagemodel->commitupdatefrompost('pageid', $pi_id);

					// Get the controller
					$lo_module = $this->pagemodel->getrow(['moduleid' => $this->postvalue('__moduleid')]);

					// Create the file
					if($this->postvalue('__core')) {
						$ls_originalfile = $this->getdocumentroot() . '/mercury/views/templates/' . strtolower($lo_page->name) . '.php';
						$ls_newfile = $this->getdocumentroot() . '/mercury/views/templates/' . strtolower($this->postvalue('__name')) . '.php';
					} else {
						$ls_originalfile = $this->getdocumentroot() . '/application/'  . strtolower($lo_module->name) . '/views/templates/'. strtolower($lo_page->name) . '.php';
						$ls_newfile = $this->getdocumentroot() . '/application/' . strtolower($lo_module->name) . '/views/templates/' . strtolower($this->postvalue('__name')) . '.php';
					}

					$this->renamefile($ls_originalfile, $ls_newfile);

					// Redirect
					$this->redirect('/admin/templates');
				}

				$this->setview('page');

				$this->buildresponse(['ls_actionurl' => '/admin/template/edit/' . $pi_id]);
				$this->buildresponse(['lo_page' => $lo_page]);

			break;
		}

		// Init placeholders
		$la_modules = [];
		$la_controllers = [];

		// Get all modules
		$la_rawmodules = $this->modulemodel->getrows();
		foreach($la_rawmodules as $lo_item) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_item->moduleid;
			$lo_row->label = $lo_item->name;

			$la_modules[] = $lo_row;
		}
		$this->buildresponse(['pa_modules' => $la_modules]);

		// Get all pages
		$la_pages = $this->pagemodel->getrows();
		foreach($la_pages as $lo_page) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_page->pageid;
			$lo_row->label = $lo_page->label;

			if($lo_page->type == 'CONTROLLER')
				$la_controllers[] = $lo_row;
		}
		$this->buildresponse(['pa_controllers' => $la_controllers]);

		$this->buildresponse(['ls_pagetitle' => 'View']);
	}

	public function routesAction() {

		// Get the controllers
		$la_routes = $this->routemodel->getrows();

		$this->buildresponse(['la_routes' => $la_routes]);

	}

	public function routeAction($ps_action, $pi_id = null) {

		// Get all pages
		$la_pages = $this->pagemodel->getrows();

		// Get all modules
		$la_rawmodules = $this->modulemodel->getrows();

		// Classify them based on type
		$la_controllers = [];
		$la_modules = [];

		foreach($la_pages as $lo_page) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_page->pageid;
			$lo_row->label = $lo_page->label;

			if($lo_page->type == 'CONTROLLER')
				$la_controllers[] = $lo_row;
		}

		$this->buildresponse(['pa_controllers' => $la_controllers]);

		foreach($la_rawmodules as $lo_item) {

			$lo_row = new \stdClass;
			$lo_row->id = $lo_item->moduleid;
			$lo_row->label = $lo_item->name;

			$la_modules[] = $lo_row;
		}

		$this->buildresponse(['pa_modules' => $la_modules]);

		switch($ps_action) {

			case 'add':

				if(isset($_POST) && !empty($_POST)){

					// Default values here
					$_POST['__created'] = date('Y-m-d H:i:s');

					$this->routemodel->commitaddfrompost();

					// Redirect
					$this->redirect('/admin/routes');
				}

				$this->setview('addroute');

			break;

			case 'edit':

				if(isset($_POST) && !empty($_POST)){

					$this->routemodel->commitupdatefrompost('routeid', $pi_id);

					// Redirect
					$this->redirect('/admin/routes');
				}

				// Get the controllers
				$lo_route = $this->routemodel->getrow(['routeid' => $pi_id]);

				$this->buildresponse(['po_route' => $lo_route]);

			break;
		}
	}

}