<?php

require 'boot.php';

use Entity\User;
use Manager\UserManager;
use Validator\UserValidator;
use Repository\UserRepository;
use Security\Security;
use Http\Response;

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$uploadDir = './upload';

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

$user = $repository->findOneById($id);

if (null === $user) {
    echo 'Utilisateur introuvable.';
    exit;
}

// Si le formulaire a été soumis
// ('update_user' correspond à l'attribut 'name' du bouton submit)
if (isset($_POST['update_user'])) {
    // Récupérer les données du formulaire
    $user
        ->setEmail($_POST['email'])
        ->setPassword($_POST['password']);

    // Valide l'objet user
    $validator = new UserValidator();
    $errors = $validator->validate($user);

    // Upload du fichier
    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $name = $_FILES['avatar']['name'];
        $type = $_FILES['avatar']['type'];

        // Récupère l'extension de fichier dans le nom d'origine
        $extension = pathinfo($name, PATHINFO_EXTENSION); // ex: gif

        // Génère un nom de fichier aléatoire
        $name = bin2hex(random_bytes(8)) . '.' . $extension;

        if (!in_array($type, ['image/gif', 'image/jpeg', 'image/png'])) {
            $errors['avatar'] = "Veuillez sélectionner une image.";
        } elseif (move_uploaded_file($tmp_name, UPLOAD_DIR . $name)) {
            $user->setAvatar($name);
        } else {
            $errors['avatar'] = "Erreur lors de l'upload de l'avatar.";
        }
    }

    $manager = new UserManager($connection);
    $manager->update($user);

    // Rediriger l'internaute
    Response::redirect('read.php?id=' . $user->getId());
}

?>
<!-- Attention à l'attribut action : préciser l'identifiant de l'utilisateur -->
<!-- Attention à l'attribut "enctype" pour que l'upload fonctionne ! -->
<form action="update.php?id=<?php echo $user->getId(); ?>"
      enctype="multipart/form-data"
      method="post">
    <p>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" 
               value="<?php echo $user->getEmail(); ?>">
    </p>
    <p>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password"
               value="<?php echo $user->getPassword(); ?>">
    </p>
    <!-- Champ upload -->
    <p>
        <label for="avatar">Avatar</label>
        <input type="file" id="avatar" name="avatar">
        <?php if ($name = $user->getAvatar()) { ?>
        <br><img src="<?php echo UPLOAD_DIR . $name; ?>" width="200">
        <?php } ?>
    </p>
    <p>
        <button type="submit" name="update_user">
            Mettre à jour
        </button>
    </p>
</form>