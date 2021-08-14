<?php 
namespace Files\Model;

use InvalidArgumentException;
use RuntimeException;


use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Sql;

class LaminasDbSqlRepository implements FilesRepositoryInterface
{
    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        Files $postPrototype
    ){
        $this->db = $db;
        $this->hydrator      = $hydrator;
        $this->postPrototype = $postPrototype;
    }

    /**
     * {@inheritDoc}
     */
    public function findAllPosts()
    {
        $sql    = new Sql($this->db);
        $select = $sql->select('files');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
                
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);

        return $resultSet;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findPost($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('files');
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving files post with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        $post = $resultSet->current();

        if (! $post) {
            throw new InvalidArgumentException(sprintf(
                'files post with identifier "%s" not found.',
                $id
            ));
        }

        return $post;
    }
}