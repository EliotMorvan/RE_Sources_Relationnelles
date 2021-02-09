<?php

require '../boot.php';

use Entity\User;
use Entity\Ressource;
use Manager\RessourceManager;
use Validator\RessourceValidator;
use Repository\RessourceRepository;
use Security\Security;
use Http\Response;

$repository = new RessourceRepository($connection);

// Securise la page
//$security = new Security($repository);
//$security->denyAccessUntilAuthenticated();


// localhost:8000/update.php?id=1
// Si l'index 'id' existe dans les paramètres d'URL ($_GET)
if (isset($_GET['id']) && 0 < $_GET['id']) {
    // Récupère l'identifiant
    $id = $_GET['id'];
} else {
    // Sinon page d'erreur
    echo "Page introuvable";
    exit;
}

$ressource = $repository->findOneById($id);

if (null === $ressource) {
    echo 'Utilisateur introuvable.';
    exit;
}

// Si le formulaire a été soumis
// ('update_ressource' correspond à l'attribut 'name' du bouton submit)
if (isset($_POST['update_ressource'])) {
    // Récupérer les données du formulaire
    $ressource
        ->setTitre($_POST['titre'])
        ->setContenu($_POST['contenu']);

    // Valide l'objet user
    $validator = new RessourceValidator();
    $errors = $validator->validate($ressource);

    $manager = new RessourceManager($connection);
    $manager->update($ressource);

    // Rediriger l'internaute
    Response::redirect('../Menu/menu.php');
}

?>
<link rel="stylesheet" type="text/css" href="../trix-main/dist/trix.css">
<link rel="stylesheet" type="text/css" href="creationRessource.scss">
<link rel="stylesheet" type="text/css" href="ressource.scss">
<script type="text/javascript" src="../trix-main/dist/trix.js"></script>
<!-- Attention à l'attribut action : préciser l'identifiant de l'utilisateur -->
<!-- Attention à l'attribut "enctype" pour que l'upload fonctionne ! -->

<form class="crea-res-form"
      action="updateRessource.php?id=<?php echo $ressource->getId(); ?>" 
      enctype="multipart/form-data"
      method="post">
    <p>
        <label class="crea-res-label" for="titre">Titre</label>
        <input class="crea-res-input" type="text" id="titre" name="titre"
               value="<?php echo $ressource->getTitre(); ?>">
        <?php if (isset($errors['titre'])) { ?>
        <br><span style="color:red"><?php echo $errors['titre']; ?></span>
        <?php } ?>
    </p>
    <p>
        <label class="crea-res-label" for="contenu">Contenu</label>
        <input class="crea-res-input" id="contenu" type="hidden" name="contenu"
           value="<?php echo $ressource->getContenu(); ?>">
        <trix-editor input="contenu"></trix-editor>
        <?php if (isset($errors['contenu'])) { ?>
        <br><span style="color:red"><?php echo $errors['contenu']; ?></span>
        <?php } ?>
    </p>
    <p>
    <button class="btn-create blue" type="submit" name="update_ressource">
        Mettre à jour
    </button>
    </p>
</form>