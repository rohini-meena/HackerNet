<?php 
namespace Files\Model;

interface FilesRepositoryInterface{

	public function findAllPosts();
	public function findPost($id);
}