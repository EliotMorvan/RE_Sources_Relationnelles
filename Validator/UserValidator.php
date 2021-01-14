<?php

namespace Validator;

use Entity\User;

class UserValidator {

    /**
     * Validates the given user.
     * 
     * @param User $user
     * 
     * @return array The error(s)
     */
    public function validate(User $user): array
    {
        $errors = [];

        if (empty($user->getEmail())) {
            $errors['email'] = "L'email ne doit pas être vide.";
        }

        // TODO Validation email
        // -> utiliser la fonction filter_var (voir doc php)

        if (empty($user->getPassword())) {
            $errors['password'] = "Le mot de passe ne doit pas être vide.";
        }

        return $errors;
    }
}
