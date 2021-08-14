<?php
namespace Files\Model;

use RuntimeException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Update;

class FilesCommand implements FilesCommandInterface
{
    private $db;

    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
    }


    public function insertPost(Post $post)
    {
        $insert = new Insert('files');
        $insert->values([
            'title' => $post->getTitle(),
            'text' => $post->getText(),
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during file post insert operation'
            );
        }

        $id = $result->getGeneratedValue();

        return new Files(
            $post->getTitle(),
            $post->getText(),
            $id
        );
    }

    /**
     * {@inheritDoc}
     */
    public function updatePost(files $files)
    {
        if (! $files->getId()) {
            throw new RuntimeException('Cannot update files; missing identifier');
        }

        $update = new Update('files');
        $update->set([
                'title' => $files->getTitle(),
                'text' => $files->getText(),
        ]);
        $update->where(['id = ?' => $files->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during file files update operation'
            );
        }

        return $files;
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(Files $files)
    {
        if (! $files->getId()) {
            throw new RuntimeException('Cannot update files; missing identifier');
        }

        $delete = new Delete('files');
        $delete->where(['id = ?' => $files->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            return false;
        }

        return true;
    }
}