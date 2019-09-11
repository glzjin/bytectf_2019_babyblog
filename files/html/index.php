<?php
include("config.php");

if(!isset($_SESSION['id'])){
	header("Location: login.php");
	exit();
}

$article = array();
foreach($sql->query("select * from article where userid=".$_SESSION['id'].";") as $row){
	array_unshift($article, $row);
}

include("templates/index.html");