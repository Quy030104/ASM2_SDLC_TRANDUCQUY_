<?php
//ket noi csdl
// su dung thu vien PDO de lam viec voi database

function connectionDb(){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=students_manager;charset=utf8', 'root', '');
        return $dbh; // tra ve bien ket noi
    } catch (PDOException $e) {
        // attempt to retry the connection after some timeout for example
        echo "Can not connect to database";
        print_r($e);
        die();
    }
}

// ham ngat ket noi toi database

function disconnectDb(){
    $connection = null;
}