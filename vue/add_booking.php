<?php $date_du_jour = date('Y-m-d');  ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Pré-Réservation</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
    <header class="main-header">
        <div class="main-header-container">
            <h1 class="centre">Pré-réservation</h1>
            <?php require("../vue/nav.php"); ?>
            <p class="slogan">Réserver une chambre en quelques clics </p>
        </div>
    </header>
    
    <div id="wrapper">
        <?php if (isset($_GET["msg"])) : ?>
            <div class="msg" id="confirm">
                <p><?php print($_GET["msg"]) ?></p>
                <input type="button" value="Fermer" onclick="fermer_msg()"/> 
            </div>
        <?php endif ?>
        <form action="add_booking.php" method="POST" name="form" class="formu">
            <fieldset>
                <p class="clearfix">
                    <!-- <label for="debut" class="fl-l w25 left">Date de début :</label> -->
                    <input type="date" min="<?php echo $date_du_jour; ?>" name="debut" value="debut" class="fl-l w50" required>
                </p>
                <p class="clearfix">
                    <!-- <label for="fin" class="fl-l w25 left">Date de fin :</label> -->
                    <input type="date" min="<?php echo $date_du_jour; ?>" name="fin" class="fl-l w50" required>
                </p>
                <p class="clearfix">
                    <!-- <label for="hotel" class="fl-l w25">Hotel : </label> -->
                    <?php if (!empty($hotels)) : ?>
                        <select name="hotel" class="fl-l w25" required>
                            <?php foreach ($hotels as $hotel) : ?>
                                <option value="<?php echo $hotel['id'] ?>"><?php echo $hotel['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    <?php else : ?>
                        <li class="nodata">Aucun hotel enregistré dans la BDD pour le moment

                        </li>
                    <?php endif ?>
                </p>

                <p class="clearfix">
                    <!-- <label for="nom" class="fl-l w25 left">Votre Nom :</label> -->
                    <input type="text" name="nom" placeholder="Votre nom" autocomplete="on" class="fl-l w50" required>
                </p>

                <p class="clearfix">
                    <!-- <label for="email" class="fl-l w25">Votre e-mail</label> -->
                    <input type="email" name="email" placeholder="Votre Email" autocomplete="on" class="fl-l w50" required>
                </p>

                <input type="hidden" id="date" name="date" value="<?php echo $date_du_jour ?>" />

                <p class="clearfix bt-rechercher" id="envoyer">
                    <input class="bt-rechercher" type="submit" name="validation" value="Rechercher">
                </p>
            </fieldset>
        </form>
        
        <?php require("../vue/galerie.php") ?>
    </div>
    <?php require("../vue/footer.php") ?>
    <script>
        function fermer_msg() {
            document.getElementById('confirm').style.visibility = 'hidden';
        }
    </script>
</body>

</html>