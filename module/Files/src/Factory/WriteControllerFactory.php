<?php
namespace Files\Factory;

use Files\Controller\WriteController;
use Files\Form\FilesForm;
use Files\Model\FilesCommandInterface;
use Files\Model\FilesRepositoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class WriteControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return WriteController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        return new WriteController(
            $container->get(FilesCommandInterface::class),
            $formManager->get(FilesForm::class),
            $container->get(FilesRepositoryInterface::class)
        );
    }
}