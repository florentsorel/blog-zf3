<?php

namespace Application\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\ToNull;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

class LoginForm extends Form
{
    const PASSWORD_LENGTH_MIN = 8;

    public function __construct()
    {
        parent::__construct();
        $this->buildUsernameElement();
        $this->buildEmailElement();
        $this->buildPasswordElement();
        $this->buildPasswordConfirmationElement();
    }

    private function buildUsernameElement()
    {
        $this->add(new Text('username'));

        $inputObject = new Input('username');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new ToNull());
        $this->getInputFilter()->add($inputObject);
    }

    private function buildEmailElement()
    {
        $this->add(new Text('email'));

        $inputObject = new Input('username');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new ToNull());
        $inputObject->getValidatorChain()
            ->attach(new EmailAddress());
        $this->getInputFilter()->add($inputObject);
    }

    public function buildPasswordElement()
    {
        $this->add(new Password('password'));

        $inputObject = new Input('password');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new ToNull());
        $inputObject->getValidatorChain()
            ->attach(new StringLength(['min' => self::PASSWORD_LENGTH_MIN]));
        $this->getInputFilter()->add($inputObject);
    }

    public function buildPasswordConfirmationElement()
    {
        $this->add(new Password('password_confirmation'));

        $inputObject = new Input('password_confirmation');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new ToNull());

        $confirmationValidator = new Identical('password');
        $confirmationValidator->setMessage('Le mot de passe de confirmation est différent', Identical::NOT_SAME);

        $inputObject->getValidatorChain()
            ->attach(new StringLength(['min' => self::PASSWORD_LENGTH_MIN]))
            ->attach($confirmationValidator);
        $this->getInputFilter()->add($inputObject);
    }

}