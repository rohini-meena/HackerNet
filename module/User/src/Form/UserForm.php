<?php
namespace User\Form;

use Laminas\Form\Form;

class UserForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'user',
            'type' => UserFieldset::class,
            'required' => true,
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Add',
            ],
        ]);
    }
}