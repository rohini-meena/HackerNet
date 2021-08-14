<?php 
namespace Files\Form;

use Files\Model\Post;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ReflectionHydrator;

class FilesFieldset extends Fieldset
{

	public function init()
    {
    	$this->setHydrator(new ReflectionHydrator());
	    $this->setObject(new Post('', ''));

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Post Title',
            ],
        ]);

        $this->add([
            'type' => 'textarea',
            'name' => 'text',
            'options' => [
                'label' => 'Post Text',
            ],
        ]);
    }

}