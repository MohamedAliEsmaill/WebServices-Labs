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

$itemId = isset($_GET['id']) ? $_GET['id'] : null;
$selectedItem = $capsule->table("items")->select()->where('id', $itemId)->first();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glasses Shop</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
<h1>Item Details</h1>
<div class="details-container">
    <table>
        <tr>
            <td><b>Type:<?php echo $selectedItem->product_name; ?></b></td>
            <td><b>Price:<?php echo $selectedItem->list_price; ?></b></td>
        </tr>
        <tr>
            <td>
                <b>Details:</b><br>
                <p>Code:<?php echo $selectedItem->PRODUCT_code; ?></p>
                <p>Item Id:<?php echo $selectedItem->id; ?></p>
                <p>Rating:<?php echo $selectedItem->Rating; ?></p>
            </td>
            <td>
                <img src="images/<?php echo $selectedItem->Photo; ?>" alt="Item Image">
            </td>
        </tr>
    </table>
</div>
</body>
</html>