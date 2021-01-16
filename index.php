<?php

require 'boot.php';

use Repository\UserRepository;
use Security\Security;

$repository = new UserRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

header('Location: Ressource/listeRessources.php');
exit;