<?php
    
require __DIR__ . "/.env.php";

//no need to set up autoloader for three classes...
require __DIR__."/libraries/Maintain.php";
require __DIR__."/libraries/Emailer.php";
require __DIR__."/libraries/Security.php";

use Libraries\Maintain;

$maintainMode = new Maintain(CLIENT_PASSWORD);

$maintainMode->maintainModeChecks();


//otherwise maintain mode is off and site can function normally from here

?>