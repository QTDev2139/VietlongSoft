<?php
error_reporting(1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


include_once("class/clsdatabase.php");
require("layout/header.php");

if(isset($_GET["cate"]))
    $cate = $_GET["cate"];


if(isset($_GET["page"]))
    $page = $_GET["page"];

if(file_exists("page/$page/index.php"))
    include("page/$page/index.php");
else 
    include("page/404/index.php");


include_once("./layout/footer.php");

?>