<?php
require_once("../../functions/auth.php");
forcer_utilisateur_connecte();
est_connecte();
require_once("../../ConnectionToBD.php");

ConnectionToBD::setNamePassword($_SESSION["user"],$_SESSION['pwd'], "medical", ""); 
$db = ConnectionToBD::initialization();
$response = $db->prepare("delete from dossier_patient where id = :id") ; 
$suppression = $response->execute(["id" => $_GET['id']]) ; 

header("Location: /tables/table-medecin/index.php?s=".$suppression);
 