<?php

require 'boot.php';

use Security\Security;

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

header('Location: Ressource/listeRessources.php');
exit;