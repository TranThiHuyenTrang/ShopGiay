<?php
	require "../Database/database.php";
	require "../Model/User.php";
	require "../Model/SportShoe.php";
	require "../Model/Sandal.php";
	session_start();

	if(isset($_POST["delete"])){
		$de = $_POST["delete"];
		$sql = "DELETE from SanPham where id = ".$de;
		$db->query($sql);
	}
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
	<link rel="stylesheet" type="text/css" href="../Css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
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
	  	<a class="active" href="../View/Admin.php">Home</a>
	  	<a href="../Fearture/Add.php">Add product</a>
	  	<a href="../View/index.php">Logout</a>
	</div>
	<div style="margin-top: 30px;display: flex;justify-content: space-between;margin-left: 150px;" id="slide">
      <div>
        <img src="../Img/logo.jpg" width="300" height="350">
      </div>
      <div style="margin-right: 150px;">
          <img  id="myId" src="../Img/fine.jpg" width="600" height="350">
      </div>
 	 </div>
	<div id ="product">
	<p><h1>LIST'S PRODUCTS</h1></p>
</div>
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
					<form action="#" method="post">
						<button class="item-shoe-edit"><a href="../Fearture/Update.php?id=<?php echo $shoes[$i]->id ?>">Edit</a></button>
					</form>	
					<form action="#" method="post">
						<button class="order" name="delete" value="<?php echo $shoes[$i]->id ?>">Delete</button>	
					</form>
				</div>		
			</div>			
		<?php
			}
		?>	
	</div>
<?php require "../View/Footer.php";?>
</body>
</html>
