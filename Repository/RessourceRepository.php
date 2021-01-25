<?php

namespace Repository;

use Entity\Ressource;
use Entity\User;
use PDO;

class RessourceRepository {

    /** PDO */
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }
   /**
     * Returns all the Ressources.
     * 
     * @return Ressource[]
     */
    public function findAll(): array
    {
        // Récupérer la liste des ressouces
        $select = $this->connection->query(
            'SELECT ressource.id, titre, contenu, id_user, email, user.password, avatar FROM ressource JOIN USER ON USER.id = id_user'
        );

        // Liste d'utilisateurs à renvoyer
        $ressources = [];

        // Boucle sur les résultats de la requete
        while (false !== $data = $select->fetch(PDO::FETCH_ASSOC)) {
            $ressources[] = $this->buildRessource($data);
        }

        // Renvoi la liste des utilisateurs
        return $ressources;
    }
    /**
     * Finds one ressource by its id.
     * 
     * @param int $id
     * 
     * @return Ressource|null
     */
    public function findOneById(int $id): ?Ressource
    {
        $select = $this->connection->query(
            'SELECT id, titre, contenu, id_user '.
            'FROM ressource '.
            'WHERE id=' . $id . ' ' .
            'LIMIT 1'
        );

        $data = $select->fetch(PDO::FETCH_ASSOC);

        if (false === $data) {
            return null;
        }

        return $this->buildRessource($data);
    }

    private function buildRessource(array $data): Ressource
    {
        $ressource = new Ressource();
        $ressource->setId($data['id']);
        $ressource->setTitre($data['titre']);
        $ressource->setContenu($data['contenu']);
        $createur = new User ();
        $createur->setId($data['id_user']);
        $createur->setEmail($data['email']);
        $createur->setPassword($data['password']);
        $createur->setAvatar($data['avatar']);
        $ressource->setCreateur($createur);
        return $ressource;
    }
}
