<?php
include("config.php");

if(!isset($_SESSION['id'])){
	header("Location: login.php");
	exit();
}

foreach($sql->query("select isvip from users where id=" . $_SESSION['id'] . ";") as $v){
	$row = $v;
}
if($row['isvip'] == 1){
	if(isset($_GET['id'])){
		foreach($sql->query("select * from article where id=" . intval($_GET['id']) . ";") as $v){
			$row = $v;
		}
		if($_SESSION['id'] == $row['userid']){
			include("templates/replace.html");
			exit();
		}else{
			exit("<script>alert('You do not have permission.');history.go(-1);</script>");
		}
	}	

	if(isset($_POST['find']) && isset($_POST['replace']) && isset($_POST['id'])){
		foreach($sql->query("select * from article where id=" . intval($_POST['id']) . ";") as $v){
			$row = $v;
		}
		if($_SESSION['id'] == $row['userid']){
			if(isset($_POST['regex']) && $_POST['regex'] == '1'){
				$content = addslashes(preg_replace("/" . $_POST['find'] . "/", $_POST['replace'], $row['content']));
				$sql->query("update article set content='$content' where id=" . $row['id'] . ";");
				exit("<script>alert('Replaced successfully.');location.href='index.php';</script>");
			}else{
				$content = addslashes(str_replace($_POST['find'], $_POST['replace'], $row['content']));
				$sql->query("update article set content='$content' where id=" . $row['id'] . ";");
				exit("<script>alert('Replaced successfully.');location.href='index.php';</script>");
			}
		}else{
			exit("<script>alert('You do not have permission.');history.go(-1);</script>");
		}
	}
}else{
	exit("<script>alert('You are not VIP so you cannot use this function.');history.go(-1);</script>");
}