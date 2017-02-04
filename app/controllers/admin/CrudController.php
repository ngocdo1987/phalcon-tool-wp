<?php
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CrudController extends Controller
{
	protected $singular;
	protected $plural;
	protected $config;

    public function initialize()
    {
        $this->view->setTemplateAfter("admin");

        $cfg_file = '../app/config/cms/'.$this->singular.'.json';
        $config = file_exists($cfg_file) ? json_decode(file_get_contents($cfg_file)) : null;

        $this->config = $config;
    }

    public function indexAction()
    {
    	$model_name = ucfirst($this->plural);
    	$model = new $model_name;

    	$numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, $model_name, $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $cruds = $model->find($parameters);
        if (count($cruds) == 0) {
            $this->flash->notice("The search did not find any ".$this->plural);

            $this->dispatcher->forward([
                "controller" => "admin".$this->plural,
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $cruds,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->plural = $this->plural;
        $this->view->config = $this->config;
        $this->view->mt = 'List '.$this->plural;
        $this->view->pick("admin/crud/index");
    }

    public function newAction()
    {
        $this->view->plural = $this->plural;
        $this->view->config = $this->config;
        $this->view->mt = 'Add '.$this->singular;
        $this->view->pick("admin/crud/new");
	}

	public function editAction($id)
    {
    	if (!$this->request->isPost()) {
    		$config = $this->config;
    		
    		$model_name = ucfirst($this->plural);
    		$model = new $model_name;

    		$crud = $model->findFirstByid($id);
            if (!$crud) {
                $this->flash->error(ucfirst($this->singular)." was not found");

                $this->dispatcher->forward([
                    'controller' => "admin".$this->plural,
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $crud->id;

            $this->tag->setDefault("id", $crud->id);
            if(isset($config->cols) && count($config->cols) > 0)
            {
                foreach($config->cols as $k => $v)
                {
                    $this->tag->setDefault($k, $crud->$k);
                }
            }
    	}
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'index'
            ]);

            return;
        }

        $config = $this->config;
        $model_name = ucfirst($this->plural);
        $model = new $model_name;

        if(isset($config->cols) && count($config->cols) > 0)
        {
            foreach($config->cols as $k => $v)
            {
                $model->$k = $this->request->getPost($k);
            }
        }        

        if (!$model->save()) {
            foreach ($model->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success(ucfirst($this->singular)." was created successfully");

        $this->dispatcher->forward([
            'controller' => "admin".$this->plural,
            'action' => 'index'
        ]);
    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $model_name = ucfirst($this->plural);
        $model = new $model_name;
        $crud = $model->findFirstByid($id);

        if (!$crud) {
            $this->flash->error(ucfirst($this->singular)." does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'index'
            ]);

            return;
        }

        $config = $this->config;
        if(isset($config->cols) && count($config->cols) > 0)
        {
            foreach($config->cols as $k => $v)
            {
                $crud->$k = $this->request->getPost($k);
            }
        }

        if (!$crud->save()) {
            foreach ($crud->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'edit',
                'params' => [$crud->id]
            ]);

            return;
        }

        $this->flash->success(ucfirst($this->singular)." was updated successfully");

        $this->dispatcher->forward([
            'controller' => "admin".$this->plural,
            'action' => 'index'
        ]);
    }

    public function deleteAction($id)
    {
        $model_name = ucfirst($this->plural);
        $model = new $model_name;
        $crud = $model->findFirstByid($id);
        if (!$crud) {
            $this->flash->error(ucfirst($this->singular)." was not found");

            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'index'
            ]);

            return;
        }

        if (!$crud->delete()) {

            foreach ($crud->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "admin".$this->plural,
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success(ucfirst($this->singular)." was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "admin".$this->plural,
            'action' => "index"
        ]);
    }
}