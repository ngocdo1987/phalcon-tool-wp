<?php
use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter("auth");
    }

	public function registerAction()
	{
		$this->view->mt = 'Register';
	}

	public function loginAction()
	{
		if($this->request->isPost())
		{
			// Get the data from the user
            $email    = $this->request->getPost("email");
            $password = $this->request->getPost("password");

            // Find the user in the database
            $user = Users::findFirst(
                [
                    "(email = :email: OR username = :email:) AND password = :password:",
                    "bind" => [
                        "email"    => $email,
                        "password" => md5($password),
                    ]
                ]
            );

            if ($user !== false) {
            	
            }

            $this->flash->error(
                "Wrong email/password"
            );
		}

		$this->view->mt = 'Login';
	}

	
}