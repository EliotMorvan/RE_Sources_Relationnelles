<?php

require 'boot.php';

use Repository\UserRepository;
use Security\Security;

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$users = $repository->findAll();

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
                    Détail
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
<p>
    <a href="create.php">Créer un nouvel utilisateur</a>
</p>

