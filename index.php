<?php

require 'boot.php';

use Repository\UserRepository;
use Security\Security;
use Repository\RessourceRepository;

$repository = new UserRepository($connection);
$repositoryRessource = new RessourceRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$users = $repository->findAll();
$ressources = $repositoryRessource->findAll();

?>
<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user->getId() ?></td>
            <td><?php echo $user->getEmail() ?></td>
            <td>
                <a href="read.php?id=<?php echo $user->getId() ?>">
                    Détails
                </a>
                &nbsp;
                <a href="update.php?id=<?php echo $user->getId(); ?>">
                    Modifier
                </a>
                &nbsp;
                <a href="delete.php?id=<?php echo $user->getId(); ?>">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Email</th>
            <th>Avatar</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ressources as $ressource) { ?>
        <tr>
            <td><?php echo $ressource->getId() ?></td>
            <td><?php echo $ressource->getTitre() ?></td>
            <td><?php echo $ressource->getContenu() ?></td>
            <td><?php echo $ressource->getCreateur()->getEmail() ?></td>
            <td><?php echo $ressource->getCreateur()->getAvatar() ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<p>
    <a href="create.php">Créer un nouvel utilisateur</a>
</p>

