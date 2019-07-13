<?php
$servername ="localhost";
$username = "root";
$password = "mysql";
$dbname = "furkan_guzel";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn-> connect_error){
	die("Connection failed: ". $conn->connect_error);
}
$name=explode(" ",$_POST['customer_name']);
$sql = "SELECT 
	customer.customer_name, 
	customer.customer_surname, 
	district.district_name, 
	branch.branch_name, 
	city.city_name, 
	salesman.salesman_name, 
	sale.sale_date, 
	price as TOTAL_SALE_PRICE, 
	(1.08)* price as TOTAL_SALE_PRICE_VAT 
from 
	sale 
	JOIN product ON sale.product_id = product.product_id 
	JOIN salesman ON sale.salesman_id = salesman.salesman_id 
	JOIN customer ON sale.customer_id = customer.customer_id 
	JOIN branch on salesman.branch_id = branch.branch_id 
	JOIN city on city.city_id = branch.city_id 
	JOIN district on district.district_id = city.district_id 
where 
	customer_name = '".$name[0]."' AND customer_surname = '".$name[1]."'";
        


$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border ='1'>";
	echo "<tr><td>customer_name</td><td>customer_surname</td><td>district_name</td><td>branch_name
	</td><td>city_name</td><td>salesman_name</td><td>sale_date</td><td>TOTAL_SALE_PRICE</td><td>TOTAL_SALE_PRICE_VAT</td></tr>";

	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row["customer_name"]."</td><td>".$row["customer_surname"]."</td><td>"
		.$row["district_name"]."</td><td>".$row["branch_name"]."</td><td>" .$row["city_name"]."</td><td>" .$row["salesman_name"].
		"</td><td>".$row["sale_date"]."</td><td>".$row["TOTAL_SALE_PRICE"]."</td><td>".$row["TOTAL_SALE_PRICE_VAT"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else{
	//echo "0 results";
}
$conn->close();

?>