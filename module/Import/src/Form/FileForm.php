<?php
namespace Import\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;

//Formularz wysyłania plików.
class FileForm extends Form
{

    public function __construct()
    {

        parent::__construct('image-form');

        $this->setAttribute('method', 'post');

        $this->setAttribute('enctype', 'multipart/form-data');

        $this->addElements();
        $this->addInputFilter();
    }


    protected function addElements()
    {
        // Przycisk Przegladaj
        $this->add([
            'type'  => 'file',
            'name' => 'file',

            'attributes' => [
                'id' => 'file',
                 'accept' => "application/zip"
            ],
            'options' => [
                'label' => 'Wybierz plik .zip',

            ],
        ]);

        //Przycisk wyslij
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Wyślij',
                'id' => 'submitbutton',
            ],
        ]);

    }


    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add validation rules for the "file" field
        $inputFilter->add([
            'type'     => FileInput::class,
            'name'     => 'file',
            'required' => true,
            'validators' => [
                ['name'    => 'FileUploadFile'],
                [
                    'name'    => 'FileMimeType',
                    'options' => [
                        'mimeType'  => ['zip']
                    ]
                ],
            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target'=>'./data/upload',
                        'useUploadName'=>true,
                        'useUploadExtension'=>true,
                        'overwrite'=>true,
                        'randomize'=>false
                    ]
                ]
            ],
        ]);
    }
}