<?php

namespace Manager;

use Entity\Ressource;
use PDO;

class RessourceManager {

    /** PDO */
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Ajoute une ressources dans la base données.
     */
    public function insert(Ressource $ressource) {
        // Prépare une requête d'insertion d'une ressource
        $insert = $this->connection->prepare(
            'INSERT INTO ressource(titre, contenu, id_user) 
            VALUES (:titre, :contenu, :id_user);'
        );

        // Execute la requête d'insertion
        $insert->execute([
            'titre'    => $ressource->gettitre(),
            'contenu' => $ressource->getcontenu(),
            'id_user' => $ressource->getcreateur(),
        ]);

        // Mettre à jour l'identifiant
        $ressource->setId($this->connection->lastInsertId());
    }

    /**
     * Mets à jour la ressource dans la base de données.
     */
    public function update(Ressource $ressource) {
        // Prépare une requête de mise à jour d'un utilisateur
        $update = $this->connection->prepare(
            'UPDATE ressource ' . 
            'SET titre=:param_titre, '.
                'contenu=:param_contenu, '.
                'id_user=:param_id_user, '.
            'WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de mise à jour
        $update->execute([
            'param_titre'  => $ressource->gettitre(),
            'param_contenu' => $ressource->getcontenu(),
            'param_id_user' => $ressource->getcreateur(),
            'param_id'   => $ressource->getId(),
        ]);
    }

    /**
     * Supprime un utilisateur de la base de données.
     */
    public function remove(Ressource $ressource) {
        // Prépare la requête de suppression
        $delete = $this->connection->prepare(
            'DELETE FROM ressource WHERE id=:param_id LIMIT 1'
        );

        // Execute la requête de suppresion
        $delete->execute([
            'param_id' => $ressource->getId(),
        ]);
    }
}
