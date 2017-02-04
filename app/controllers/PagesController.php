<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PagesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for pages
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Pages', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $pages = Pages::find($parameters);
        if (count($pages) == 0) {
            $this->flash->notice("The search did not find any pages");

            $this->dispatcher->forward([
                "controller" => "pages",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $pages,
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
     * Edits a page
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $page = Pages::findFirstByid($id);
            if (!$page) {
                $this->flash->error("page was not found");

                $this->dispatcher->forward([
                    'controller' => "pages",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $page->id;

            $this->tag->setDefault("id", $page->getId());
            $this->tag->setDefault("page_title", $page->getPageTitle());
            $this->tag->setDefault("page_slug", $page->getPageSlug());
            $this->tag->setDefault("page_image", $page->getPageImage());
            $this->tag->setDefault("page_content", $page->getPageContent());
            $this->tag->setDefault("page_status", $page->getPageStatus());
            $this->tag->setDefault("page_mt", $page->getPageMt());
            $this->tag->setDefault("page_md", $page->getPageMd());
            $this->tag->setDefault("page_mk", $page->getPageMk());
            $this->tag->setDefault("created_at", $page->getCreatedAt());
            $this->tag->setDefault("updated_at", $page->getUpdatedAt());
            
        }
    }

    /**
     * Creates a new page
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'index'
            ]);

            return;
        }

        $page = new Pages();
        $page->setPageTitle($this->request->getPost("page_title"));
        $page->setPageSlug($this->request->getPost("page_slug"));
        $page->setPageImage($this->request->getPost("page_image"));
        $page->setPageContent($this->request->getPost("page_content"));
        $page->setPageStatus($this->request->getPost("page_status"));
        $page->setPageMt($this->request->getPost("page_mt"));
        $page->setPageMd($this->request->getPost("page_md"));
        $page->setPageMk($this->request->getPost("page_mk"));
        $page->setCreatedAt($this->request->getPost("created_at"));
        $page->setUpdatedAt($this->request->getPost("updated_at"));
        

        if (!$page->save()) {
            foreach ($page->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("page was created successfully");

        $this->dispatcher->forward([
            'controller' => "pages",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a page edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $page = Pages::findFirstByid($id);

        if (!$page) {
            $this->flash->error("page does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'index'
            ]);

            return;
        }

        $page->setPageTitle($this->request->getPost("page_title"));
        $page->setPageSlug($this->request->getPost("page_slug"));
        $page->setPageImage($this->request->getPost("page_image"));
        $page->setPageContent($this->request->getPost("page_content"));
        $page->setPageStatus($this->request->getPost("page_status"));
        $page->setPageMt($this->request->getPost("page_mt"));
        $page->setPageMd($this->request->getPost("page_md"));
        $page->setPageMk($this->request->getPost("page_mk"));
        $page->setCreatedAt($this->request->getPost("created_at"));
        $page->setUpdatedAt($this->request->getPost("updated_at"));
        

        if (!$page->save()) {

            foreach ($page->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'edit',
                'params' => [$page->id]
            ]);

            return;
        }

        $this->flash->success("page was updated successfully");

        $this->dispatcher->forward([
            'controller' => "pages",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a page
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $page = Pages::findFirstByid($id);
        if (!$page) {
            $this->flash->error("page was not found");

            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'index'
            ]);

            return;
        }

        if (!$page->delete()) {

            foreach ($page->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "pages",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("page was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "pages",
            'action' => "index"
        ]);
    }

}
