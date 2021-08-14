<?php 
namespace Files\Factory;

use Interop\Container\ContainerInterface;
use Files\Model\FilesCommand;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class FilesCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FilesCommand($container->get(AdapterInterface::class));
    }
}