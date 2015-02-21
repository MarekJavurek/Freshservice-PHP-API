# Freshservice-PHP-API
API for managing tickets in Freshservice.com

Example:
~~~~
<?php

namespace MyApplication;

use Freshservice as FS;

include_once ("./Freshservice.class.php");
include_once ("./FreshserviceException.class.php");
include_once ("./LoginCredentials.class.php");
include_once ("./RestCommands.class.php");

// login
$lc = FS\LoginCredentials::authenticateWithToken("t2f7K14smC4DPUdfEoc");
$fs = new FS\Freshservice("http://czu.freshservice.com", $lc);
// get all tickets
$response = $fs->Exec("/helpdesk/tickets.json", FS\RestCommands::GET);
return $response;
~~~~
