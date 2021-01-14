<?php

require 'boot.php';

use Entity\User;
use Repository\UserRepository;

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


$repository = new UserRepository($connection);

$user = $repository->findOneById($id);

if (null === $user) {
    echo 'Utilisateur introuvable.';
    exit;
}

?>
<table border="1">
    <tbody>
        <tr>
            <th>Id</th>
            <td><?php echo $user->getId() ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $user->getEmail() ?></td>
        </tr>
        <tr>
            <th>Avatar</th>
            <td>
                <?php if ($name = $user->getAvatar()) { ?>
                <br><img src="<?php echo UPLOAD_DIR . $name; ?>" width="200">
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <a href="update.php?id=<?php echo $user->getId(); ?>">
                    Modifier
                </a>
                <a href="delete.php?id=<?php echo $user->getId(); ?>">
                    Supprimer
                </a>
            </td>
        </tr>
    </tbody>
</table>
<p>
    <a href="./">Retour à la liste</a>
</p>