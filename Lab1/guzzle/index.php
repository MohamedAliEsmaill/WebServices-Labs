<?php

require_once("./vendor/autoload.php");

$all_cities = file_get_contents("city.list.json");
$json_cities = json_decode($all_cities, true); //true to decode into array 
$egyptianCities = array_filter($json_cities, "get_egyptianCities");
$appiKey = "a22526416c6c50c498226813c02c4170";
if (!empty($_POST)) {
    if (isset($_POST["submit"])) {
        $city_id = $_POST["city"];
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&appid=" . $appiKey;
        $client=new \GuzzleHttp\Client();
        $response = $client->get($apiUrl);
        $data = json_decode($response->getBody(), true);
        $date = date("d-m-y h:i:sa");
        $icon = "https://openweathermap.org/img/wn/". $data["weather"][0]["icon"] ."@2x.png";        
        if (!empty($data)) {
            die('<body >
            <div style=";
            width:50%;
            margin:8vh auto;
            padding:3%;
            background-color: white;
            border-radius: 20px;">'
                . '<center><h2>' . $data["name"] . ' Weather Status</h2></br>'
                . "<p> Today is: " . $date . "</p>"
                . "<p> Description:  " . $data["weather"][0]["description"] . "</p>"
                . '<img src="' . $icon . '" alt="">'
                ."<p> Min_Temp:  ".$data["main"]["temp_min"]."&degF</p>"
                ."<p> Max_Temp:  ".$data["main"]["temp_min"]."&degF</p>"
                ."<p> Humidity:  ".$data["main"]["humidity"]."%</p>"
                ."<p> Wind:  ".($data["wind"]["speed"])." Km/h</p>"
                ."<a href='http://localhost/webServices/Lab1/guzzle'>BACK</a>"
                . '</center>' .
                '</div></body>');
        }
    }
}
require_once("weather.php");