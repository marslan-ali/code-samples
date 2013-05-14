<?php
namespace User\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class BillingFilter implements InputFilterAwareInterface
{
    protected $inputFilter;
    protected $groupInputFilter;

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
                'name'=>'account_id',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int')
                )
            )));
            
           $inputFilter->add($factory->createInput(array(
                'name'=>'company',
                'required'=>false,
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
                            'max'=>55,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'name_first',
                'required'=>false,
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
                            'max'=>55,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'name_last',
                'required'=>false,
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
                            'max'=>55,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'department',
                'required'=>false,
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
                            'max'=>55,
                        )
                    )
                )
            )));


            $inputFilter->add($factory->createInput(array(
                'name'=>'street_and_number',
                'required'=>false,
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
                            'max'=>255,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'zipcode',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>4,
                            'max'=>8,
                        )
                    )
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'=>'city',
                'required'=>false,
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
                'name'=>'country',
                 'required'=>false,
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
                'name'=>'phonenumber',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>6,
                            'max'=>14,
                        )
                    )
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
