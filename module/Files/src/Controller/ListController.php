<?php 
namespace Files\Controller;

use Files\Model\FilesRepositoryInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use InvalidArgumentException;

class ListController extends AbstractActionController
{
	private $filesRepository;

	public function __construct(FilesRepositoryInterface $filesRepository)
    {
        $this->filesRepository = $filesRepository;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->filesRepository->findAllPosts(),
        ]);
    }

    public function detailAction()
    {
    	$id = $this->params()->fromRoute('id');
    	try {
	        $post = $this->filesRepository->findPost($id);
	    } catch (\InvalidArgumentException $ex) {
	        return $this->redirect()->toRoute('files');
	    }

	    return new ViewModel([
	        'post' => $post,
	    ]);
    }

}