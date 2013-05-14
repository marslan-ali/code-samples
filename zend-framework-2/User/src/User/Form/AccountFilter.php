<?php
namespace User\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AccountFilter implements InputFilterAwareInterface
{
    protected $inputFilter;
    
    
    protected $dbAdapter;
    
    public function __construct(\Zend\Db\Adapter\Adapter $adapter)
    {
        $this->dbAdapter = $adapter;
    }
    
    public function getInputFilter()
    {
        if(!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
                        
            $inputFilter->add($factory->createInput(array(
                'name'=>'name_first',
                'required'=>true,
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
                'required'=>true,
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
                'name'=>'email',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array('name'=>'EmailAddress'),
                    array('name'=>'Db\NoRecordExists',
                        'options'=>array(
                        'table'=>'cw_login',
                        'field'=>'email',
                        'adapter'=>$this->dbAdapter
                    ))
                    
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
                            'encoding'=>'UTF-8',
                            'min'=>3,
                            'max'=>8,
                        )
                    )
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'=>'retype_password',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                ),
                'validators'=>array(
                    array(
                        'name'=>'Identical',
                        'options'=>array(
                            'token'=>'password',
                            'message'=>'Password mismatch'
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
