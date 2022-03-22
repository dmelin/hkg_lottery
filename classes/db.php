<?php

class db extends \SQLite3
{
    function __construct()
    {
        $this->db = $this->open(__DIR__ . "/../db/tickets");
    }
}

$db = new db();

function createID()
{
    $value = strtoupper(base_convert(microtime(true), 10, 32));
    return str_replace(" ", "-", trim(chunk_split($value, 3, " ")));
}

if (isset($_POST["action"])) {
    switch ($_POST["action"]):
        case "create_ticket":
            if (isset($_POST["count"]) && isset($_POST["user"])) :
                for ($i = 0; $i < $_POST["count"]; $i++) :
                    usleep(10);
                    $ticket_id = createID();
                    $date = gmdate("Y-m-d H:i:s");
                    $sql = "
                    insert into tickets
                    (ID, user_ID, ticket_created)
                    values
                    ('$ticket_id', {$_POST["user"]}, '$date')
                    ";
                    $db->query($sql);
                endfor;
            endif;
            header("location: /tickets");
            break;
    endswitch;
}
