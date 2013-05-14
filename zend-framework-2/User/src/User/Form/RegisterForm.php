<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'name_first',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Firstname'
            )
        ));

        $this->add(array(
            'name' => 'name_last',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Lastname'
            )
        ));
        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Company(Optional): '
            )
        ));

        $this->add(array(
            'name' => 'domain',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Your Website: '
            )
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Email Address: '
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

        $submit = new \Zend\Form\Element\Submit();
        $submit->setName('submit')
                ->setValue('Register');

        $this->add($submit);
    }

}