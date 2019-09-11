<?php
include("config.php");

if(isset($_SESSION['id'])){
	header("Location: index.php");
	exit();
}

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = addslashes($_POST['username']);
	foreach($sql->query("select * from users where username='$username';") as $v){
		$result = $v;
	}
	if(isset($result['id']) && md5($_POST['password']) === $result['password']){
		$_SESSION['id'] = $result['id'];
		exit("<script>alert('Login successful.');location.href='index.php';</script>");
	}else{
		exit("<script>alert('username or password error');history.go(-1);</script>");
	}
}else{
	include("templates/login.html");
}