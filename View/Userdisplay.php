<?php
	require "../Database/database.php";
	require "../Model/User.php";
	require "../Model/SportShoe.php";
	require "../Model/Sandal.php";
	session_start();
			if(isset($_POST["order"])){
			$id = $_POST["order"];
			echo $id;
			$sql = "SELECT name,price,color,type,image FROM SanPham WHERE id = ".$id;
			$result = mysqli_query($db,$sql);
			if(!$result){
				echo $sql;
				die('error');
			}else{
				while ($row = mysqli_fetch_assoc($result)) {
	    	$name=$row['name'];
        	$price=$row['price'];
        	$color=$row['color'];
        	$type=$row['type'];
		    $img= $row['image'];
		    $quantity=1;
		    $total= $price*$quantity=1;
			$db->query($sql);
			$sql1 = "INSERT INTO Cart(image,proName,price,quantity,total)VALUES ("."'".$img."'".","."'".$name."'".",".$price.",".$quantity.",".$total.")";
			echo $sql1;
			$db->query($sql1);
	}}} 

	$sql = "SELECT * from SanPham";
	$result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

	$shoes = array();
	for($i = 0; $i < count($result); $i++) {
		$shoe = $result[$i];
		if($shoe['type'] == 'sport'){
			array_push($shoes, new SportShoe($shoe['id'], $shoe['name'], $shoe['price'], $shoe['color'], $shoe['image']));
		}
		if($shoe['type'] == 'sandal'){
			array_push($shoes, new Sandal($shoe['id'], $shoe['name'], $shoe['price'], $shoe['color'], $shoe['image']));
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../Css/sty1.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../Css/style.css">
	<style type="text/css">
		.but{
			border-radius: 2px;
			border:2px solid brown;
			background: brown;
			width: 100px;
			height: 40px;
			color: white;
		}
		.flip-card {
  			background-color: transparent;
			width: 300px;
			height: 300px;
			perspective: 1000px;
		}
		.flip-card-inner {
			position: relative;
			width: 100%;
			height: 100%;
			text-align: center;
			transition: transform 0.6s;
			transform-style: preserve-3d;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
		}
		.flip-card:hover .flip-card-inner {
		  	transform: rotateY(180deg);
		}
		.flip-card-front, .flip-card-back {
		  	position: absolute;
		 	width: 100%;
		  	height: 100%;
		  	backface-visibility: hidden;
		}
		.flip-card-front {
		 	background-color: #bbb;
		  	color: black;
		}
		.flip-card-back {
		  	background-color: #2980b9;
		  	color: white;
		  	transform: rotateY(180deg);
		}
	</style>
</head>
<script type="text/javascript">
	var slide = ["../Img/hive.jpg","../Img/sandal-x.jpg","../Img/logo.jpg"];
       var position = 0;
        setInterval(function(){document.getElementById('myId').src= slide[position++];
      if (position==3)
      {
        position=0;
      }
      },3000);
        function them(){

        }
</script>
<body>
	<div class="topnav">
	  	<a class="active" href="../View/index.php">Home</a>
	  	<a href="../Fearture/Cart.php">View card</a>
	  	<a href="../View/index.php">Logout</a>
	</div>
	<div id="slide" style="margin-top: 30px;display: flex;justify-content: space-between;margin-left: 150px;">
      <div>
        <img src="../Img/logo.jpg" width="300" height="350">
      </div>
      <div style="margin-right: 150px;">
          <img  id="myId" src="../Img/fine.jpg" width="600" height="350">
      </div>
 	 </div>
	<div id ="product">
	<p><h1>LIST'S PRODUCTS</h1></p>
	<center>
		<form action="../Fearture/Search.php" method="post" >
			<input style="margin-top: 10px;width: 400px; height: 40px; border: 2px solid red;border-radius: 2px;" type="text" placeholder="Enter to search...." name="tim">
			<button class="but" type="submit" name="search">Search</button>
		</form>
	</center>
	<div class="shoe-container">
		<?php 
			for($i = 0; $i < count($shoes); $i++){
		?>	

			<div class="pro" style="margin-left: 30px;height: 500px">
				<div class="flip-card">
				  	<div class="flip-card-inner">
					    <div class="flip-card-front">
					    	<img class="item-shoe-icon" src=<?php echo $shoes[$i]->getImagePath(); ?>>
					    </div>
					    <div class="flip-card-back">
					    	<img class="item-shoe-icon" src=<?php echo $shoes[$i]->getImagePath(); ?>>
					    </div>
				  	</div>
				</div>
				<h3 class="item-shoe-name"><?php echo $shoes[$i]->name ?></h3>
				<h3 class="item-shoe-type"><?php echo $shoes[$i]->getType().",".$shoes[$i]->color ?></h3>
				<h3 class="item-shoe-price"><?php echo $shoes[$i]->getDisplayPrice() ?></h3>
				<div class="de">
					<form action="../Fearture/Detail.php" method="post">
						<button name="Detail"value="<?php echo $shoes[$i]->id ?>"class="item-shoe-edit">Detail</button>
					</form>	
					<form action="#" method="post">
						<button class="order" name="order" value="<?php echo $shoes[$i]->id ?>">Order</button>
					</form>
				</div>		
			</div>
						
		<?php
			}
		?>	
	</div>
</body>
</html>
<?php require "../View/Footer.php";?>
