<?php
include("config.php");

if(!isset($_SESSION['id'])){
	header("Location: login.php");
	exit();
}

if(isset($_POST['title']) && isset($_POST['content'])){
	$title = addslashes($_POST['title']);
	$content = addslashes($_POST['content']);
	$sql->query("insert into article (userid,title,content) values (" . $_SESSION['id'] . ", '$title','$content');");
	exit("<script>alert('Posted successfully.');location.href='index.php';</script>");
}else{
	include("templates/writing.html");
	exit();
}