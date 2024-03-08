<?php
require_once "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

try{
    $capsule = new Capsule;
    $capsule->addConnection([
       "driver" => "mysql",
       "host" =>__HOST__,
       "database" => __DB__,
       "username" => __USER__,
       "password" => __PASS__
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
}catch(\Exception $e){
  die("Error: ". $e->getMessage());
}

$items = $capsule->table("items")->select()->get()->toArray();
//var_dump($items);
$recordsPerPage = __RECORDS_PER_PAGE__;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($currentPage - 1) * $recordsPerPage;
$paginatedItems = array_slice($items, $start, $recordsPerPage);

require_once("views/glasses_table.php");
?>
