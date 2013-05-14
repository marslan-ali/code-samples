<?php
namespace User\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Crypt\Password\Bcrypt;

class Login implements InputFilterAwareInterface
{
    public $id;
    public $email;
    public $emailCanonical;
    public $password;
    public $nameFirst;
    public $nameLast;
    public $isActive;
    public $createdAt;
    public $updatedAt;
    public $accountId;
    
    public function exchangeArray($data)
    {
        $bcrypt = new Bcrypt;
        
        $this->id = isset($data['id'])?$data['id']:null;
        $this->email = isset($data['email'])?$data['email']:null;
        
        $this->emailCanonical = isset($data['email_canonical'])?$data['email_canonical']:$data['email'];
        $this->password = isset($data['password'])&&!empty($data['password'])?$bcrypt->create($data['password']):null;
        $this->nameFirst = isset($data['name_first'])?$data['name_first']:null;
        $this->nameLast = isset($data['name_last'])?$data['name_last']:null;
        $this->isActive = isset($data['is_active'])?$data['is_active']:0;
        $this->createdAt = isset($data['created_at'])?$data['created_at']:null;
        $this->updatedAt = isset($data['updated_at'])?$data['updated_at']:null;
        $this->accountId = isset($data['account_id'])?$data['account_id']:null;
    }
    
    public function getArrayCopy()
    {
        $obj = get_object_vars($this);
        $obj['name_first'] = $obj['nameFirst'];
        $obj['name_last'] = $obj['nameLast'];
        $obj['account_id'] = $obj['accountId'];
        return $obj;        
    }
    public function getInputFilter()
    {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        
    }
}
