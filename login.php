<?php

use Http\Response;
use Repository\UserRepository;
use Security\Security;

require 'boot.php';

$repository = new UserRepository($connection);

$error = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $repository->findOneByEmail($email);

    if (null === $user) {
        $error = 'Utilisateur introuvable.';
    } elseif ($password === $user->getPassword()) {
        $_SESSION[Security::KEY] = $user->getId();

        Response::redirect('index.php');
    } else {
        $error = 'Le mot de passe ne correspond.';
    }
}
?>
<link rel="stylesheet" type="text/css" href="design/login.csss" media="screen"/>
<div class="login-page">
  <div class="form">
    <form action="login.php" method="post" class="login-form">
      <input type="text" placeholder="name" id="email" name="email"/>
      <input type="password" placeholder="password" id="password" name="password"/>
        <?php if (!empty($error)) { ?>
            <p style="color:red"><?php echo $error; ?></p>
        <?php } ?>  
      <button type="submit" name="login">se connecter</button>
    </form>
  </div>
</div>
