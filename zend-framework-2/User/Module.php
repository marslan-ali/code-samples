<?php
namespace User;

use User\Model\User;
use User\Model\UserTable;

use User\Model\Account;
use User\Model\AccountTable;

use User\Model\AccountAddress;
use User\Model\AccountAddressTable;

use User\Model\Login;
use User\Model\LoginTable;

use User\Form\RegisterFilter;
use User\Form\AccountFilter;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader'=>array(
              __DIR__.'/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader'=>array(
                'namespaces'=>array(__NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__),
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
                'User\Model\UserTable'=>function($sm)
                {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $resultsetPrototype = new ResultSet();
                    $resultsetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('user',$dbAdapter,null,$resultsetPrototype);
                },
                'User\Model\AccountTable'=>function($sm)
                {
                    $tableGateway = $sm->get('AccountTableGateway');
                    $table = new AccountTable($tableGateway);
                    return $table;
                },
                'AccountTableGateway'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $resultsetPrototype = new ResultSet();
                    $resultsetPrototype->setArrayObjectPrototype(new Account());
                    return new TableGateway('cw_account',$dbAdapter,null,$resultsetPrototype);
                },
                'User\Model\AccountAddressTable'=>function($sm)
                {
                    $tableGateway = $sm->get('AccountAddressTableGateway');
                    $table = new AccountAddressTable($tableGateway);
                    return $table;
                },
                'AccountAddressTableGateway'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $resultsetPrototype = new ResultSet();
                    $resultsetPrototype->setArrayObjectPrototype(new AccountAddress());
                    return new TableGateway('cw_account_address',$dbAdapter,null,$resultsetPrototype);
                },
                'User\Model\LoginTable'=>function($sm)
                {
                    $tableGateway = $sm->get('LoginTableGateway');
                    $table = new LoginTable($tableGateway);
                    return $table;
                },
                'LoginTableGateway'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $resultsetPrototype = new ResultSet();
                    $resultsetPrototype->setArrayObjectPrototype(new Login());
                    return new TableGateway('cw_login',$dbAdapter,null,$resultsetPrototype);
                },
                'User\Form\RegisterFilter'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $registerFilter = new RegisterFilter($dbAdapter);
                    return $registerFilter;
                },
                'User\Form\AccountFilter'=>function($sm)
                {
                    $dbAdapter = $sm->get('db_conversion');
                    $accountFilter = new AccountFilter($dbAdapter);
                    //$accountFilter = new AccountFilter;
                    return $accountFilter;
                },
                'User\Form\BillingFilter'=>function($sm)
                {
                    $billingFilter = new Form\BillingFilter();
                    return $billingFilter;
                }
            )            
        );
    }
}

