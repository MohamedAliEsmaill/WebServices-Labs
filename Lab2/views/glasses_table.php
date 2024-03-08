<?php
use App\Models\Item;

$query = $capsule->table("items");
$searchInput = isset($_GET['search']) ? $_GET['search'] : null;

if ($searchInput) {
    $query->where('id', 'LIKE', '%' . $searchInput . '%')
          ->orWhere('product_name', 'LIKE', '%' . $searchInput . '%')
          ->orWhere('CouNtry', 'LIKE', '%' . $searchInput . '%');
    $searchedItems = $query->get()->toArray();
    $paginatedItems = array_slice($searchedItems, $start, $recordsPerPage);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["productId"];
    $productName = $_POST["productName"];
    $productCountry = $_POST["productCountry"];
    $productPrice = $_POST["productPrice"];

   $existingGlass = Item::find($productId);

   if ($existingGlass) {
    echo ' <div style="color: red;">ID already exists. Please choose a different ID.</div>';
   } else {
       $glass = new Item; 
       $glass->id = $productId;
       $glass->product_name = $productName;
       $glass->CouNtry = $productCountry;
       $glass->list_price = $productPrice;
       $glass->save(); 
   }
}
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

    <h1>Glasses List</h1>

    <!-- Search bar -->
    <div class="search-bar">
        <form method="GET">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
            <button><a href="?show_all=1" class="add-button">Show All</a></button>
            <button class="add-button" onclick="event.preventDefault(); openModal();">Add New Glass</button>
        </form>
    </div>

      <!-- Add New Glass Modal -->
      <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Add New Glass</h2>

            <form method="POST">
                <label for="productId">Product ID:</label> 
                <input type="text" id="productId" name="productId" required><br><br>
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required><br><br>
                <label for="productCountry">Country:</label>
                <input type="text" id="productCountry" name="productCountry" required><br><br>
                <label for="productPrice">Price:</label>
                <input type="text" id="productPrice" name="productPrice" required><br><br>
                <button type="submit">Add Glass</button>
            </form>
        </div>
    </div>

    <table>
        <tr>
            <td><b>Item ID</b></td>
            <td><b>Name</b></td>
            <td><b>Details</b></td>
        </tr>

        <?php
           foreach($paginatedItems as $item) {
            echo "<tr>";
            echo "<td>".$item->id."</td>";
            echo "<td>".$item->product_name."</td>";
            echo '<td><span class="details-link" onclick="showDetails('.$item->id.')">More</span></td>';
            echo "</tr>";
           }
        ?>
    </table>

    <div class="pagination">
        <?php
        $totalPages = ceil(count($items) / $recordsPerPage);

        if ($currentPage > 1) {
            echo '<a href="?page='.($currentPage - 1).'&search=' .($searchInput) . '">Previous</a>';
        }

        if ($currentPage < $totalPages) {
            echo '<a href="?page='.($currentPage + 1).'&search=' .($searchInput) .'">Next</a>';
        }
        ?>
    </div>

    <script>
        function showDetails(itemId) {
            window.location.href = 'details.php?id=' + itemId;
            require_once("details.php");
        }

        function openModal() {
            document.getElementById('addModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('addModal').style.display = 'none';
        }
    </script>
</body>
</html>