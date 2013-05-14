<?php
namespace User\Model;

use User\Model\UserTable;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;
    
    /**
     * 
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;        
    }
    
    public function fetchAll()
    {
        
    }
    
    public function getUser($id)
    {
        
    }
    
    public function saveUser(User $user)
    {
        
    }
    
    public function deleteUser($id)
    {
        
    }
}
