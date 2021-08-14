<?php 
namespace User\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use User\Controller\IndexController;
use User\Model\User;
use User\Form\UserForm;

class IndexControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $formManager = $container->get('FormElementManager');
        return new IndexController(
            $container->get(User::class),
            $formManager->get(UserForm::class)
        );
    }
}