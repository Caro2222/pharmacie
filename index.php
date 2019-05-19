<?php
define("ABSOLUTE_ROOT_PATH",__DIR__);
include "lib/Router.class.php";
include "lib/Kernel.class.php";
include "lib/Database.php";
include "lib/Flashbag.php";
$kernel = new Kernel();
$kernel->bootstrap();

try
{
    //demarrer udput buffering
    ob_start();
    $kernel->run();
    ob_end_flush();
} catch (Exception $exception)
{
    ob_start();
    $kernel->renderError(implode("<br>",[$exception->getMessage(),
        "<strong>Fichier</strong>".$exception->getFile(),
        "<strong>Ligne</strong>".$exception->getLine()]));
}