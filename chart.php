<?php
$servername ="localhost";
$username = "root";
$password = "mysql";
$dbname = "furkan_guzel";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn-> connect_error){
	die("Connection failed: ". $conn->connect_error);
}

$sql = "SELECT branch_name,
		sum(sale_amount * price)
		from sale 
		JOIN product ON sale.product_id = product.product_id 
		JOIN salesman ON sale.salesman_id = salesman.salesman_id 
		JOIN customer ON sale.customer_id = customer.customer_id 
		JOIN branch on salesman.branch_id = branch.branch_id 
		JOIN city on city.city_id = branch.city_id 
		JOIN district on district.district_id = city.district_id 
		where city_name = '".$_POST['branch_name']."'
		GROUP BY branch.branch_id";
$result = $conn->query($sql);
$data=array();
if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {
		$branch=$row["branch_name"];
		$amount=$row["sum(sale_amount * price)"];
		$data[$branch]=$amount;
	}
}
else{
	echo "0 results"; 
}
$conn->close();
/* pChart library inclusions */

include("pChart2.1.4/class/pData.class.php");

include("pChart2.1.4/class/pDraw.class.php");

include("pChart2.1.4/class/pPie.class.php");

include("pChart2.1.4/class/pImage.class.php");

 

/* Create and populate the pData object */

$MyData = new pData();   

$MyData->addPoints($data,"ScoreA");  
$key = array_keys($data);
$MyData->setSerieDescription("ScoreA","Application A");

 

/* Define the absissa serie */

$MyData->addPoints($key,"branch");

$MyData->setAbscissa("branch");

 

/* Create the pChart object */

$myPicture = new pImage(700,230,$MyData);

 

/* Draw a solid background */

$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);

$myPicture->drawFilledRectangle(0,0,700,230,$Settings);

 

/* Draw a gradient overlay */

$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);

$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);

$myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

 

/* Add a border to the picture */

$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));

 

/* Write the picture title */ 

$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Silkscreen.ttf","FontSize"=>6));

$myPicture->drawText(10,13,"pPie - Draw 2D pie charts",array("R"=>255,"G"=>255,"B"=>255));

 

/* Set the default font properties */ 

$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 

/* Enable shadow computing */ 

$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>150,"G"=>150,"B"=>150,"Alpha"=>100));

 

/* Create the pPie object */ 

$PieChart = new pPie($myPicture,$MyData);

 

/* Draw a simple pie chart */ 

$PieChart->draw2DPie(140,125,array("SecondPass"=>FALSE));

 

/* Draw an AA pie chart */ 
$PieChart->draw2DPie(340,125,array("DrawLabels"=>TRUE,"Border"=>TRUE));

 

/* Draw a splitted pie chart */ 

//$PieChart->draw2DPie($myPicture,$MyData,540,125,array("DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255));

 

/* Write the legend */

$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/MankSans.ttf","FontSize"=>11));

$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));

$myPicture->drawText(140,200,"Single AA pass",array("R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

$myPicture->drawText(540,200,"Extended AA pass / Splitted",array("R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 
/* Render the picture to a file */

$myPicture->Render("example.png");

?>
<!DOCTYPE html>
<html>
<body>

<img src="example.png">

</body>
</html>