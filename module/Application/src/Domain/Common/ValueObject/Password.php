<?php

namespace Application\Domain\Common\ValueObject;

use InvalidArgumentException;
use Zend\Stdlib\StringUtils;

class Password implements ValueObjectInterface
{
    const MIN_LENGTH = 8;

    /** @var string */
    private $value;

    /**
     * Génère un hash à partir d'un mot de passe
     *
     * @param Password $password
     * @return bool|string
     */
    public static function generateHashFrom(Password $password)
    {
        return password_hash($password->toString(), PASSWORD_BCRYPT);
    }

    /**
     * Génère un mot de passe aléatoire
     *
     * @return Password
     */
    public static function generate()
    {
        $lowerChars = 'abcdefghijkmnopqrstuvwxyz';
        $upperChars = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $digits = '123456789';
        $specialChars = '!@#$%&-+?';

        $chunks = [];

        // 4 lettres minuscules
        $chunks[0] = substr(str_shuffle($lowerChars), 0, 4);
        // 2 lettres majuscules
        $chunks[1] = substr(str_shuffle($upperChars), 0, 2);
        // Un chiffre
        $chunks[2] = substr(str_shuffle($digits), 0, 1);
        // Un caractère spécial
        $chunks[3] = substr(str_shuffle($specialChars), 0, 1);

        return new self(str_shuffle(join('', $chunks)));
    }

    public function __construct($password)
    {
        if (is_string($password) === false) {
            $type = is_object($password)
                ? get_class($password)
                : gettype($password);
            throw new InvalidArgumentException(sprintf(
                'String value expected; %s given',
                $type
            ));
        }

        $stringWrapper = StringUtils::getWrapper();
        if ($stringWrapper->strlen($password) < self::MIN_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Password must be at least %d chars long',
                self::MIN_LENGTH
            ));
        }

        $this->value = $password;
    }

    /**
     * Permet de vérifier si deux objets ont la même valeur
     *
     * @param ValueObjectInterface $candidate
     * @return boolean
     */
    public function sameValueAs(ValueObjectInterface $candidate)
    {
        if ( ! $candidate instanceof Password) {
            return false;
        }

        return $this->value === $candidate->value;
    }

    /**
     * Vérifie qu'un mot de passe correspond à un hash donné
     *
     * @param string $hash
     * @return boolean
     */
    public function challengeAgainst($hash)
    {
        return password_verify($this->value, $hash);
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