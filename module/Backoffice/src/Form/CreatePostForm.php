<?php

namespace Backoffice\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\ToNull;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\Input;

class CreatePostForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->buildTitleElement();
        $this->buildContentElement();
    }

    private function buildTitleElement()
    {
        // Élément HTML
        $this->add(new Text('title'));

        // Filtres et validateurs
        $inputObject = new Input('title');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new ToNull()); // Renvoie NULL si empty()
        $this->getInputFilter()->add($inputObject);
    }

    private function buildContentElement()
    {
        // Élément HTML
        $this->add(new Text('content'));

        // Filtres et validateurs
        $inputObject = new Input('content');
        $inputObject->setRequired(false);
        $inputObject->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new ToNull()); // Renvoie NULL si empty()
        $this->getInputFilter()->add($inputObject);
    }
}