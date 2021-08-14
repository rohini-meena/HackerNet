<?php 
namespace User\Model;

class Entity{

    private $id;
	private $name;
	private $email;
	private $password;
    private $admin_user;

	public function __construct($name, $email, $password, $admin_user, $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->admin_user = $admin_user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isAdmin() {
        return $this->admin_user;
    }
}