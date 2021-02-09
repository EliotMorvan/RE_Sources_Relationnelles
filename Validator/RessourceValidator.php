<?php

namespace Validator;

use Entity\Ressource;

class RessourceValidator {

    /**
     * Validates the given user.
     * 
     * @param Ressource $Ressource
     * 
     * @return array The error(s)
     */
    public function validate(Ressource $ressource): array
    {
        $errors = [];

        if (empty($ressource->getTitre())) {
            $errors['titre'] = "Le titre ne doit pas être vide.";
        }

        if (empty($ressource->getcontenu())) {
            $errors['contenu'] = "Le contenu ne doit pas être vide.";
        }

        return $errors;
    }
}
