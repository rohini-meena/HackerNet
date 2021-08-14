<?php 
namespace User\Factory;

use Interop\Container\ContainerInterface;
use User\Model\User;
use User\Model\Entity;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new User(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator(),
            new Entity('', '','', 1)
        );
    }
}