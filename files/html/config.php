<?php
error_reporting(0);
session_start();

$sql = new PDO("mysql:host=127.0.0.1;dbname=babyblog", 'root', 'root') or die("SQL Server Down T.T");

function SafeFilter(&$arr){
	foreach ($arr as $key => $value) {
		if (!is_array($value)){
			$filter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\")|(\+|-|~|!|@:=|" . urldecode('%0B') . ").+?)FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
			if(preg_match('/' . $filter . '/is', $value)){
				exit("<script>alert('Failure!Do not use sensitive words.');location.href='index.php';</script>");
			}
		}else{
			SafeFilter($arr[$key]);
		}
	}
}

$_GET && SafeFilter($_GET);
$_POST && SafeFilter($_POST);
