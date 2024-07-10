<?php
    $db = new PDO('mysql:host=localhost;dbname=u67495', 'u67495', '2783790',
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    function checkAdmin($login, $password){
        global $db;
        if(isset($login) && isset($password)){
            $qu = $db->prepare("SELECT id FROM users WHERE role = 'admin' and login = ? and password = ?");
            $qu->execute([$login, md5($password)]);
            return $qu->rowCount();
        }
    }
?>