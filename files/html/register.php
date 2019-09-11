<?php
include("config.php");

if(isset($_SESSION['id'])){
	header("Location: index.php");
	exit();
}

if(isset($_POST['verify'])){
	if(substr(md5($_POST['verify']), 0, 5) == $_SESSION['verify']){
		if(isset($_POST['username']) && isset($_POST['password'])){
			if(strlen($_POST['username']) > 20){
				exit("<script>alert('username too long.');history.go(-1);</script>");
			}else{
				$username = addslashes($_POST['username']);
				foreach($sql->query("select id from users where username='$username';") as $v){
					$row = $v;
				}
				if(!isset($row['id'])){
					$password = md5($_POST['password']);
					$sql->query("insert into users (username,password,isvip) values ('$username', '$password',0);");
					foreach($sql->query("select id from users where username='$username';") as $v){
						$row = $v;
					}
					$sql->query("insert into article (userid,title,content) values (".$row['id'].", 'Hello, world!','Welcome to babyblog. This is your first post. Edit or delete it, then start blogging!');");
					exit("<script>alert('Register successful.');location.href='login.php';</script>");
				}else{
					exit("<script>alert('Username already exists!');history.go(-1);</script>");
				}
			}
		}else{
			exit("<script>alert('Username or password cannot be blank.');history.go(-1);</script>");
		}
	}else{
		exit("<script>alert('Verification code error.');history.go(-1);</script>");
	}
}else{
	$_SESSION['verify'] = substr(md5(mt_rand()), 0, 5);
	include("templates/register.html");
}