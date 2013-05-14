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

use User\Form\BillingForm;
use User\Form\BillingFilter;
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

use Project\Model\Credit;
use User\Model;

class BillingController extends AbstractActionController
{
   
   protected $accountTable;
   protected $accountAddressTable;
   protected $projectTable;
   protected $projectSiteTable;
   protected $creditTable;
   protected $planTable;


   public function overviewAction()
    {
        $auth = new AuthenticationService;
        if (!$auth->hasIdentity())
        {
             return $this->redirect()->toRoute('user', array('action' => 'login'));
        }
        else
        {
           $accountId = $auth->getIdentity()->account_id;
           $accountAddress = $this->getAccountAddressTable()->getByAccountAddressById($accountId);
           $projects = $this->getProjectTable()->getUserProjects($accountId);
           
           $sites = array();
           foreach($projects as $project)
           {
                $sites[] = $this->getCreditTable()->getAllSiteCredits($project->id);
           }
           return array('sites'=>$sites, 'accountAddress' => $accountAddress, 'projects' => $projects);
        }
    }

    public function detailAction()
    {

        $auth = new AuthenticationService;
        if (!$auth->hasIdentity())
        {
             return $this->redirect()->toRoute('user', array('action' => 'login'));
        }
        else
        {
            $id = $auth->getIdentity()->account_id;
            $address = $this->getAccountAddressTable()->getByAccountAddressById($id);

            $form = new BillingForm;
            $form->bind($address);
            //$form->get('id')->setValue($address->id);
            $form->get('submit')->setValue('Save Changes');

            $request = $this->getRequest();
            if ($request->isPost())
            {
                $filter = $this->getServiceLocator()->get('User\Form\BillingFilter');
                $form->setInputFilter($filter->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid())
                {
                    $this->getAccountAddressTable()->saveAccountAddress($form->getData());
                    return $this->redirect()->toRoute('billing', array('action' => 'overview'));
                }
            }
        }
        return array('detailForm' => $form, 'address'=>$address);
    }
    
    public function buyCreditsAction()
    {
        $auth = new AuthenticationService;
        if (!$auth->hasIdentity())
        {
             return $this->redirect()->toRoute('user', array('action' => 'login'));
        }
        else
        {
            $siteId = $this->params()->fromRoute('id') ;
            $accountId = $auth->getIdentity()->account_id;
            $address = $this->getAccountAddressTable()->getByAccountAddressById($accountId);
            /** @todo improve code for getting all user sites **/
            $projects = $this->getProjectTable()->getUserProjects($accountId);

            $credit = $this->getCreditTable()->getCredit($siteId);
            foreach($projects as $project)
            {
                 $sites[] = $this->getProjectSiteTable()->getSites($project->id);
            }
            /** for showing invoice form **/
            $form = new BillingForm;
            $form->bind($address);
            $form->get('submit')->setValue('Sign up plan');
            
            $request = $this->getRequest();
            if($request->isPost())
            {
                if(empty($credit))
                {
                    $credit = new Credit;
                    $credit->siteId = $siteId;
                    $credit->planExpire = date('Y-m-d');
                    $credit->creditsLeft = 0;
                }
                $filter = $this->getServiceLocator()->get('User\Form\BillingFilter');
                $form->setInputFilter($filter->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid())
                {
                    $planId = $request->getPost()->plan_id;
                    $plan = $this->getPlanTable()->getPlan($planId);
                    $credit->planId = $planId;
                    $credit->creditsLeft = $credit->creditsLeft + $plan->credits;
                    
                    $this->getCreditTable()->saveCredit($credit);
                    $this->getAccountAddressTable()->saveAccountAddress($form->getData());
                    return $this->redirect()->toRoute('billing', array('action' => 'overview'));
                }
                
            }
           
            return array('sites'=>$sites,'form'=>$form,'siteId'=>$siteId,'credit'=>$credit);
        }
    }

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

    public function getCreditTable()
    {
        if (!$this->creditTable)
        {
            $sm = $this->getServiceLocator();
            $this->creditTable = $sm->get('Project\Model\CreditTable');
        }
        return $this->creditTable;
    }
    
    public function getPlanTable()
    {
        if(!$this->planTable)
        {
            $this->planTable = $this->getServiceLocator()->get('Project\Model\PlanTable');
        }
        return $this->planTable;
    }
}