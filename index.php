<?php
include_once './Config/database.php';
include_once './Entity\Client.php';
include_once './Repository\ClientRepository.php';

$db = new DataBaseConnect();
$ClientRepo = new ClientRepository($db);


?>