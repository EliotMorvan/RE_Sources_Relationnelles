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

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$uploadDir = '../upload';
$ressource = new Ressource();
$errors = [];

// Si le formulaire a été soumis
// ('create_ressource' correspond à l'attribut 'name' du bouton submit)
if (isset($_POST['create_ressource'])) { 
    // Récupérer les données du formulaire
    $ressource
        ->setTitre($_POST['titre'])
        ->setContenu($_POST['contenu'])
        ->setCreateur($_POST['id_user']);

    // Valide l'objet ressource
    $validator = new ressourceValidator();
    $errors = $validator->validate($ressource);

        // Si pas d'erreur
    if (empty($errors)) {
        // Insert l'utilisateur
        $manager = new RessourceManager($connection);
        $manager->insert($ressource);

        // Rediriger l'internaute
        Response::redirect('../Ressource/listeRessources.php?id=' . $ressource->getId());
    }
}

?>
<!-- Attention à l'attribut "enctype" pour que l'upload fonctionne ! -->
<form action="creationRessource.php" 
      enctype="multipart/form-data"
      method="post">
    <p>
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre"
               value="<?php echo $ressource->getTitre(); ?>">
        <?php if (isset($errors['titre'])) { ?>
        <br><span style="color:red"><?php echo $errors['titre']; ?></span>
        <?php } ?>
    </p>
    <p>
        <label for="contenu">Contenu</label>
        <input type="contenu" id="contenu" name="contenu"
               value="<?php echo $ressource->getContenu(); ?>">
        <?php if (isset($errors['contenu'])) { ?>
        <br><span style="color:red"><?php echo $errors['contenu']; ?></span>
        <?php } ?>
    </p>
    <p>
        <label for="id_user">Createur</label>
        <input type="id_user" id="id_user" name="id_user"
               value="<?php echo $ressource->getContenu(); ?>">
        <?php if (isset($errors['id_user'])) { ?>
        <br><span style="color:red"><?php echo $errors['id_user']; ?></span>
        <?php } ?>
    </p>
        <p>
        <button type="submit" name="create_ressource">
            Enregistrer
        </button>
    </p>
</form>
