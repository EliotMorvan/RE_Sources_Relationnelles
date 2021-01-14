<?php

require 'boot.php';

use Repository\UserRepository;
use Manager\UserManager;
use Http\Response;
use Security\Security;

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

// localhost:8000/delete.php?id=1
// Si l'index 'id' existe dans les paramètres d'URL ($_GET)
if (isset($_GET['id']) && 0 < $_GET['id']) {
    // Récupère l'identifiant
    $id = $_GET['id'];
} else {
    // Sinon page d'erreur
    echo "Page introuvable";
    exit;
}

$user = $repository->findOneById($id);

if (null === $user) {
    echo 'Utilisateur introuvable.';
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['delete_user'])) {
    // Récupère la valeur de la case à cocher
    $confirm = $_POST['confirm'] === '1';

    // Si l'internaute a confirmé
    if ($confirm) {
        $manager = new UserManager($connection);
        $manager->remove($user);

        // Rediriger l'internaute
        Response::redirect('index.php');
    }
}

?>
<form action="delete.php?id=<?php echo $user->getId(); ?>" method="post">
    <p>
        <input type="checkbox" id="confirm" name="confirm" value="1">
        <label for="confirm">Confirmer la suppression</label>
    </p>
    <p>
        <button type="submit" name="delete_user">
            Supprimer
        </button>
    </p>
</form>
