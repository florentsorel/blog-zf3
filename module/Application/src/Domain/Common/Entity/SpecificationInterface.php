<?php

namespace Application\Domain\Common\Entity;

interface SpecificationInterface
{
    /**
     * Permet de vérifier une règle métier sur une entité
     *
     * @param EntityInterface $candidate
     * @return boolean
     */
    public function isSatisfiedBy(EntityInterface $candidate);
}