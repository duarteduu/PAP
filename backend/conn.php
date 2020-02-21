<?php
    date_default_timezone_set('Europe/London');
    define('host', 'localhost');
    define('username', 'root');
    define('passwd', '');
    define('dbname', 'plataforma');

    class CustomMysqli extends mysqli{
        public function __construct($host = null, $username = null, $passwd = null, $dbname = null, $port = null, $socket = null)
        {
            parent::__construct($host, $username, $passwd, $dbname, $port, $socket);
        }
        public function query($query, $resultmode = MYSQLI_STORE_RESULT)
        {
            if ($result = parent::query($query, $resultmode)){
                return $result;
            } else{
                header('Location: error.php?id=003');
                die();
            }
        }
    }

    $conn = new CustomMysqli(host, username, passwd, dbname);

    if ($conn->connect_error){
        header('Location: error.php?id=001');
        die();
    }
    $conn->set_charset('utf8');

