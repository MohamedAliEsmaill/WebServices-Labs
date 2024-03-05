<?php
require_once("functions.php");

function get_cities()
{
    $cities_json = file_get_contents("city.list.json");
    $cities = json_decode($cities_json, true);
    $egyptian_cities = array();

    foreach ($cities as $key => $value) {
        foreach ($value as $ke => $val) {
            if ($ke === "country" && $val === "EG") {
                array_push($egyptian_cities, $cities[$key]);
            }
        }
    }
    return $egyptian_cities;
}

function get_weather($cityid)
{
    $api = _api_url . $cityid . _api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $data_arr = json_decode($data, true);


    return $data_arr;
}
function get_current_time()
{
    echo date("l") . " " . date("h") . " " . date("a") . "<br>";
    echo  date("d") . "th" . " " . date("F") . " " . date("Y") . "<br>";
}

ini_set('memory_limit', '-1');
$egyptian_cities = get_cities();
if (isset($_POST["egy_city"])) {
    $weather_data =  get_weather($_POST['egy_city']);
    foreach ($weather_data as $key => $value) {
        if ($key === 'name') echo '<h2>' . $value . ' weather status' . '</h2>';
    }
    get_current_time();

    foreach ($weather_data as $key => $value) {
        if ($key === "weather") {
            foreach ($value as $k => $val) {
                if ($k === 0) {
                    foreach ($val as $ke => $v) {
                        if ($ke === "description") echo $v . '<br>';
                    }
                }
            }
        }
        if ($key === 'main' || $key === 'wind') {
            foreach ($value as $k => $v) {
                if ($k === "temp") echo $k . " : " . $v - 273.15 . "<br>";
                if ($k === "humidity") echo $k . " : " . $v . "% <br>";
                if ($k === 'speed')  echo $key . " : " . $v . "Km/h <br>";
            }
        }
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    echo '<form method="POST">';
    echo "<select name='egy_city'>";
    foreach ($egyptian_cities as $key => $value) {
        foreach ($value as $k => $val) {
            if ($k === "id") {
                $cityid = $val;
            }
            if ($k === "name") {
                echo "<option value='$cityid' >$val</option>";
            }
        }
    }
    echo "</select>";
    echo '<button type="submit">submit</button>';
    echo "</form>";
    ?>

</body>

</html>