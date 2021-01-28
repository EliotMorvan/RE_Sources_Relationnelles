<?php

namespace Security;

use Entity\User;
use Repository\UserRepository;
use Repository\RessourceRepository;

class Security {
    public const KEY = 'user_id';

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var \Entity\User
     */
    private $user;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCurrentUserId(): ?int
    {
        // Si la session contient l'identifiant de l'utilisateur
        if (isset($_SESSION[self::KEY])) {
            return intval($_SESSION[self::KEY]);
        } else {
            return -1;
        }
    }

    public function denyAccessUntilAuthenticated(): void
    {
        // Test déjà effectué
        if (null !== $this->user) {
            return;
        }

        // Si la session contient l'identifiant de l'utilisateur
        if (isset($_SESSION[self::KEY])) {
            $id = intval($_SESSION[self::KEY]);

            // Récupère l'utilisateur
            $this->user = $this->repository->findOneById($id);
        }

        // Si l'utilisateur n'a pas été récupéré
        if (null === $this->user) {
            http_response_code(403); // Access denied HTTP response code
            // Redirige vers la page login
            header('Location: login.php');
            exit;
        }
    }
}
