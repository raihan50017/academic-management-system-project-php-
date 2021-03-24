<?php


function connect_database($servername, $username, $password, $dbname){
    $connect = new mysqli($servername, $username, $password, $dbname);
    return $connect;
}
