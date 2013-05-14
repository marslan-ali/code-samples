<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use User\Model\User;
use User\Model\UserTable;
use User\Model\RegisterTable;
use User\Form\LoginForm;
use User\Form\RegisterForm;
use User\Form\RegisterFilter;
use User\Form\AccountFilter;

use User\Authentication\BcryptDbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use User\Model\Account;
use User\Model\AccountTable;
use User\Model\AccountAddress;
use User\Model\AccountAddressTable;
use User\Model\Login;
use User\Model\LoginTable;
use Project\Model\Project;
use Project\Model\ProjectTable;
use Project\Model\ProjectSite;
use Project\Model\ProjectSiteTable;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    /**
     *
     * @var UserTable
     */
    protected $userTable;

    /**
     *
     * @var RegisterForm
     */
    protected $accountForm;

    /**
     *
     * @var AccountTable
     */
    protected $accountTable;

    /**
     *
     * @var AccountAddress
     */
    protected $accountAddressTable;

    /**
     *
     * @var LoginTable 
     */
    protected $loginTable;

    /**
     *
     * @var ProjectTable 
     */
    protected $projectTable;

    /**
     *
     * @var ProjectSiteTable 
     */
    protected $projectSiteTable;

    public function indexAction()
    {
        return new ViewModel(array(
                    'albums' => $this->getAlbumTable()->fetchAll()
                ));
    }

    public function loginAction()
    {
        $registerForm = new RegisterForm;
        $form = new LoginForm();
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $user = new User();
            $form->setInputFilter($user->getInputFilter());

            $form->setValidationGroup(array('email', 'password'));

            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $sm = $this->getServiceLocator();
                $adapter = $sm->get('db_conversion');
                $authAdapter = new AuthAdapter($adapter, 'cw_login', 'email', 'password');

                $authAdapter->setIdentity($form->getInputFilter()->getValue('email'))
                        ->setCredential($form->getInputFilter()->getValue('password'));

                $auth = new AuthenticationService();
                $result = $auth->authenticate($authAdapter);

                if ($result->isValid())
                {
                    $data = $authAdapter->getResultRowObject(null, 'password');
                    $auth->getStorage()->write($data);
                    $projects = $this->getProjectTable()->getUserProjects($data->account_id);
                    if ($projects)
                    {
                        $sites = $this->getProjectSiteTable()->getSites($projects->current()->id);
                        if ($sites)
                        {
                            return $this->redirect()->toRoute('project', array('action' => 'site', 'id' => $sites->current()->id));
                        }
                    }
                    return $this->redirect()->toRoute('user', array('action' => 'private'));
                }
                else
                {
                    $form->get('password')->setMessages(array('Invalid email or password'));
                }
            }
        }
        $viewModel = new ViewModel(array('loginForm' => $form,'registerForm'=>$registerForm));
        return $viewModel->setTemplate('user/user/register.phtml');
    }

    public function registerAction()
    {
        $loginForm = new LoginForm();
        
        $form = new RegisterForm;
        $request = $this->getRequest();

        $form->get('submit')->setValue('Register');
        if ($request->isPost())
        {
            $filter = $this->getServiceLocator()->get('User\Form\RegisterFilter');
            
            $form->setInputFilter($filter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $account = new Account();
                $accountAddress = new AccountAddress();
                $project = new Project();
                $login = new Login;
                $projectSite = new ProjectSite;

                $data = $form->getData();

                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = $data['created_at'];
                $account->exchangeArray($data);
                //$accountAddres->exchangeArray($data);
                $data['account_id'] = $this->getAccountTable()->saveAccount($account);

                $accountAddress->exchangeArray($data);
                $this->getAccountAddressTable()->saveAccountAddress($accountAddress);

                $data['email_canonical'] = $data['email'];
                $data['is_active'] = 0;
                $login->exchangeArray($data);
                $this->getLoginTable()->saveLogin($login);

                $data['name'] = 'default project';

                $project->exchangeArray($data);

                $projectTable = $this->getProjectTable();
                $projectTable->saveProject($project);
                $data['project_id'] = $projectTable->getTableGateway()->getLastInsertValue();

                $projectSite->exchangeArray($data);
                $this->getProjectSiteTable()->saveProjectSite($projectSite);
                return $this->redirect()->toRoute('user', array('action' => 'login'));
                exit;
            }
        }
        return array('registerForm' => $form,'loginForm'=>$loginForm);
    }

    /**
     * user/account
     * show profile details of logged in user
     */
    public function accountAction()
    {
        $auth = new AuthenticationService;
        $identity = $auth->getIdentity();
        $login = $this->getLoginTable()->getLogin($identity->id);

        
        $form = new RegisterForm;
        
        $retypPassword  = new \Zend\Form\Element\Password('retype_password', array('label'=>'Retype Password'));
        $form->add($retypPassword);
        
        //$accountId = new \Zend\Form\Element\Hidden('account_id');
        //$form->add($accountId);
        
       
        //$form->bind($login);
        
        $request = $this->getRequest();

        $form->get('submit')->setValue('Update');
        if ($request->isPost())
        {
            $filter = $this->getServiceLocator()->get('User\Form\AccountFilter');
            
            $form->setInputFilter($filter->getInputFilter());
            $form->setData($request->getPost());

            ////$login->exchangeArray($request->getPost());
            //$form->bind($login);
            
            $form->setValidationGroup(array('email','password','name_first','name_last','retype_password'));
            if ($form->isValid())
            {
                $data = $form->getData();
                $data['id'] = $login->id;
                $data['account_id'] = $login->accountId;
                $login->exchangeArray($data);

                $this->getLoginTable()->saveLogin($login);
                //$accountAddress = $this->getAccountAddressTable()->getByAccountId($login->accountId);
                /*
                $accountAddress->exchangeArray($request->getPost());
                $this->getAccountAddressTable()->saveAccountAddress($accountAddress);
                 * 
                 */
                
                return $this->redirect()->toRoute('user', array('action' => 'account'));
                exit;
            }
        }
        return array('accountForm' => $form);
    }

    public function billingAction()
    {
        

    }
   public function overviewAction()
    {
        

    }
    /**
     * 
     * @return LoginTable
     */
    public function getLoginTable()
    {
        if (!$this->loginTable)
        {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('User\Model\LoginTable');
        }
        return $this->loginTable;
    }

    /**
     * 
     * @return UserTable
     */
    public function getUserTable()
    {
        if (!$this->userTable)
        {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
    }

    /**
     * 
     * @return AccountAddressTable
     */
    public function getAccountAddressTable()
    {
        if (!$this->accountAddressTable)
        {
            $sm = $this->getServiceLocator();
            $this->accountAddressTable = $sm->get('User\Model\AccountAddressTable');
        }
        return $this->accountAddressTable;
    }

    /**
     * 
     * @return AccountTable
     */
    public function getAccountTable()
    {
        if (!$this->accountTable)
        {
            $sm = $this->getServiceLocator();
            $this->accountTable = $sm->get('User\Model\AccountTable');
        }
        return $this->accountTable;
    }

    /**
     * 
     * @return ProjectTable
     */
    public function getProjectTable()
    {
        if (!$this->projectTable)
        {
            $sm = $this->getServiceLocator();
            $this->projectTable = $sm->get('Project\Model\ProjectTable');
        }
        return $this->projectTable;
    }

    public function getProjectSiteTable()
    {
        if (!$this->projectSiteTable)
        {
            $sm = $this->getServiceLocator();
            $this->projectSiteTable = $sm->get('Project\Model\ProjectSiteTable');
        }
        return $this->projectSiteTable;
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService;
        if ($auth->hasIdentity())
        {
            $auth->clearIdentity();
            return $this->redirect()->toRoute('user', array('action' => 'login'));
        }
    }

    public function privateAction()
    {

        $auth = new AuthenticationService;
        if (!$auth->hasIdentity())
        {
            return $this->redirect()->toRoute('user', array('action' => 'login'));
        }
    }

}