<?php

require '../boot.php';

use Repository\UserRepository;
use Security\Security;
use Repository\RessourceRepository;

$repository = new UserRepository($connection);
$repositoryRessource = new RessourceRepository($connection);

// Securise la page
$security = new Security($repository);
$security->denyAccessUntilAuthenticated();

$users = $repository->findAll();
$ressources = $repositoryRessource->findAll();

?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div class="container">
  <h2 class="lr-h2">Liste des ressources</h2>
  <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1"></div>
      <div class="col col-2">Titre</div>
      <div class="col col-3">Créateur</div>
      <div class="col col-4">Actions</div>
    </li>
    <?php foreach ($ressources as $ressource) { ?>
     <li class="table-row">
       <div class="col col-1" data-label="id"><td><?php echo $ressource->getId() ?></td></div>
       <div class="col col-2" data-label="titre"><td><?php echo $ressource->getTitre() ?></td></div>
       <div class="col col-3" data-label="createur_email"><td><?php echo $ressource->getCreateur()->getEmail() ?></td></div>
       <div class="col col-4" data-label="actions"><td>
        <a class="btn-see" href="../Ressource/readRessource.php?id=<?php echo $ressource->getId() ?>">
            <i class="fa fa-eye"></i>
        </a>
         <a class="btn-edit" href="../Ressource/updateRessource.php?id=<?php echo $ressource->getId(); ?>">
            <i class="fa fa-edit"></i>
        </a>
         <a class="btn-delete" href="../Ressource/deleteRessource.php?id=<?php echo $ressource->getId(); ?>">
            <i class="fa fa-trash"></i>
        </a>
       </td></div>
     </li>
    <?php } ?>
    <a class="btn-create blue" href="../Ressource/creationRessource.php?id=<?php echo $ressource->getId(); ?>">
    <td>
        Créér une nouvelle ressource
     </td></a>
  </ul>
</div>
