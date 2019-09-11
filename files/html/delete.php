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
		$sql->query("delete from article where id=" . intval($_GET['id']) . ";");
		exit("<script>alert('Deleted successfully.');history.go(-1);</script>");
	}else{
		exit("<script>alert('You do not have permission.');history.go(-1);</script>");
	}
}