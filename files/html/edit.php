<?php
include("config.php");

if(!isset($_SESSION['id'])){
	header("Location: login.php");
	exit();
}

if(isset($_GET['id'])){
	foreach($sql->query("select * from article where id=" . intval($_GET['id']) . ";") as $v){
		$row = $v;
	}
	if($_SESSION['id'] == $row['userid']){
		include("templates/edit.html");
		exit();
	}else{
		exit("<script>alert('You do not have permission.');history.go(-1);</script>");
	}
}

if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])){
	foreach($sql->query("select * from article where id=" . intval($_POST['id']) . ";") as $v){
		$row = $v;
	}
	if($_SESSION['id'] == $row['userid']){
		$title = addslashes($_POST['title']);
		$content = addslashes($_POST['content']);
		$sql->query("update article set title='$title',content='$content' where title='" . $row['title'] . "';");
		exit("<script>alert('Edited successfully.');location.href='index.php';</script>");
	}else{
		exit("<script>alert('You do not have permission.');history.go(-1);</script>");
	}
}