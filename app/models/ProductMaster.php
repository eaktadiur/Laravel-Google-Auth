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
    							pm.brand = ?", array($q));
    	return $data;
    }

    public static function getProduct($id){

        $sql = "SELECT pm.sku, pm.supplier, pm.brand, pm.name, 
                                pm.sell_price, pm.qty, 
                                mi.product_code, mpi.url_key, pm.date_added 
                                
                                FROM product_master pm 
                                LEFT JOIN motochanic_inventory mi ON mi.product_code = pm.sku 
                                LEFT JOIN magento_products_inventory mpi ON mpi.sku = pm.sku 
                                WHERE pm.name = :sku_name";
        return 'Rajib';

    }

    public static function createCPSA($attributes)
    {
        foreach ($attributes as $attribute) {
        $label = ucwords($attribute);
        
        
        $cpsa_query = "INSERT magento_cpsa_staging (
            `sku`,
            `attribute_code`,
            `position`,
            `label`
            )

        SELECT
        '$configurable_parent_sku',
        '$attribute',
        '$position',
        '$label';
        ";
        DB::query($cpsa_query);
        $position = $position + 1;

        } # for each attribute
    }

    public static function createCPSI($sku, $configurable_parent_sku)
    {
        $cpsi_query = "INSERT magento_cpsi_staging (
                `sku`,
                `linked_sku`
                )
                SELECT
                '$sku',
                '$configurable_parent_sku' ";
                DB::query($cpsi_query);
    }
}