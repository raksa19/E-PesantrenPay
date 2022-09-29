<?php

class Config{

    protected function __construct($host, $user, $passwd, $database){
        $mysqli = new mysqli($host, $user, $passwd, $database);
        
        // Check connection
        if ($mysqli -> connect_errno) {
          return "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }

        return $mysqli;
    }

}
