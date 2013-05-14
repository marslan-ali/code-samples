<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Submit;


class LoginForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Password'
            )
        ));
        
        $submit = new Submit();
        $submit->setName('submit')
                ->setValue('Login');
        
        $this->add($submit);
    }

}