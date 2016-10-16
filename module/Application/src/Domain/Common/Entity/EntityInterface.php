<?php

namespace Application\Domain\Common\Entity;

interface EntityInterface
{
    /**
     * Permet de vérifier si deux entités ont la même identité
     *
     * @param EntityInterface $candidate
     * @return boolean
     */
    public function sameIdentityAs(EntityInterface $candidate);
}