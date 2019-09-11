<?php
include("config.php");

if(!isset($_SESSION['id'])){
	header("Location: login.php");
	exit();
}

include("templates/about.html");