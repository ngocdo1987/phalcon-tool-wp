<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CategoriesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for categories
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Categories', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $categories = Categories::find($parameters);
        if (count($categories) == 0) {
            $this->flash->notice("The search did not find any categories");

            $this->dispatcher->forward([
                "controller" => "categories",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $categories,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a categorie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $categorie = Categories::findFirstByid($id);
            if (!$categorie) {
                $this->flash->error("categorie was not found");

                $this->dispatcher->forward([
                    'controller' => "categories",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $categorie->id;

            $this->tag->setDefault("id", $categorie->getId());
            $this->tag->setDefault("category_name", $categorie->getCategoryName());
            $this->tag->setDefault("category_slug", $categorie->getCategorySlug());
            $this->tag->setDefault("category_description", $categorie->getCategoryDescription());
            $this->tag->setDefault("parent_id", $categorie->getParentId());
            $this->tag->setDefault("category_mt", $categorie->getCategoryMt());
            $this->tag->setDefault("category_md", $categorie->getCategoryMd());
            $this->tag->setDefault("category_mk", $categorie->getCategoryMk());
            $this->tag->setDefault("created_at", $categorie->getCreatedAt());
            $this->tag->setDefault("updated_at", $categorie->getUpdatedAt());
            
        }
    }

    /**
     * Creates a new categorie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $categorie = new Categories();
        $categorie->setCategoryName($this->request->getPost("category_name"));
        $categorie->setCategorySlug($this->request->getPost("category_slug"));
        $categorie->setCategoryDescription($this->request->getPost("category_description"));
        $categorie->setParentId($this->request->getPost("parent_id"));
        $categorie->setCategoryMt($this->request->getPost("category_mt"));
        $categorie->setCategoryMd($this->request->getPost("category_md"));
        $categorie->setCategoryMk($this->request->getPost("category_mk"));
        $categorie->setCreatedAt($this->request->getPost("created_at"));
        $categorie->setUpdatedAt($this->request->getPost("updated_at"));
        

        if (!$categorie->save()) {
            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("categorie was created successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a categorie edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $categorie = Categories::findFirstByid($id);

        if (!$categorie) {
            $this->flash->error("categorie does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $categorie->setCategoryName($this->request->getPost("category_name"));
        $categorie->setCategorySlug($this->request->getPost("category_slug"));
        $categorie->setCategoryDescription($this->request->getPost("category_description"));
        $categorie->setParentId($this->request->getPost("parent_id"));
        $categorie->setCategoryMt($this->request->getPost("category_mt"));
        $categorie->setCategoryMd($this->request->getPost("category_md"));
        $categorie->setCategoryMk($this->request->getPost("category_mk"));
        $categorie->setCreatedAt($this->request->getPost("created_at"));
        $categorie->setUpdatedAt($this->request->getPost("updated_at"));
        

        if (!$categorie->save()) {

            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'edit',
                'params' => [$categorie->id]
            ]);

            return;
        }

        $this->flash->success("categorie was updated successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a categorie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $categorie = Categories::findFirstByid($id);
        if (!$categorie) {
            $this->flash->error("categorie was not found");

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        if (!$categorie->delete()) {

            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("categorie was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => "index"
        ]);
    }

}
