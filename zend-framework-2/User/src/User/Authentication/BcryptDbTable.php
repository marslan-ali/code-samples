<?php
namespace User\Authentication;

use Zend\Authentication\Adapter\DbTable;
use stdClass;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as DbSelect;
use Zend\Crypt\Password\Bcrypt;


class BcryptDbTable extends DbTable
{
    public function __construct(\Zend\Db\Adapter\Adapter $zendDb, $tableName = null, $identityColumn = null, $credentialColumn = null, $credentialTreatment = null)
    {
        parent::__construct($zendDb, $tableName, $identityColumn, $credentialColumn, $credentialTreatment);
    }
    
    /**
     * This method is called to attempt an authentication. Previous to this
     * call, this adapter would have already been configured with all
     * necessary information to successfully connect to a database table and
     * attempt to find a record matching the provided identity.
     *
     * @throws Exception\RuntimeException if answering the authentication query is impossible
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $this->_authenticateSetup();
        $dbSelect         = $this->_authenticateCreateSelect();
        //echo $dbSelect->getSqlString();
       //exit;

        $resultIdentities = $this->_authenticateQuerySelect($dbSelect);
        if (($authResult = $this->_authenticateValidateResultSet($resultIdentities)) instanceof AuthenticationResult) {
            return $authResult;
        }

        // At this point, ambiguity is already done. Loop, check and break on success.
        foreach ($resultIdentities as $identity) {
            $authResult = $this->_authenticateValidateResult($identity);
            if ($authResult->isValid()) {
                break;
            }
        }

        return $authResult;
    }
    
    /**
     * _authenticateQuerySelect() - This method accepts a Zend\Db\Sql\Select object and
     * performs a query against the database with that object.
     *
     * @param  DbSelect $dbSelect
     * @throws Exception\RuntimeException when an invalid select object is encountered
     * @return array
     */
    protected function _authenticateQuerySelect(DbSelect $dbSelect)
    {
        $statement = $this->zendDb->createStatement();
        $dbSelect->prepareStatement($this->zendDb, $statement);
        $resultSet = new ResultSet();
        try {
            $resultSet->initialize($statement->execute(array($this->identity)));
            $resultIdentities = $resultSet->toArray();
        } catch (\Exception $e) {
            throw new Exception\RuntimeException(
                'The supplied parameters to DbTable failed to '
                    . 'produce a valid sql statement, please check table and column names '
                    . 'for validity.', 0, $e
            );
        }
        return $resultIdentities;
    }
    
    /**
     * _authenticateValidateResult() - This method attempts to validate that
     * the record in the resultset is indeed a record that matched the
     * identity provided to this adapter.
     *
     * @param  array $resultIdentity
     * @return AuthenticationResult
     */
    protected function _authenticateValidateResult($resultIdentity)
    {
        /**
         * code for validating using bcrypt
         */
        $bcrypt = new Bcrypt;
        if (!$bcrypt->verify($this->credential, $resultIdentity['password'])) {
            $this->authenticateResultInfo['code']       = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
            $this->authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }
        $this->resultRow = $resultIdentity;

        $this->authenticateResultInfo['code']       = AuthenticationResult::SUCCESS;
        $this->authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->_authenticateCreateAuthResult();
    }
    
    
    /**
     * _authenticateCreateSelect() - This method creates a Zend\Db\Sql\Select object that
     * is completely configured to be queried against the database.
     *
     * @return DbSelect
     */
    protected function _authenticateCreateSelect()
    {
        // build credential expression
        if (empty($this->credentialTreatment) || (strpos($this->credentialTreatment, '?') === false)) {
            $this->credentialTreatment = '?';
        }
        /*
        $credentialExpression = new Expression(
            '(CASE WHEN '
            . $this->zendDb->getPlatform()->quoteIdentifier($this->credentialColumn)
            . ' = ' . $this->credentialTreatment
            . ' THEN 1 ELSE 0 END) AS '
            . $this->zendDb->getPlatform()->quoteIdentifier('zend_auth_credential_match')
        );
         * 
         */

        // get select
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->tableName)
                 ->columns(array('*'))
                 ->where($this->zendDb->getPlatform()->quoteIdentifier($this->identityColumn) . ' = ?');

        return $dbSelect;
    }
    
}
