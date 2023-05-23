<?php
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 


class Product { 
    private $ProductId; 
    private $name; 
    private $brand; 
    private $price; 

    public function __construct($name, $brand, $price) { 
        $this->name = $name; 
        $this->brand = $brand; 
        $this->price = $price; 
    } 

 
    public function getName() { 
        return $this->name; 
    } 

    public function getBrand() { 
        return $this->brand; 
    } 

    public function getPrice() { 
        return $this->price; 
    } 

 
    public function setName($name) { 
        $this->name = $name; 
    } 

    public function setBrand($brand) { 
        $this->brand = $brand; 
    } 

    public function setPrice($price) { 
        $this->price = $price; 
    } 
} 

class ProductManager { 
    private $products; 
    private $spreadsheet; 

    public function __construct($filename) { 
        $this->products = array(); 
        
        // Load the existing spreadsheet 
        $this->spreadsheet = IOFactory::load($filename); 
        
        // Get the active worksheet 
        $worksheet = $this->spreadsheet->getActiveSheet(); 
        
        // Read the product data from the spreadsheet and populate the $products array 
        $rows = $worksheet->toArray();
        foreach ($rows as $row) {
            $product = new Product($row[0], $row[1], $row[2]);
            $this->products[] = $product;
        }
    } 

    public function addProduct(Product $product) { 
        // Add the product to the products array and the spreadsheet 
        $this->products[] = $product; 
        $row = count($this->products); 
        $this->spreadsheet->getActiveSheet()->setCellValue("A$row", $product->getName()); 
        $this->spreadsheet->getActiveSheet()->setCellValue("B$row", $product->getBrand()); 
        $this->spreadsheet->getActiveSheet()->setCellValue("C$row", $product->getPrice()); 
        
        // Save the changes to the spreadsheet file 
        $writer = new Xlsx($this->spreadsheet); 
        $writer->save("productsAP.xlsx"); 
    } 

    public function deleteProduct(Product $product) { 
        // Delete the product from the products array and the spreadsheet 
        $key = array_search($product, $this->products, true); 
        if ($key !== false) { 
            unset($this->products[$key]); 
            $this->products = array_values($this->products); 
            // re-index the array 
            $row = $key + 2; 
            $this->spreadsheet->getActiveSheet()->removeRow($row); 
            
            // Save the changes to the spreadsheet file 
            $writer = new Xlsx($this->spreadsheet); 
            $writer->save("productsAP.xlsx"); 
        } 
    } 


    public function getAllProducts($searchTerm = "") { 
        $filteredProducts = array();
        foreach ($this->products as $product) {
            if (stripos($product->getName(), $searchTerm, offset:0) !== false) {
                $filteredProducts[] = $product;
            }
        }
        return $filteredProducts;
    } 
} 




?>
