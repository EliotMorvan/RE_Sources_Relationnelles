<?php

?>
<body>
    <link rel="stylesheet" type="text/css" href="menu.scss" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../Ressource/ressource.scss" media="screen"/>
    <div class="menu-row">
        <div class="menu-column-1">
        <ol class="menu-ol">
            <li class="menu-li"><button class="menu-btn">Accueil</button></li>
            <li class="menu-li"><button class="menu-btn">Favoris</button></li>
            <li class="menu-li"><button class="menu-btn">Mis de côté</button></li>
            <li class="menu-li"><button class="menu-btn">Suivi</button></li>
        </ol>
        </div>
        <div class="menu-column-2">
            <div class="liste-ressource">
                <?php require('../Ressource/listeRessources.php') ?>
            </div>
        </div>
    </div>
</body>