<?php

class Config{
    protected $host = "localhost:3309";
    protected $user = "root";
    protected $passwd = "";
    protected $defaultdb = "epayschool";

    public static $mysql;

    function __construct()
    {
        self::$mysql = new mysqli($this->host, $this->user, $this->passwd, $this->defaultdb);
    }

    public function connect(){
        return self::$mysql;
    }
}