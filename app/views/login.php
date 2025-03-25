<?php
    $base_url = Flight::get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base_url ?>/public/assets/css/loginEmp.css">
    <title>Connexion</title>
</head>

<body>

    <div class="login">
        <form action="doLogin" method="POST">
            <fieldset>
                <h1>Connexion</h1>
                <label for="nom">Nom de departement : </label>
                <input type="text" name="nomDept" id="nom" placeholder="Ex: Finance">

                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" id="mdp" placeholder="************************">

                <button type="submit">Se connecter</button>
                <?php
                    if (isset($erreur)) { ?>
                        <div class="error">
                            <?= $erreur; ?>
                        </div>
                    <?php } ?>
            </fieldset>
        </form>
    </div>

</body>

</html>