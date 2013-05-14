<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	
	private $_model;
        
        public function init()
        {
            //parent::init();
            Yii::app()->theme='backend';
        }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view','deleteconfirm','introduction'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{            
            $this->layout = false;
		$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
             Yii::app()->theme='frontend';
            $this->layout=FALSE;            
		$model=new User;
		$profile=new Profile;
//                print_r($_POST);
//                exit;
		if(isset($_POST['User']))
		{
                    //die('djjdjd');
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$model->createtime=time();
			$model->lastvisit=time();
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{            
            Yii::app()->theme='backend';
            //$this->layout=FALSE;
		$model=$this->loadModel();
		$profile=$model->profile;

                // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'adminupdate-form')
        {
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }

//        if (Yii::app()->user->id)
//        {
//            $this->redirect(Yii::app()->controller->module->profileUrl);
//        }
        else
        {            
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
				$this->redirect(array('/user/admin'));
			} else $profile->validate();
		}
        }

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
        }
	
        public function actionDeleteConfirm()
        {
            $id = $_GET['id'];
            $this->render('delete-confirm',array('id'=>$id));

        }


        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
            
		if(Yii::app()->request->isPostRequest)
		{
                   // print_r($_POST); exit;
			// we only allow deletion via POST request
		//	$model = $this->loadModel();
                        $model=User::model()->notsafe()->findbyPk($_POST['id']);
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
        
        public function actionIntroduction()
        {
            if(Yii::app()->request->isPostRequest)
            {
                $today = date('Y-m-d');
                $model=User::model()->notsafe()->findbyPk($_POST['id']);
                $record = Introductions::model()->find("date = :date",array(":date"=>$today));
                
                if(!empty($record)) // user already exists
                {
                    if(isset($_POST['force']) && $_POST['force'] !== "false")//force parameter is set 
                    {
                        // change user of day
                        $record->user_id = (int)$_POST['id'];
                        if($record->save())
                        {
                            echo json_encode(array("status"=>"success","message"=>"User of day updated successfully"));
                        }
                        else
                        {
                            echo json_encode(array("status"=>"failure","message"=>"Some error occured ... please contact admin"));
                        }
                        
                        
                    }
                    else
                    {
                        // send json error message
                        echo json_encode(array("status"=>"failure","message"=>"User of day already exists"));
                    }
                }
                else
                {
                    // no record found insert user
                    $intro = new Introductions;
                    $intro->user_id = $_POST['id'];
                    $intro->date = $today;
                    if($intro->save())
                    {
                        echo json_encode(array("status"=>"success","message"=>"User of day created successfully"));
                    }
                }
            }
            Yii::app()->end();
        }
	
}