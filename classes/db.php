<?php

class db extends \SQLite3 {
    function __construct() {
        $this->db = $this->open(__DIR__."/../db/tickets.db");
    }
}

$db = new db();