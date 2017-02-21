<?php
use Phalcon\Mvc\Controller;

class DashboardController extends Controller 
{
	public function initialize()
    {
    	$this->view->setTemplateAfter("admin");
    }

	public function indexAction()
	{
		$this->view->mt = 'Dashboard';
	}
}