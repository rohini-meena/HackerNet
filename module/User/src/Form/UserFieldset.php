<?php 
namespace User\Form;

use User\Model\Entity;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ReflectionHydrator;

class UserFieldset extends Fieldset
{

	public function init()
    {
    	$this->setHydrator(new ReflectionHydrator());
	    $this->setObject(new Entity('', '','', 0));

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'required' => true,            
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'email',
            'required' => true,
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'admin_user',
            'options' => [
                'label' => 'Is admin user?',
                'empty_option' => 'Please choose user type',
                'value_options' => [
                    '1' => 'Yes',
                    '0' => 'No',
                ],
            ],
        ]);
    }

}