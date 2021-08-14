<?php 
namespace User\Model;

use RuntimeException;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Update;

use User\Model\Entity;

class User{

	private $hydrator;
	private $entity;
    private $db;
    private $entityName = 'user';

    public function __construct(AdapterInterface $db,
        HydratorInterface $hydrator,
        Entity $postPrototype)
    {
        $this->db = $db;
        $this->hydrator      = $hydrator;
        $this->entity = $postPrototype;
    }

    public function get($id)
    {
        $resultSet = new ResultSet();
        $sql       = new Sql($this->db);
        $select    = $sql->select($this->entityName);
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving data with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->entity);
        $resultSet->initialize($result);
        $user = $resultSet->current();

        return $user;
    }

    public function getAll()
    {

        $resultSet = new ResultSet();
        $sql = new Sql($this->db);
        $select = $sql->select($this->entityName);
        $select->where(['status = ?' => 1]);
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if($result instanceof ResultInterface && $result->isQueryResult()){
            $resultSet->initialize($result);
        }

        return $resultSet;
    }

	public function create($user)
	{   
        if(empty($user->getName()) || empty($user->getPassword())){
            return false;
        }

		$insert = new Insert($this->entityName);
        $insert->values([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'is_admin' => $user->isAdmin(),
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

    }
    
    public function delete($id)
    {
        if (!$id) {
            throw new RuntimeException('Cannot update post; missing identifier');
        } 
        $update = new Update($this->entityName);
        $update->set([
            'status' => 0
        ]);
        $update->where(['id = ?' => $id]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        return true;
    }

    public function update($user){

        if($id = $user->getId()){
            $update = new Update($this->entityName);
            $update->set([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'is_admin' => $user->isAdmin(),
            ]);
            $update->where(['id = ?' => $id]);

            $sql = new Sql($this->db);
            $statement = $sql->prepareStatementForSqlObject($update);
            $result = $statement->execute();
        }
    }
    public function checkLogin($username, $password)
    {
        $resultSet = new ResultSet();
        $sql = new Sql($this->db);
        $select = $sql->select($this->entityName);
        $select->where(['email = ?' => $username, 'password = ?' => $password]);
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if($result instanceof ResultInterface && $result->isQueryResult()){
            $resultSet->initialize($result);
        }

        return $resultSet;
    }
}