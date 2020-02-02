<?php
session_start();
require_once("include/functions.inc.php");
require_once("include/config.inc.php");
require_once("include/autoLoad.inc.php");
?>

<?php
$db = new MyPdo();

?>

<!doctype html>
<html lang="fr">
    <head>
        <?php require_once("include/head.inc.php") ?>
    </head>
    <body>
        <header>
            <?php require_once("include/header.inc.php") ?>
        </header>



        <main>

          <?php require_once("include/page.inc.php") ?>
        </main>

        <footer>
            <?php require_once("include/footer.inc.php"); ?>
        </footer>
    </body>
</html>
