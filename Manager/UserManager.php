<?php

namespace Manager;

use Entity\User;
use PDO;

class UserManager {

    /** PDO */
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Ajoute un utilisateur dans la base données.
     */
    public function insert(User $user) {
        // Prépare une requête d'insertion d'un utilisateur
        $insert = $this->connection->prepare(
            'INSERT INTO user(email, password, avatar) 
            VALUES (:email, :password, :avatar);'
        );

        // Execute la requête d'insertion
        $insert->execute([
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'avatar'   => $user->getAvatar(),
        ]);

        // Mettre à jour l'identifiant
        $user->setId($this->connection->lastInsertId());
    }

    /**
     * Mets à jour un utilisateur dans la base de données.
     */
    public function update(User $user) {
        // Prépare une requête de mise à jour d'un utilisateur
        $update = $this->connection->prepare(
            'UPDATE user ' . 
            'SET email=:param_email, '.
                'password=:param_password, '.
                'avatar=:param_avatar ' . 
            'WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de mise à jour
        $update->execute([
            'param_email'    => $user->getEmail(),
            'param_password' => $user->getPassword(),
            'param_avatar'   => $user->getAvatar(),
            'param_id'       => $user->getId(),
        ]);
    }

    /**
     * Supprime un utilisateur de la base de données.
     */
    public function remove(User $user) {
        // Prépare la requête de suppression
        $delete = $this->connection->prepare(
            'DELETE FROM user WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de suppresion
        $delete->execute([
            'param_id' => $user->getId(),
        ]);
    }
}
