<?php 
namespace User\Controller;

use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

use User\Model\User;
use User\Model\Entity;
use User\Form\UserForm;

class IndexController extends AbstractActionController
{
	private $userdb;
	public function __construct(User $userdb, UserForm $form)
	{
		$this->userdb = $userdb;
		$this->form = $form;
	}

	public function indexAction()
	{
		$users = $this->userdb->getAll();
		return new ViewModel([
            'users' => $users->count()?$users->toArray():[],
        ]);
	}
	
	public function addAction()
	{
		$request   = $this->getRequest();		
		$viewModel = new ViewModel(['form' => $this->form]);
		if (! $request->isPost()) {
            return $viewModel;
		}
		
		$this->form->setData($request->getPost());
        if (! $this->form->isValid()) {
            return $viewModel;
        }

		$user = $this->form->getData();
		$this->userdb->create($user);
		return $this->redirect()->toRoute('user');
	}

	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');

        if (! $id) {
            return $this->redirect()->toRoute('user');
        }
		$this->userdb->delete($id);
		return $this->redirect()->toRoute('user');
	}

	public function editAction()
	{	
		$request   = $this->getRequest();
		$id = $this->params()->fromRoute('id');

        if (! $id) {
            return $this->redirect()->toRoute('user');
		}
		
		if ($request->isPost()) {
			$this->form->setData($request->getPost());
			if($this->form->isValid()){
				$user = $this->form->getData();
				$this->userdb->update($user);
				return $this->redirect()->toRoute('user');
			}

		}	
		$user = $this->userdb->get($id);
		$this->form->bind($user);
		return new ViewModel(['form' => $this->form]);
		
	}
	
    public function loginAction()
    {
        $request   = $this->getRequest();		
		if (!$request->isPost()) {
            return $this->redirect()->toRoute('application');
		}
        else {
			$username = $request->getPost('username');
			$password = $request->getPost('password');
            if ($username && $password) {
                $users = $this->userdb->checkLogin($username, $password);
				$users_arr = $users->count()?$users->toArray():[];
				if (!empty($users_arr)) {
					$_SESSION["loggedin_user"] = $users_arr[0]['id'];
					return $this->redirect()->toRoute('user');
				}
            }
        }
		return $this->redirect()->toRoute('application');
    }
}