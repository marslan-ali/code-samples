<?php
namespace Register\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Register implements InputFilterAwareInterface
{
    public $firstName;
    public $lastName;
    public $company;
    public $wurl;
    public $email;
    public $password;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id = isset($data['id'])?$data['id']:null;
        $this->firstName = isset($data['first_name'])?$data['first_name']:null;
        $this->lastName = isset($data['last_name'])?$data['last_name']:null;
        $this->wurl = isset($data['wurl'])?$data['wurl']:null;
        $this->email = isset($data['email'])?$data['email']:null;
        $this->password = isset($data['password'])?$data['password']:null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function getInputFilter()
    {
        if(!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

                $inputFilter->add($factory->createInput(array(
                'name'=>'id',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'Int')
                )
            )));


            $inputFilter->add($factory->createInput(array(
                'name'=>'first_name',
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>1,
                            'max'=>100,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'last_name',
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>1,
                            'max'=>255
                        )
                   )
                )
            )));

           $inputFilter->add($factory->createInput(array(
                'name'=>'email',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array('name'=>'EmailAddress')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'url',
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'min'=>1,
                            'max'=>100
                        )
                   )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'password',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                    'name'=>'StringLength',
                    'options'=>array(
                        'min'=>4,
                        'max'=>10
                    )
                   )
                )
            )));
        }
        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("not used");
    }
}
