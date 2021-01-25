<?php

require 'boot.php';

use Entity\User;
use Entity\Ressource;
use Repository\UserRepository;
use Repository\RessourceRepository;

// localhost:8000/read.php?id=1
// Si l'index 'id' existe dans les paramètres d'URL ($_GET)
if (isset($_GET['id']) && 0 < $_GET['id']) {
    // Récupère l'identifiant
    $id = $_GET['id'];
} else {
    // Sinon page d'erreur
    echo "Page introuvable";
    exit;
}


$repository = new RessourceRepository($connection);

$ressource = $repository->findOneById($id);

if (null === $user) {
    echo 'Ressource introuvable.';
    exit;
}

?>
<table border="1">
    <tbody>
        <tr>
            <th>Id</th>
            <td><?php echo $ressource->getId() ?></td>
        </tr>
        <tr>
            <th>Titre</th>
            <td><?php echo $ressource->getTitre() ?></td>
        </tr>
        <tr>
            <th>Contenu</th>
            <td><?php echo $ressource->getContenu() ?></td>
        </tr>
        <tr>
            <th></th>
            <td>
                <a href="updateRessource.php?id=<?php echo $ressource->getId(); ?>">
                    Modifier
                </a>
                <a href="deleteRessource.php?id=<?php echo $ressource->getId(); ?>">
                    Supprimer
                </a>
            </td>
        </tr>
    </tbody>
</table>
<p>
    <a href="listeRessources.php">Retour à la liste</a>
</p>