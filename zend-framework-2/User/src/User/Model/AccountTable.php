<?php
namespace User\Model;

use User\Model\Account;
use Zend\Db\TableGateway\TableGateway;

class AccountTable
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

    public function getAccount($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id));
        $row = $rowset->current();
        if(!$row)
        {
            throw new \Exception("could not find row $id");
        }
        return $row;
    }

    public function saveAccount(Account $account)
    {
        $data = array(
            'created_at'=>$account->createdAt,
            'updated_at'=>$account->updatedAt
        );

        $id = (int)$account->id;
        if($id == 0)
        {
          $this->tableGateway->insert($data);
          return $this->tableGateway->getLastInsertValue();
        }
        else
        {
            if($this->getAccount($id))
            {
                $this->tableGateway->update($data,array('id'=>$id));
            }
            else
            {
                throw new \Exception("Form id does not exists");
            }
        }
    }

    public function deleteAccount($id)
    {
        $this->tableGateway->delete(array('id'=>$id));
    }


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

public function getAccountById($accountId)
    {
        $accountId = (int)$accountId;
        $rowset = $this->tableGateway->select(array('account_id'=>$accountId));
        $row = $rowset->current();
        if(!$row)
        {
            throw new \Exception("could not find row $id");
        }
        return $row;
    }
}
?>
