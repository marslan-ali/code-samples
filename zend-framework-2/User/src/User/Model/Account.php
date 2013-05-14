<?php
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Account implements InputFilterAwareInterface
{
    public $id;
    public $createdAt;
    public $updatedAt;

     public function exchangeArray($data)
    {
        $this->id = isset($data['id'])?$data['id']:null;
        $this->createdAt = isset($data['created_at'])?$data['created_at']:null;
        $this->updatedAt = isset($data['updated_at'])?$data['updated_at']:null;
        return $this;
    }

    /**
     * for Zend\Stdlib\Hydrator\ArraySerializable
     * @return array
     */
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
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'=>'created_at',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'=>'updated_at',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim')
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
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
