<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class LoginTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getLogin($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id));
        $row = $rowset->current();
        if(!$row)
        {
            throw new \Exception("could not find row $id");
        }
        // unset password for account page
        unset($row->password);
        return $row;
    }

    public function saveLogin(Login $login)
    {
        $data = array(
            'email'=>$login->email,
            'email_canonical'=>$login->emailCanonical,
            'name_first'=>$login->nameFirst,
            'name_last'=>$login->nameLast,
            'is_active'=>$login->isActive,
            'account_id'=>$login->accountId
        );
        if(!empty($login->password))
        {
            $data['password'] = $login->password;   
        }

        $id = (int)$login->id;

        if($id == 0)
        {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = $data['created_at'];
            $this->tableGateway->insert($data);
        }
        else
        {
            if($this->getLogin($id))
            {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->tableGateway->update($data,array('id'=>$id));
            }
            else
            {
                throw new \Exception("Form id does not exists");
            }
        }
    }

    public function deleteLogin($id)
    {
        $this->tableGateway->delete(array('id'=>$id));
    }
}