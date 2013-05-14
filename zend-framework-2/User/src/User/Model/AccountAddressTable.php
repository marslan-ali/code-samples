<?php

namespace User\Model;

use User\Model\AccountAddress;
use Zend\Db\TableGateway\TableGateway;

class AccountAddressTable
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

    public function getAccountAddress($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row)
        {
            throw new \Exception("could not find row $id");
        }
        return $row;
    }

    public function saveAccountAddress(AccountAddress $accountAddress)
    {
        $data = array(
            'name_last' => $accountAddress->lastName,
            'name_first' => $accountAddress->firstName,
            'company' => $accountAddress->company,
            'account_id' => $accountAddress->accountId,
            'department' => $accountAddress->department,
            'street_and_number' => $accountAddress->streetAndNumber,
            'ZipCode' => $accountAddress->zipcode,
            'city' => $accountAddress->city,
            'country' => $accountAddress->country,
            'phonenumber' => $accountAddress->phoneNumber
        );

        $id = (int) $accountAddress->id;
        if ($id == 0)
        {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = $data['created_at'];
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }
        else
        {
            if ($this->getAccountAddress($id))
            {
                $data['updated_at'] = date('y-m-d H:i:s');
                $this->tableGateway->update($data, array('id' => $id));
            }
            else
            {
                throw new \Exception("Form id does not exists");
            }
        }
    }

    public function deleteAccount($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function getByAccountAddressById($accountId)
    {
       $accountId = (int) $accountId;
       $rowset = $this->tableGateway->select(array('account_id' => $accountId));
       $row = $rowset->current();
       if (!$row)
       {
            throw new \Exception("could not find row $accountId");
       }
        return $row;
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
