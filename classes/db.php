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
        case "save_user":
            if ($_POST["ID"] == "0") :
                $date = gmdate("Y-m-d H:i:s");
                $sql = "insert into users
                (user_name, user_email, user_phone, user_created)
                values
                ('{$_POST["name"]}', '{$_POST["email"]}', '{$_POST["phone"]}', '$date')
                ";
                $db->query($sql);
                
                $sql = "select ID from users order by ID desc limit 0, 1";
                $lastID = $db->query($sql)->fetchArray(SQLITE3_ASSOC);
                $ID = $lastID["ID"];
            else:
                $sql = "update users set
                user_name = '{$_POST["name"]}',
                user_email = '{$_POST["email"]}',
                user_phone = '{$_POST["phone"]}'
                where ID = {$_POST["ID"]}";
                $db->query($sql);
                $ID = $_POST["ID"];
            endif;

            header("location: /users/".$ID);
            break;
    endswitch;
}
