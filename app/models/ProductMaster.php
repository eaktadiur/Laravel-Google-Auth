<?php

class ProductMaster extends \Eloquent {

	protected $table = 'product_master';
	protected $fillable = array();

	public static function products($q)
    {
    	//$data = parent::where('name', 'LIKE', $q);
    	$data = DB::select("SELECT 
    							pm.sku, 
    							pm.supplier, 
    							pm.brand, 
    							pm.name, 
    							pm.sell_price, 
    							pm.qty, 
    							mi.product_code, 
    							 -- mpi.url_key, 
    							pm.date_added 
    						FROM 
    							product_master pm 
    							LEFT JOIN motochanic_inventory mi ON mi.product_code = pm.sku 
    							-- LEFT JOIN magento_products_inventory mpi ON mpi.sku = pm.sku 
    						WHERE 
    							pm.sku = ?", array($q));
    	return $data;
    }

    public static getProduct($id){

        $sql = "SELECT pm.sku, pm.supplier, pm.brand, pm.name, 
                                pm.sell_price, pm.qty, 
                                mi.product_code, mpi.url_key, pm.date_added 
                                
                                FROM product_master pm 
                                LEFT JOIN motochanic_inventory mi ON mi.product_code = pm.sku 
                                LEFT JOIN magento_products_inventory mpi ON mpi.sku = pm.sku 
                                WHERE pm.sku = :sku_name";
        return 'Rajib';

    }
}