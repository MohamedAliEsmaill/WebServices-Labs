<?php
require './vendor/autoload.php';


$urlParts = explode('/', $_SERVER['REQUEST_URI']);

$resource = $urlParts[4];
$resourceId = (isset($urlParts[5]) && is_numeric($urlParts[5])) ? (int) $urlParts[5] : 0;

// echo $resource;
// echo $resourceId;
/**
 * 1- Define METHOD
 * 2- Define RESOURCE
 * 3- Define Resource_ID
 */
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $data = handleGet($resource, $resourceId);
        break;
    case 'POST':
        $postData = json_decode(file_get_contents("php://input"), true);
        $data = handlePost($postData, $resource, $resourceId);
        break;
    case 'PUT':
        echo "Will update";
        break;
    case 'DELETE':
        echo "Will delete";
        break;

    default:
        echo 'not supported';
        break;
}

$statusCode = is_null($data) ? 404 : 200;
http_response_code($statusCode);
header('Content-Type: application/json');

if (!empty($data)) {
    echo json_encode($data, JSON_PRETTY_PRINT);
}
/**
 * Get with no glass id (glass id = 0) => List all glasses
 * Get with glass id => get only single glass by id
 * 
 * @param string $resource
 * @param int $resourceId
 */

function handleGet($resource, $resourceId) {
    $webservice = new \App\Webservice();

    if ($resource == 'items') {
        $result = ($resourceId != 0) ? $webservice->getSingleGlass($resourceId) : $webservice->getGlasses();
        return $result;
    }

    return null;
}

function handlePost($postData, $resource, $resourceId) {

    if ($resource == 'items') {
            $dbResult = insertIntoDatabase($postData);

            if ($dbResult) {
                return $dbResult;
            } else {
                return null;
            }
        
    }
    
    return null;
}
function insertIntoDatabase($data) {
    $webservice = new \App\Webservice();
    $webservice->insertIntoDatabase($data);
    return $data; 
}