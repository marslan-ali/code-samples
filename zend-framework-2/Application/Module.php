<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Adapter\MyAdapterFactory;
use Application\Controller\Plugin\YoloAcl;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ServiceProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch', array($this, 'loadConfiguration'), 2);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function loadConfiguration(MvcEvent $e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();

        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) use ($sm)
                {
                    $sm->get('ControllerPluginManager')->get('YoloAcl')
                            ->doAuthorization($e); //pass to the plugin...    
                }
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'leftWidget' => function ($serviceManager)
                {
                    $siteTable = $serviceManager->getServiceLocator()->get('Project\Model\ProjectSiteTable');
                    $projectTable = $serviceManager->getServiceLocator()->get('Project\Model\ProjectTable');
                    $campaignTable = $serviceManager->getServiceLocator()->get('Campaign\Model\CampaignTable');
                    // Get the Meteo Service
                    return new \Application\View\Helper\LeftMenuWidget($siteTable, $projectTable, $campaignTable);
                },
                'ControllerName' => function ($serviceManager)
                {
                    $match = $serviceManager->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
                    $viewHelper = new \Application\View\Helper\ControllerName($match);
                    return $viewHelper;
                },
                'ActionName' => function ($serviceManager)
                {
                    $match = $serviceManager->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
                    $viewHelper = new \Application\View\Helper\ActionName($match);
                    return $viewHelper;
                }                
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'db_conversion' => new MyAdapterFactory('db'),
                'db_module_voucher' => new MyAdapterFactory('db_voucher'),
                'YoloAcl'=>function ($serviceManager)
                {
                    return new YoloAcl();
                }
           ),
        );
    }

}
