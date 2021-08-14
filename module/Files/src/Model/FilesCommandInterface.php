<?php 
namespace Files\Model;

interface FilesCommandInterface
{
    /**
     * Persist a new post in the system.
     *
     * @param Post $post The post to insert; may or may not have an identifier.
     * @return Post The inserted post, with identifier.
     */
    public function insertPost(Files $files);

    /**
     * Update an existing post in the system.
     *
     * @param Post $post The post to update; must have an identifier.
     * @return Post The updated post.
     */
    public function updatePost(Files $files);

    /**
     * Delete a post from the system.
     *
     * @param Post $post The post to delete.
     * @return bool
     */
    public function deletePost(Files $files);
}