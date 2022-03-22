<?php
if (!class_exists("db")) :
    include __DIR__ . "/../classes/db.php";
endif;
if (!class_exists("lottery")) :
    include __DIR__ . "/../classes/lottery.php";
    $lottery = new lottery();
endif;

$data = (isset($_GET["data"])) ? json_decode($_GET["data"]) : [];
$data[0] = (isset($data[0]) && trim($data[0]) != "") ? $data[0] : "dashboard";

switch ($data[0]):
    case "users":
        include "pages/users/users.php";
        break;
    case "drafts":
        include "pages/drafts/drafts.php";
        break;
    case "tickets":
        include "pages/tickets/tickets.php";
        break;
    default:
        include "pages/dashboard/dashboard.php";
        break;
endswitch;
