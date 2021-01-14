<?php

namespace Repository;

use Entity\User;
use PDO;

class UserRepository {

    /** PDO */
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Returns all the uers.
     * 
     * @return User[]
     */
    public function findAll(): array
    {
        // Récupérer la liste des utilisateurs
        $select = $this->connection->query(
            'SELECT id, email, password, avatar FROM user'
        );

        // Liste d'utilisateurs à renvoyer
        $users = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->buildUser($data);
        }

        // Renvoi la liste des utilisateurs
        return $users;
    }

    /**
     * Finds one user by its id.
     * 
     * @param int $id
     * 
     * @return User|null
     */
    public function findOneById(int $id): ?User
    {
        $select = $this->connection->query(
            'SELECT id, email, password, avatar '.
            'FROM user '.
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        return $this->buildUser($data);
    }

    /**
     * Finds one user by its email.
     * 
     * @param string $email
     * 
     * @return User|null
     */
    public function findOneByEmail(string $email): ?User
    {
        $email = $this->connection->quote($email);

        $select = $this->connection->query(
            'SELECT id, email, password, avatar ' .
            'FROM user ' .
            'WHERE email=' . $email . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        return $this->buildUser($data);
    }

    /**
     * Builds the user from the given data.
     * 
     * @param array $data
     * 
     * @return User
     */
    private function buildUser(array $data): User
    {
        $user = new User();
        $user->setId($data['id']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setAvatar($data['avatar']);

        return $user;
    }
    
}
