<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';       

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile($username='')
	{
            $this->setPageTitle('Profile');
            $scope = 'personal';
            //$this->layout = false;
            // Create our Application instance (replace this with your appId and secret).
            $facebook = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => APP_SECRET,
            ));
            
            $user = $facebook->getUser();
            
            $model = $this->loadUser();
            
            $message = new Messages;
            if(!empty($username))
            {
                $scope = 'public';    
                $message->to_id = $model->id;
                $message->from_id = Yii::app()->user->id;
            }
            
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
                        'user'=>$user,
                        'scope'=>$scope,
                        'message'=>$message
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit($username = '')
	{
            
                Yii::app()->theme='frontend';
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='edit-form')
		{
                    
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
                if(empty($_POST['Profile']['photo']) && !empty($_FILES['photoimg']['name']))
                {
                    $this->actionimageupload();
                    return;
                    //exit;
                }
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
                        
                        $profile->photo = $_POST['Profile']['photo'];
                         
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
                            $model->attributes=$_POST['UserChangePassword'];
                            if($model->validate()) {
                                    $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                                    $new_password->password = UserModule::encrypting($model->password);
                                    $new_password->activkey=UserModule::encrypting(microtime().$model->password);
                                    $new_password->save();
                                    Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
                                    $this->redirect(array("profile"));
                            }
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{            
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
                        {
                            $this->_model=Yii::app()->controller->module->user();
                        }
                        
                        if(!empty($_GET['username']))
                        {
                            $this->_model = User::model()->find("username = '".$_GET['username']."'");
                            if(empty($this->_model) || ($_GET['username'] != Yii::app()->user->name))
                            {
                                throw new Exception("Invalid username",404);
                            }
                            
                        }
			if($this->_model===null)
                        {
                            $this->redirect(Yii::app()->controller->module->loginUrl);
                        }
		}               
		return $this->_model;
	}

            public function actionimageupload()
    {
        //$this->layout = FALSE;
        if(isset($_FILES['photoimg']))
        {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];
            $path = APPLICATION_PATH."/images/user/";
            $valid_ext = array("jpg", "png", "gif", "bmp","jpeg");

                if(strlen($name))
                {

                    list($txt, $ext) = explode(".", $name);
                    if(in_array(strtolower($ext),$valid_ext))
                    {

                        if($size<(1024*1024)) // Image size max 1 MB
                        {
                           $actual_image_name = time()."-".substr(str_replace(" ", "-", $txt),0).".".$ext;

                           $src = "images/user/".$actual_image_name;

                            $tmp = $_FILES['photoimg']['tmp_name'];
                            if(move_uploaded_file($tmp, $path.$actual_image_name))
                            {
                                echo json_encode(array("status"=>'success','message'=>$src));
                            }
                            else
                            {
                                echo json_encode(array("status"=>'failure','message'=>"Photo upload failed"));
                                //echo '<span style="color:red">photo uploaded failed</span>';
                            }

                        }
                        else
                        {
                            echo json_encode(array("status"=>'failure','message'=>"Max image size should be 1 MB"));
                        }

                    }
                    else
                    {
                        echo json_encode(array("status"=>'failure','message'=>"Not a valid image.Please upload jpeg,png,GIF or jpeg images"));
                    }
                }

        }
    }
}