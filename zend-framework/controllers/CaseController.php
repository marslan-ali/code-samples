<?php
/**
 * Description of DashboardController
 *
 * @author arslan
 */

/*
 * Case controller 
 */

class CaseController extends Zend_Controller_Action {
    /*
     * predispatch to decide if role is allowed on given resource
     */

    public function preDispatch() {
        $this->view->title = "Case Management";
        $this->view->body_id = '';
        $this->view->headTitle($this->view->title);
        $this->view->jQuery()->enable();

        $acl = new Application_Model_MyAcl();
        /*
         * if user is logged in
         */
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $userDetails = Zend_Auth::getInstance()->getIdentity();
            $this->view->role = $userDetails->role;
            /*
             * if role is allowed on resource
             */
            if ($acl->authorize($userDetails->role, "{$this->view->getControllerName()}:{$this->view->getActionName()}") === false) {
                $this->_redirect("unauthorize/access");
                exit;
            }
        } else {
            $this->_redirect("auth/login");
            exit;
        }
    }

    /*
     * list cases
     */

    public function listAction() {
        $caseModel = new Application_Model_DbTable_Cases();
        $result = $caseModel->fetchAll();

        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result->toArray()));
        $paginator->setItemCountPerPage(10)
                ->setCurrentPageNumber($this->_getParam("page", "1"));

        $this->view->paginator = $paginator;
        $this->view->subTitle = "List all cases";
    }

    /*
     * add case
     */

    public function addAction() {
        /*
         * set subtitle on view
         */
        $this->view->subTitle = "Add Case";
        $options = array("label" => "Add Case", "action" => "");
        $form = new Application_Form_Case($options);

        if ($this->_request->isPost()) {
            /*
             * if form is valid
             */
            if ($form->isValid($this->_request->getPost())) {

                $general = new Application_Model_General();
                /*
                 * create array from posted data
                 */
                $data = array(
                    'case_number' => $form->getValue('caseNumber'),
                    'id_number' => $form->getValue('idNumber'),
                    'name' => $form->getValue('name'),
                    'country' => $form->getValue('country'),
                    'city' => $form->getValue('city'),
                    'telephone' => $form->getValue('telephone'),
                    'email' => $form->getValue('email'),
                    'home_address' => $form->getValue('homeAddress'),
                    'insurance_company' => $form->getValue('insuranceCompany'),
                    'insurance_office' => $form->getValue('insuranceOffice'),
                    'insurance_policy' => $form->getValue('insurancePolicy'),
                    'policy_startdate' => $form->getValue('policyStartDate'),
                    'policy_enddate' => $form->getValue('policyEndDate'),
                    'items' => $form->getValue('item'),
                    'insured_amount' => $form->getValue('insuredAmount'),
                    'prima' => $form->getValue('prima'),
                    'matter_insured' => $form->getValue('matterInsured'),
                    'converage_effected' => $form->getValue('converageEffected'),
                    'copayment' => $form->getValue('payments'),
                    'register_at' => $form->getValue('dateOfRegistration'),
                    'reported_at' => $form->getValue('dateOfReport'),
                    'collected_at' => $form->getValue('dateOfCollection'),
                    'allocated_at' => $form->getValue('dateOfAllocation'),
                    'comments' => $form->getValue('comments')
                );
                $caseModel = new Application_Model_DbTable_Cases();
                /*
                 * insert case
                 */
                $caseModel->insert($data);
                $this->_redirect("case/list");
                exit;
            }
        }

        $this->view->form = $form;
        $this->render("add-edit");
    }

    /*
     * edit case details
     */

    public function editAction() {
        $this->view->subTitle = "Edit Case";
        $id = $this->_getParam("id");
        $caseModel = new Application_Model_DbTable_Cases();
        $caseDetails = $caseModel->fetchRow("id = $id");

        $options = array("label" => "Update Case", "action" => $id);
        $form = new Application_Form_Case($options);
        $form->populate(array("caseNumber" => $caseDetails->case_number, "idNumber" => $caseDetails->id_number, "name" => $caseDetails->name,
            "country" => $caseDetails->country, "city" => $caseDetails->city, "telephone" => $caseDetails->telephone,
            "email" => $caseDetails->email, "homeAddress" => $caseDetails->home_address, "insuranceCompany" => $caseDetails->insurance_company,
            "insuranceOffice" => $caseDetails->insurance_office, "insurancePolicy" => $caseDetails->insurance_policy, "dateOfRegistration" => $caseDetails->register_at,
            "dateOfReport" => $caseDetails->reported_at, "dateOfCollection" => $caseDetails->collected_at, "dateOfAllocation" => $caseDetails->allocated_at,
            "comments" => $caseDetails->comments));


        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $general = new Application_Model_General();
                $data = array(
                    'case_number' => $form->getValue('caseNumber'),
                    'id_number' => $form->getValue('idNumber'),
                    'name' => $form->getValue('name'),
                    'country' => $form->getValue('country'),
                    'city' => $form->getValue('city'),
                    'telephone' => $form->getValue('telephone'),
                    'email' => $form->getValue('email'),
                    'home_address' => $form->getValue('homeAddress'),
                    'insurance_company' => $form->getValue('insuranceCompany'),
                    'insurance_office' => $form->getValue('insuranceOffice'),
                    'insurance_policy' => $form->getValue('insurancePolicy'),
                    'policy_startdate' => $form->getValue('policyStartDate'),
                    'policy_enddate' => $form->getValue('policyEndDate'),
                    'items' => $form->getValue('item'),
                    'insured_amount' => $form->getValue('insuredAmount'),
                    'prima' => $form->getValue('prima'),
                    'matter_insured' => $form->getValue('matterInsured'),
                    'converage_effected' => $form->getValue('converageEffected'),
                    'copayment' => $form->getValue('payments'),
                    'register_at' => $form->getValue('dateOfRegistration'),
                    'reported_at' => $form->getValue('dateOfReport'),
                    'collected_at' => $form->getValue('dateOfCollection'),
                    'allocated_at' => $form->getValue('dateOfAllocation'),
                    'comments' => $form->getValue('comments')
                );

                $caseModel->update($data, "id = $id");
                $this->_redirect("case/list");
                exit;
            }
        }

        $this->view->form = $form;
        $this->render("add-edit");
    }

    /*
     * view case details
     */

    public function viewAction() {
        $id = $this->_getParam("id");
        $this->view->subTitle = "Case Details";
        $caseModel = new Application_Model_DbTable_Cases();
        $caseDetails = $caseModel->fetchRow("id = $id");
        $this->view->caseDetails = $caseDetails;
    }

    /*
     * view all attchments of case
     */

    public function viewAllAttachmentsAction() {

        $this->view->title = "Case - View All Item";
        $caseItemsModel = new Application_Model_DbTable_CaseItem();

        $caseId = $this->_getParam("id");
        $caseItems = $caseItemsModel->fetchAll("case_id = $caseId");
        $this->view->caseItems = $caseItems;
    }

    /*
     * list unassigned cases
     */

    public function unassignedCasesAction() {
        $caseModel = new Application_Model_DbTable_Cases();
        $result = $caseModel->fetchAll("assigned_to is null or assigned_to = ''");

        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result->toArray()));
        $paginator->setItemCountPerPage(10)
                ->setCurrentPageNumber($this->_getParam("page", "1"));

        $this->view->paginator = $paginator;
        $this->view->subTitle = "List all unassigned cases";
    }

    /*
     * assign case to inspector
     */

    public function assignToInspectorAction() {
        $id = $this->_getParam("id"); // its case id
        $inspectorId = $this->_getParam("page");
        $caseModel = new Application_Model_DbTable_Cases();
        $userModel = new Application_Model_DbTable_Users();
        $caseDetails = $caseModel->find($id);
        $inspectorUsers = $userModel->fetchAll("role = 'Inspector'");
        if (!empty($inspectorId)) {
            $caseDetails = $caseDetails[0];
            $caseDetails->assigned_to = $inspectorId;
            $caseDetails->status = 'Assigned';
            $caseDetails->save();
            $this->_redirect("case/unassigned-cases");
            exit;
            //$userDetail->
        }
        $adapter = Zend_Db_Table::getDefaultAdapter();
        $select = new Zend_Db_Select($adapter);
        $select->from("users", array("users.id", "users.name"))
                ->joinLeft("cases", "users.id = cases.assigned_to", new Zend_Db_Expr("count(assigned_to) as cnt"))
                ->where("role = 'Inspector'")
                ->group("users.id");
        $result = $select->query()->fetchAll();

        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($result));
        $paginator->setItemCountPerPage(10)
                ->setCurrentPageNumber($this->_getParam("page", "1"));

        $this->view->paginator = $paginator;
        $this->view->subTitle = "Assign To Inspector";
        $this->view->title = "Case Number - " . $caseDetails[0]['case_number'];
        $this->view->caseId = $id;
    }

}

?>