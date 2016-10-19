<?php

namespace Backoffice\Form;

use Application\View\Model\PostViewModel;
use Zend\Filter\StringTrim;
use Zend\Filter\ToNull;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\Input;

class UpdatePostForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->buildTitleElement();
        $this->buildSlugElement();
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

    private function buildSlugElement()
    {
        // Élément HTML
        $this->add(new Text('slug'));

        // Filtres et validateurs
        $inputObject = new Input('slug');
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

    /**
     * @param PostViewModel $post
     */
    public function setDataFromPostViewModel(PostViewModel $post)
    {
        $this->setData([
            'title' => $post->name,
            'slug' => $post->slug,
            'content' => $post->content,
        ]);
    }
}