<?php
namespace Files\Controller;

use Files\Form\FilesForm;
use Files\Model\Files;
use Files\Model\FilesCommandInterface;
use Files\Model\FilesRepositoryInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class WriteController extends AbstractActionController
{
    /*
        @var FilesRepositoryInterface
    */
    private $repository;

    /**
     * @var FilesCommandInterface
     */
    private $command;

    /**
     * @var FilesForm
     */
    private $form;

    /**
     * @param FilesCommandInterface $command
     * @param FilesForm $form
     */

    public function addAction()
    {
        die("RRRR"); die("RRRR");
        $request   = $this->getRequest();
        $viewModel = new ViewModel(['form' => $this->form]);

        if (! $request->isPost()) {
            return $viewModel;
        }

        die("RRRR");

        $this->form->setData($request->getPost());

        if (! $this->form->isValid()) {
            return $viewModel;
        }

        $post = $this->form->getData();

        try {
            $post = $this->command->insertPost($post);
        } catch (\Exception $ex) {
            // An exception occurred; we may want to log this later and/or
            // report it to the user. For now, we'll just re-throw.
            throw $ex;
        }

        return $this->redirect()->toRoute(
            'files/detail',
            ['id' => $post->getId()]
        );
    }

    public function editAction()
    {
        $request   = $this->getRequest();
        $id = $this->params()->fromRoute('id');

        if (! $id) {
            return $this->redirect()->toRoute('files');
        }

        

        if ($request->isPost()) {

            $this->form->setData($request->getPost());
            if($this->form->isValid()){
                $post = $this->form->getData();
                $this->command->updatePost($post);
            }

            return $this->redirect()->toRoute(
                'files/edit',
                ['id' => $post->getId()]
            );
        }

        try {
            $post = $this->repository->findPost($id);
            $this->form->bind($post);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('files');
        } 

        
        $viewModel = new ViewModel(['form' => $this->form]);
        return $viewModel;

    }

    public function deleteAction()
    {

        $id = $this->params()->fromRoute('id');

        if (! $id) {
            return $this->redirect()->toRoute('files');
        }

        try {
            $post = $this->repository->findPost($id);
            $this->command->deletePost($post);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('files');
        } 

        return $this->redirect()->toRoute('files');

    }
}