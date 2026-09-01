<?php
 require_once __DIR__ . '/EnvLoader.php';
 EnvLoader::load();

 class Conexao{
 public static $instance;

 public static function getInstance()
 {
 if(!isset(self::$instance))
 {
 $host = getenv('DB_HOST') ?: 'localhost';
 $dbname = getenv('DB_NAME') ?: '';
 $user = getenv('DB_USER') ?: '';
 $pass = getenv('DB_PASS') ?: '';

 self::$instance =
 new PDO(
 "mysql:host=$host;dbname=$dbname;",
 $user,
 $pass,
 array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
 );

 self::$instance->setAttribute(
 PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
 );
 }
 return self::$instance;
 }

 }
?>