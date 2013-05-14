<?php

class RegistrationController extends Controller
{

    public $defaultAction = 'registration';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        /*
        Yii::app()->getClientScript()->registerCoreScript('yii');
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScript('my_enable_default_caching_of_scripts',
        'jQuery.ajaxSetup({\'cache\': true})');
         * 
         */
        return (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') ? array() : array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
                );
    }

    /**
     * Registration user
     */
    public function actionRegistration()
    {        
        Yii::app()->theme = 'frontend';
       // $this->layout = FALSE;
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;
        
        // Create our Application instance (replace this with your appId and secret).
        $facebook = new Facebook(array(
          'appId'  => APP_ID,
          'secret' => APP_SECRET,
        ));

        $user = $facebook->getUser();
        
        if(!empty($user))
        {
            $userinfo = $facebook->api('/me');
            $model->fb_userid = $userinfo['id'];
            //$model->username = $userinfo['username'];
            $model->email = $userinfo['email'];
            $profile->firstname = $userinfo['first_name'];
            $profile->lastname = $userinfo['last_name'];
        }
        
        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form')
        {
            
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }

        if (Yii::app()->user->id)
        {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        }
        else
        {
           if(empty($_POST['image_url']) && !empty($_FILES['photoimg']['name']))
            {
                $this->actionimageupload();
                return;
                //exit;
            }
            else if (isset($_POST['RegistrationForm']))
            {
                $model->attributes = $_POST['RegistrationForm'];                
                $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                if(isset($_POST['image_url']))
                {
                    $profile->photo = $_POST['image_url'];
                }
                if ($model->validate() && $profile->validate())
                {
                    $soucePassword = $model->password;
                    $model->activkey = UserModule::encrypting(microtime() . $model->password);
                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->createtime = time();
                    $model->lastvisit = ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) ? time() : 0;
                    $model->superuser = 0;
                    $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                    if ($model->save())
                    {
                        $profile->user_id = $model->id;
                        $profile->save();
                        if (Yii::app()->controller->module->sendActivationMail)
                        {
                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                            UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                        }

                        if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin)
                        {
                            $identity = new UserIdentity($model->username, $soucePassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity, 0);
                            $this->redirect(Yii::app()->controller->module->returnUrl);
                        }
                        else
                        {
                            if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                            }
                            elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
                            }
                            elseif (Yii::app()->controller->module->loginNotActiv)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
                            }
                            else
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                            }
                            $this->refresh();
                        }
                    }
                } else
                    $profile->validate();
            }
            $this->render('/user/registration', array('model' => $model, 'profile' => $profile));
        }
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