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
<form action="login.php" method="post">
	<p>
		<label for="email">Email</label>
		<input type="text" id="email" name="email">
	</p>
	<p>
		<label for="password">Password</label>
		<input type="password" id="password" name="password">
	</p>
    <?php if (!empty($error)) { ?>
    <p style="color:red"><?php echo $error; ?></p>
    <?php } ?>
	<p>
		<button type="submit" name="login">
			Se connecter
		</button>
	</p>
</form>
