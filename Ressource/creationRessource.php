<?php

require '../boot.php';

use Entity\User;
use Manager\UserManager;
use Validator\UserValidator;
use Http\Response;
use Repository\UserRepository;
use Security\Security;

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$uploadDir = './upload';
$user = new User();
$errors = [];

// Si le formulaire a été soumis
// ('create_user' correspond à l'attribut 'name' du bouton submit)
if (isset($_POST['create_user'])) { 
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

    // Si pas d'erreur
    if (empty($errors)) {
        // Insert l'utilisateur
        $manager = new UserManager($connection);
        $manager->insert($user);

        // Rediriger l'internaute
        Response::redirect('read.php?id=' . $user->getId());
    }
}

?>
<!-- Attention à l'attribut "enctype" pour que l'upload fonctionne ! -->
<form action="create.php" 
      enctype="multipart/form-data"
      method="post">
    <p>
        <label for="email">Email</label>
        <input type="text" id="email" name="email"
               value="<?php echo $user->getEmail(); ?>">
        <?php if (isset($errors['email'])) { ?>
        <br><span style="color:red"><?php echo $errors['email']; ?></span>
        <?php } ?>
    </p>
    <p>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password"
               value="<?php echo $user->getPassword(); ?>">
        <?php if (isset($errors['password'])) { ?>
        <br><span style="color:red"><?php echo $errors['password']; ?></span>
        <?php } ?>
    </p>
    <p>
        <label for="avatar">Avatar</label>
        <input type="file" id="avatar" name="avatar">
    </p>
    <p>
        <button type="submit" name="create_user">
            Enregistrer
        </button>
    </p>
</form>
