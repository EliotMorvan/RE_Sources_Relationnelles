<?php

require '../boot.php';

use Entity\Ressource;
use Entity\User;
use Manager\RessourceManager;
use Validator\RessourceValidator;
use Http\Response;
use Repository\RessourceRepository;
use Repository\UserRepository;
use Security\Security;

$Repository = new RessourceRepository($connection);
//$userRepository = new UserRepository($connection);

// Securise la page
//$security = new Security($Repository);
//$security->denyAccessUntilAuthenticated();

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

$ressource = $Repository->findOneById($id);

if (null === $ressource) {
    echo 'Ressource introuvable.';
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['delete_ressource'])) {
    // Récupère la valeur de la case à cocher
    $confirm = $_POST['confirm'] === '1';

    // Si l'internaute a confirmé
    if ($confirm) {
        $manager = new RessourceManager($connection);
        $manager->remove($ressource);

        // Rediriger l'internaute
        Response::redirect('../Ressource/listeRessources.php');
    }
}

?>
<form action="delete.php?id=<?php echo $ressource->getId(); ?>" method="post">
    <p>
        <input type="checkbox" id="confirm" name="confirm" value="1">
        <label for="confirm">Confirmer la suppression</label>
    </p>
    <p>
        <button type="submit" name="delete_ressource">
            Supprimer
        </button>
    </p>
</form>
