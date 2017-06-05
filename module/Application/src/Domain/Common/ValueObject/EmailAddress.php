<?php

namespace Application\Domain\Common\ValueObject;

use InvalidArgumentException;
use UnexpectedValueException;

class EmailAddress implements ValueObjectInterface
{
    /** @var string */
    private $value;

    /**
     * @param string $email
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function __construct($email)
    {
        if (is_string($email) === false) {
            throw new InvalidArgumentException(sprintf(
                'String expected; "%s" given',
                is_object($email) ? get_class($email) : gettype($email)
            ));
        }

        $value = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($value === false) {
            throw new UnexpectedValueException(sprintf(
                'Invalid value given "%s"; value must be a valid email address',
                $email
            ));
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $candidate)
    {
        if ( ! $candidate instanceof self) {
            return false;
        }

        return $this->value === $candidate->value;
    }

    /**
     * @return string
     */
    public function getLocalPart()
    {
        return strstr($this->value, '@', true);
    }

    /**
     * @return string
     */
    public function getDomainPart()
    {
        return ltrim(strstr($this->value, '@'), '@');
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}