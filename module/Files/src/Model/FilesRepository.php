<?php 
namespace Files\Model;

use DomainException;

class FilesRepository implements FilesRepositoryInterface{

	private $data = [
        1 => [
            'id'    => 1,
            'title' => 'Hello World #1',
            'text'  => 'This is our first file post!',
        ],
        2 => [
            'id'    => 2,
            'title' => 'Hello World #2',
            'text'  => 'This is our second file post!',
        ]
    ];

	public function findAllPosts()
    {
    	return array_map(function ($post) {
            return new Files(
                $post['title'],
                $post['text'],
                $post['id']
            );
        }, $this->data);
    }

    public function findPost($id)
    {
        if (! isset($this->data[$id])) {
            throw new DomainException(sprintf('Post by id "%s" not found', $id));
        }

        return new Files(
            $this->data[$id]['title'],
            $this->data[$id]['text'],
            $this->data[$id]['id']
        );
    }
}