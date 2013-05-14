<?php
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AccountAddress implements InputFilterAwareInterface
{
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */
    
    protected $inputFilter;
    public $id;
    public $lastName;
    public $firstName;
    public $company;
    public $accountId;
    public $department;
    public $streetAndNumber;
    public $zipcode;
    public $city;
    public $country;
    public $phoneNumber;

     public function exchangeArray($data)
    {
        $this->id = isset($data['id'])?$data['id']:null;
        $this->lastName = isset($data['name_last'])?$data['name_last']:null;
        $this->firstName = isset($data['name_first'])?$data['name_first']:null;
        $this->company = isset($data['company'])?$data['company']:null;
        $this->accountId = isset($data['account_id'])?$data['account_id']:null;
        
        //$this->deparment = isset($data['deparment'])?$data['department']:null;
        $this->department = isset($data['department'])?$data['department']:'';

        $this->streetAndNumber = isset($data['street_and_number'])?$data['street_and_number']:'';
        
        $this->zipcode = isset($data['zipcode'])?$data['zipcode']:'';
        $this->city = isset($data['city'])?$data['city']:'';
        $this->country = isset($data['country'])?$data['country']:'';
        $this->phoneNumber = isset($data['phonenumber'])?$data['phonenumber']:'';
    

        ////isset($data['account_id'])?$data['account_id']:null;

        return $this;
    }

    public function getArrayCopy()
    {
        $values = get_object_vars($this);
        if(isset($values['lastName']))
        {
            $values['name_last'] = $values['lastName'];
            unset($values['lastName']);
        }

        if(isset($values['firstName']))
        {
            $values['name_first'] = $values['firstName'];
            unset($values['firstName']);
        }

        if(isset($values['phoneNumber']))
        {
            $values['phonenumber'] = $values['phoneNumber'];
            unset($values['phoneNumber']);
        }
        
        if(isset($values['streetAndNumber']))
        {
            $values['street_and_number'] = $values['streetAndNumber'];
            unset($values['streetAndNumber']);
        }
        
        if(isset($values['accountId']))
        {
            $values['account_id'] = $values['accountId'];
            unset($values['accountId']);
        }
        return $values;
    }

    public function getInputFilter()
    {
        if(!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'=>'id',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'name_last',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'=>'name_first',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                )
            )));
                $inputFilter->add($factory->createInput(array(
                'name'=>'company',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                )
            )));

       $inputFilter->add($factory->createInput(array(
                'name'=>'account_id',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int')
                )
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }



 }
?>
