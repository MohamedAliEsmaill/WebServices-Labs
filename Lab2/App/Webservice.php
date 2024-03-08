<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Item;

class Webservice {

    protected $items;

    public function __construct() {
        try {
            $capsule = new Capsule;
            $capsule->addConnection([
                "driver" => "mysql",
                "host" => __HOST__,
                "database" => __DB__,
                "username" => __USER__,
                "password" => __PASS__
            ]);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            $this->items = $capsule->table("items")->select()->get();
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * @api {get} /glasses list all glasses
     * @apiName ListGlasses
     * @apiGroup Glass
     * @apiVersion 1.0.0
     * @apiSuccessExample Success-Response:
     * HTTP:/1.1 200 OK
     * {
     *    "data" : [
     *              {
     *               "id": "100",
     *              "name": "new_glass very new1 ",
     *               "price": "14.00",
     *               "units_in_stock": "4",
     *               }
     *           ]
     * }
     */
    public function getGlasses() {
        return $this->items;
    }

    public function getSingleGlass($glassId) {
        $result = $this->items->where('id', '=', $glassId)->first();
        return $result;
    }

    public function insertIntoDatabase($data){
        $glass = new Item; 
        $glass->id = $data["id"];
        $glass->product_name = $data["product_name"];
        $glass->CouNtry = $data["CouNtry"];
        $glass->list_price =  $data["list_price"];
        $glass->PRODUCT_code = $data["PRODUCT_code"];
        $glass->Photo = $data["Photo"];
        $glass->reorder_level = $data["reorder_level"];
        $glass->Units_In_Stock =  $data["Units_In_Stock"];
        $glass->category =  $data["category"];
        $glass->Rating =  $data["Rating"];
        $glass->discontinued =  $data["discontinued"];
        $glass->date =  $data["date"];
        $glass->save(); 
    }
}


