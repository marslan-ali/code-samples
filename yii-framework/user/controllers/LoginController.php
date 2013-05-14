<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
        //public $layout = "//frontend/views/layouts/main";

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            if(!empty(Yii::app()->user->id))
            {
                $this->redirect(array('/user/profile'));
            }
            //Yii::app()->theme = 'frontend';
            //$this->layout = '//layouts/main';
            // Create our Application instance (replace this with your appId and secret).
            $facebook = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => APP_SECRET,
            ));

            $user = $facebook->getUser();
            //$userinfo = Yii::app()->facebook->getInfo();
            //echo $user;exit;
            if(!empty($user))
            {
                $userinfo = $facebook->api('/me');
                //die("asdasd");
                $model=new UserLogin;
                $model->scenario = 'fblogin';
                $model->facebookId = $userinfo['id'];
                $model->username = $userinfo['email'];
                $model->password = 'dummy';
                if($model->validate())
                {
                    $this->lastVisit();
                    $this->redirect(array('/user/profile'));
                }
                else
                {
                    $this->redirect(array("/register"));
                }
            }
            //$this->layout = false;
            $model=new UserLogin;
            $model->scenario = 'default';
            // collect user input data
            $usermodel=new User();

            if(isset($_POST['UserLogin']))
            {
                    $model->attributes=$_POST['UserLogin'];
                     $this->performAjaxValidation($model);
                    // validate user input and redirect to previous page if valid
                    if($model->validate()) {
                            $this->lastVisit();
                            if($this->isSuperUser())
                            {

                                $this->redirect(array('/user/admin'));
                            }
                            else
                            {
                                $this->redirect(array('/user/profile'));
                            }


                    }
            }
            // display the login form
            $this->render('/user/login',array('model'=>$model,'facebook'=>$facebook,'user'=>$user));
	}
	
	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}
        
        private function isSuperUser()
        {
            $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
            return $user->superuser == 1;
        }
        protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}