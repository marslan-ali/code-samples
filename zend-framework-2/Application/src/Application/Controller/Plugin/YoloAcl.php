<?php
namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource,
    Zend\Authentication\AuthenticationService;    
    
class YoloAcl extends AbstractPlugin
{
    
    public function doAuthorization($e)
    {
        $auth = new AuthenticationService;
        $identity = $auth->getIdentity();
        
        $allowedActions = array('login','register','logout');
        $allowedRouterName = array('home');
        
        if(!$auth->hasIdentity())
        {
            $routerName = $e->getRouteMatch()->getMatchedRouteName();
            $actionName = $e->getRouteMatch()->getParam('action');
            
            if(in_array($actionName, $allowedActions) || in_array($routerName, $allowedRouterName))
            {
                
            }
            else
            {
                $router = $e->getRouter();
                $url    = $router->assemble(array('action'=>'login'), array('name' => 'user'));
                $response = $e->getResponse();
                $response->setStatusCode(302);
                //redirect to login route...
                $response->getHeaders()->addHeaderLine('Location', $url);            
            }
        }
        /*
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $namespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        print_r($e->getRouteMatch()->getParam('action'));
        print_r($e->getRouteMatch()->getMatchedRouteName());
         * 
         */
        
         /*
        //setting ACL...
        $acl = new Acl();
        //add role ..
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
        
        $acl->addResource(new Resource('Experience'));
        $acl->addResource(new Resource('Application'));
        $acl->addResource(new Resource('Users'));
        
        $acl->deny('anonymous', 'Experience');
        $acl->deny('anonymous', 'Application');
        $acl->deny('anonymous', 'Users');
        
        
        
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $namespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        $role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
        if ( ! $acl->isAllowed($role, $namespace, 'view')){
            $router = $e->getRouter();
            $url    = $router->assemble(array(), array('name' => 'discover'));
        
            $response = $e->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            $response->getHeaders()->addHeaderLine('Location', $url);            
        }
         * 
         */
    }
}

?>
