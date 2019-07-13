<?php
$servername ="localhost";
$username = "root";
$password = "mysql";
$dbname = "furkan_guzel";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn-> connect_error){
	die("Connection failed: ". $conn->connect_error);
}
$sql = "SELECT customer_name,customer_surname,
		sum(sale_amount) ,
		sum(sale_amount * price) 
		from sale 
		JOIN product ON sale.product_id = product.product_id 
		JOIN salesman ON sale.salesman_id = salesman.salesman_id 
		JOIN customer ON sale.customer_id = customer.customer_id 
		JOIN branch on salesman.branch_id = branch.branch_id 
		JOIN city on city.city_id = branch.city_id 
		JOIN district on district.district_id = city.district_id 
		where branch_name = '".$_POST['branch_name']."'
		GROUP BY customer.customer_id";
		


$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border ='1'>";
	echo "<tr><td>customer_name</td><td>customer_surname</td><td>(Total_Sum_Amount)</td><td>(Total_Sale_Price)</tr>";

	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row["customer_name"]."</td><td>".$row["customer_surname"]."</td><td>"
		.$row["sum(sale_amount)"]."</td><td>".$row["sum(sale_amount * price)"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else{
	echo "0 results";
}
echo "<br>";
$sql = "SELECT salesman_name,salesman_surname,
		sum(sale_amount) ,
		sum(sale_amount * price) 
		from sale 
		JOIN product ON sale.product_id = product.product_id 
		JOIN salesman ON sale.salesman_id = salesman.salesman_id 
		JOIN customer ON sale.customer_id = customer.customer_id 
		JOIN branch on salesman.branch_id = branch.branch_id 
		JOIN city on city.city_id = branch.city_id 
		JOIN district on district.district_id = city.district_id 
		where branch_name = '".$_POST['branch_name']."'
		GROUP BY salesman.salesman_id";
		
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border ='1'>";
	echo "<tr><td>salesman_name</td><td>salesman_surname</td><td>(Total_Sum_Amount)</td><td>(Total_Sale_Price)</tr>";

	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row["salesman_name"]."</td><td>".$row["salesman_surname"]."</td><td>"
		.$row["sum(sale_amount)"]."</td><td>".$row["sum(sale_amount * price)"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else{
	echo "0 results";
}

$conn->close();

?>
