<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
        <h1 >Weather</h1>
        <form method="post" action="index.php">
            <select  name="city" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <?php
                foreach ($egyptianCities as $city) {
                    echo '<option value=' . $city['id'] . '>' . $city['country'] . '>>' . $city['name'] . '</option>';
                }
                ?>
            </select>
            <input id="submit" name="submit" type="submit" value="Get Weather" />
        </form>


</body>

</html>