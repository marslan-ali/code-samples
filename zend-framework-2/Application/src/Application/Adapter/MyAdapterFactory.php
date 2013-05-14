<?php
namespace Application\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class MyAdapterFactory implements FactoryInterface
{
    protected $configKeys;
    public function __construct($key)
    {
        $this->configKeys = $key;
    }
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new Adapter($config[$this->configKeys]);
    }
}
