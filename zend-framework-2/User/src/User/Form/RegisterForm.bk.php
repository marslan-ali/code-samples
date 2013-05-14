<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('register');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'First Name: '
            )
        ));

        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Last Name: '
            )
        ));

        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Company(Optional: '
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

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Create Account',
                'id' => 'submitbutton'
            )
        ));

        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Company(Optional: '
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

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Create Account',
                'id' => 'submitbutton'
            )
        ));
    }

}

?>
