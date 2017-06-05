<?php

namespace Application\Form;

use Application\Domain\Common\ValueObject\Password;
use Zend\Filter\StringTrim;
use Zend\Filter\ToNull;
use Zend\Form\Element\Password as PasswordElement;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

class RegisterForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->buildEmailElement();
        $this->buildPasswordElement();
        $this->buildPasswordConfirmationElement();
    }

    private function buildEmailElement()
    {
        $this->add(new Text('email'));

        $inputObject = new Input('email');
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
        $this->add(new PasswordElement('password'));

        $inputObject = new Input('password');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new ToNull());

        $confirmationValidator = new Identical('password_confirmation');
        $confirmationValidator->setMessage('Le mot de passe de confirmation est différent', Identical::NOT_SAME);

        $inputObject->getValidatorChain()
            ->attach(new StringLength(['min' => Password::MIN_LENGTH]))
            ->attach($confirmationValidator);
        $this->getInputFilter()->add($inputObject);
    }

    public function buildPasswordConfirmationElement()
    {
        $this->add(new PasswordElement('password_confirmation'));

        $inputObject = new Input('password_confirmation');
        $inputObject->setRequired(true);
        $inputObject->getFilterChain()
            ->attach(new ToNull());

        $inputObject->getValidatorChain()
            ->attach(new StringLength(['min' => Password::MIN_LENGTH]));
        $this->getInputFilter()->add($inputObject);
    }

    /**
     * Invalide le formulaire
     */
    public function invalid()
    {
        $this->isValid = false;
    }

}