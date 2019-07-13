<?php
ini_set('max_execution_time', 1200); 

$servername = "localhost";
$username = "root";
$password = "mysql";


$conn = mysql_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_error());
} 
$sql = "DROP DATABASE IF EXISTS furkan_guzel";
mysql_query($sql);
$sql = "CREATE DATABASE furkan_guzel";
mysql_query($sql);
$sql ="USE furkan_guzel";
mysql_query($sql);	

$sql = "CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(50) NOT NULL,
  PRIMARY KEY(`district_id`)
) ENGINE=InnoDB;";
mysql_query($sql);

$sql ="	CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) NOT NULL,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY(`city_id`),
  FOREIGN KEY fk_city_district_id (`district_id`) REFERENCES `district` (`district_id`)
) ENGINE=InnoDB;";
mysql_query($sql);

$sql ="CREATE TABLE IF NOT EXISTS `branch` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(50) NOT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY(`branch_id`),
  FOREIGN KEY fk_branch_city_id (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB;";
mysql_query($sql);
$sql ="CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `customer_surname` varchar(50) NOT NULL,
  PRIMARY KEY(`customer_id`)
) ENGINE=InnoDB;";
mysql_query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `salesman` (
  `salesman_id` int(11) NOT NULL AUTO_INCREMENT,
  `salesman_name` varchar(50) NOT NULL,
  `salesman_surname` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
   PRIMARY KEY(`salesman_id`),
   FOREIGN KEY fk_salesman_branch_id (`branch_id`) REFERENCES `branch` (`branch_id`)
) ENGINE=InnoDB;";
mysql_query($sql);
$sql ="CREATE TABLE IF NOT EXISTS `productCategory` (
  `productCategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `productCategory_name` varchar(50) NOT NULL,
   PRIMARY KEY(`productCategory_id`)
) ENGINE=InnoDB;";
mysql_query($sql);

$sql ="CREATE TABLE IF NOT EXISTS `subCategory` (
  `subCategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `subCategory_name` varchar(50) NOT NULL,
  `productCategory_id` int(11) NOT NULL,
   PRIMARY KEY(`subCategory_id`),
   FOREIGN KEY fk_subCategory_productCategory_id (`productCategory_id`) REFERENCES `productCategory` (`productCategory_id`)
) ENGINE=InnoDB;";
mysql_query($sql);
$sql ="CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `price` double DEFAULT 0,
  `subCategory_id` int(11) NOT NULL,
  `barkod_isbn` int(20) NOT NULL,
   PRIMARY KEY(`product_id`),
   FOREIGN KEY fk_product_subCategory_id (`subCategory_id`) REFERENCES `subCategory` (`subCategory_id`)
) ENGINE=InnoDB;";
mysql_query($sql);
$sql ="CREATE TABLE IF NOT EXISTS `sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_date` date NOT NULL,
  `sale_amount` double DEFAULT 0,
  `salesman_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
   PRIMARY KEY(`sale_id`),
   FOREIGN KEY fk_sale_customer_id (`customer_id`) REFERENCES `customer` (`customer_id`),
   FOREIGN KEY fk_sale_salesman_id (`salesman_id`) REFERENCES `salesman` (`salesman_id`),
   FOREIGN KEY fk_sale_product_id (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB;";
mysql_query($sql);


$filename = "csv/district.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE DISTRICT
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(district_name);";
mysql_query($sql);		
$filename = "csv/city.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE CITY
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(city_name,district_id);";
mysql_query($sql);	
$filename = "csv/branch.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE BRANCH
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(branch_name,city_id);";
mysql_query($sql);	
$filename = "csv/customer.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE CUSTOMER
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(customer_name,customer_surname);";
mysql_query($sql);	
$filename = "csv/salesman.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE SALESMAN
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(salesman_name,salesman_surname,branch_id);";
mysql_query($sql);	
$filename = "csv/productCategory.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE productCategory
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(productCategory_name);";
mysql_query($sql);	
$filename = "csv/subCategory.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE subCategory
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(subCategory_name,productCategory_id);";
mysql_query($sql);	
$filename = "csv/product.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE PRODUCT
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(product_name,price,subCategory_id,barkod_isbn);";
mysql_query($sql);		


$filename = "csv/sale.csv";

$sql = "LOAD DATA LOCAL INFILE '".$filename."'
		INTO TABLE sale
		FIELDS TERMINATED  BY ';'
		LINES TERMINATED BY '\r\n'
		(sale_date,sale_amount,salesman_id,customer_id,product_id);";

mysql_query($sql);

  mysql_close($conn);
  echo "well done!";
?>
