<?php

namespace User\Form;

use Zend\Form\Form;

class BillingForm extends Form
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
            'name' => 'account_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        

        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Company: '
            )
        ));

        $this->add(array(
            'name' => 'name_first',
            'attributes' => array(
                'type' => 'text',
                'placeholder'=>'First Name'
            ),
            'options' => array(
                'label' => 'First Name'
            )
        ));

        $this->add(array(
            'name' => 'name_last',
            'attributes' => array(
                'type' => 'text',
                'placeholder'=>'Last Name'
            ),
            'options' => array(
                'label' => 'Last Name'
            )
        ));


        $this->add(array(
            'name' => 'department',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Department: ',
                'value_options'=>array(
                    'Marketing'=>'Marketing',
                    'Management'=>'Management',
                    'Inhouse SEO'=>'Inhouse SEO',
                    'IT'=>'IT'
                )
            )
        ));
        $this->add(array(
            'name' => 'street_and_number',
            'attributes' => array(
                'type' => 'text',
                'placeholder'=>'Street'
            ),
            'options' => array(
                'label' => 'Address: '
            )
        ));

        $this->add(array(
            'name' => 'zipcode',
            'attributes' => array(
                'type' => 'text',
                'placeholder'=>'ZIP'
            ),
            'options' => array(
                'label' => 'Zip code'
            )
        ));
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type' => 'text',
                'placeholder'=>'City'
            ),
            'options' => array(
                'label' => 'City'
            )
        ));
        $this->add(array(
            'name' => 'country',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Country',
                'value_options'=>array(
                    'DE'=>'Germany',
                    'AT'=>'Austria',
                    'CH'=>'Switzerland',
                    'US'=>'United States',
                    'PL'=>'Poland',
                    'UK'=>'United Kingdom',
                    'FR'=>'France',
                    'BR'=>'Brasil',
                )
            )
        ));

        $this->add(array(
            'name' => 'phonenumber',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Phone Number'
            )
        ));

        $submit = new \Zend\Form\Element\Submit();
        $submit->setName('submit')
                ->setValue('Register');

        $this->add($submit);
    }






/*
 * Germany (DE)
Austria (AT)
Switzerland (CH)
United States (US)
Poland (PL)
United Kingdom (UK)
France (FR)
Brasil (BR)
 */
}

    ?>