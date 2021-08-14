<?php
namespace Files\Form;

use Laminas\Form\Form;

class FilesForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'post',
            'type' => FilesFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Insert new Post',
            ],
        ]);
    }
}