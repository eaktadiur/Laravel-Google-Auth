<?php

class ProductMaster extends \Eloquent {

	protected $table = 'product_master';
	protected $fillable = array();

	public static function products($q)   {
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

        $data = DB::select("SELECT pm.sku, pm.supplier, pm.brand, pm.name, 
            pm.sell_price, pm.qty, 
            mi.product_code, mpi.url_key, pm.date_added 

            FROM product_master pm 
            LEFT JOIN motochanic_inventory mi ON mi.product_code = pm.sku 
            LEFT JOIN magento_products_inventory mpi ON mpi.sku = pm.sku 
            WHERE pm.name = '$id'");
        $data = !empty($data) ? $data[0] : '';

        return $data;

    }

    public static function createCPSA($attributes='')
    {
        $configurable_parent_sku = '';
        $position = 1;
        foreach ($attributes as $attribute) {
            $label = ucwords($attribute);

            DB::table('magento_cpsa_staging')->insert(
                array('sku' => $configurable_parent_sku, 
                    'attribute_code' => $attribute,
                    'position' => $position,
                    'label' => $label ));
            $position = $position + 1;
        } 
    }

    public static function createCPSI($sku, $linked_sku)
    {

        DB::table('magento_cpsi_staging')->insert(array('sku' => $sku, 'linked_sku' => $linked_sku) );

    }
}