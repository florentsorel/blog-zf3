<?php

namespace Application\Domain\Common\ValueObject;

interface ValueObjectInterface
{
    /**
     * Permet de vérifier si deux objets ont la même valeur
     *
     * @param ValueObjectInterface $candidate
     * @return boolean
     */
    public function sameValueAs(ValueObjectInterface $candidate);
}