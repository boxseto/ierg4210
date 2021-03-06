<!Doctype html>
<html>

<head>

	<meta charset="utf-8">

	<!--title for the page-->
	<link rel="shortcut icon" href="img/web_icon.ico">
	<title>Categories</title>

	<!--imported css-->
	<link rel="stylesheet" href="import/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="import/fontawesome/css/all.css">
  <link rel="stylesheet" href="import/OwlCarousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="import/OwlCarousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="import/jquery-ui/jquery-ui.css">
	
	<!--self-written css-->
	<link rel="stylesheet" href="css/index_theme.css">
	<link rel="stylesheet" href="css/cat_theme.css">
  
</head>

<body>
<!-----------------    header    --------------------------------->
	<header class="header">
		<div class="user_header row">
			<div class="container-fluid">
        <div class="row">
          <ul id="cat_list">
            <li><a href="index.php">Home</a></li>
						<?php
							$conn = new mysqli("localhost","root","toor","IERG4210");
							$sql = "SELECT * FROM categories";
							$result = $conn->query($sql);
							if($result->num_rows > 0){
								while($row = $result->fetch_assoc()){
									echo "<li><a href=\"category.php?cat=" . htmlspecialchars($row["catid"]) ."\">" . htmlspecialchars($row["name"]) . "</a></li>";
								}
							}
							$conn->close();
						?>
          </ul>
          <ul id="user_list">
            <?php
              session_start();
              if(isset($_SESSION['4210proj'])){
						   echo "<li><a>" . $_SESSION['4210proj']['em'] . "<i class=\"fas fa-user\"></i></a></li>" . 
                    "<li><a href=\"logout.php\">Sign out<i class=\"fas fa-sign-out-alt\"></i></a></li>";
							}else{
               echo "<li><a href=\"login.php\">Sign in<i class=\"fas fa-sign-in-alt\"></i></a></li>"; 
              }
            ?>
            <li>
              <a id="cart" href="#">
                Shopping cart
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
		</div>
		<div class="main_header">
			<nav class="navbar navbar-expand-lg navbar-light">
        <div class="row">
          <div class="col-1">
            <a class="navbar-brand" href="index.php">
              <img class="logo img-fluid" src="img/web_icon.png">
            </a>
          </div>
          <div class="col-11">
            <form class="search_container" action="">
              <div class="search_pt1"><input type="text" placeholder="Find what you like here.."></div>
              <div class="search_pt2"><button class="btn" type="submit"><i class="fa fa-search"></i></button></div>
            </form>
          </div>
        </div>
			</nav>
		</div>
	</header>
<!--------------------    Expended cart    --------------------------------------->
  <div class="expand_menu">
    <div id="content">
      <ul>
      </ul>
      <div class="row total">
        <p>Total:$0</p>
	<form method="POST" action="https://www.sandbox.paypal.com/cgi-bin/webscr" onsubmit="return mysubmit(this);">
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="business" value="seto@link.cuhk.edu.hk" />
		<input type="hidden" name="currency_code" value="HKD" />
		<input type="hidden" name="charset" value="utf-8" />
		<input type="hidden" name="custom" value="0" />
		<input type="hidden" name="invoice" value="0" />
		<input type="submit" class="btn btn-success float-right" id="checkout_btn" value="Checkout" />
	</form>
      </div>
    </div>
  </div>
<!--------------------    contents    --------------------------------------->
<div class="container-fluid">
  <div class="row cat_title">
<?php
	$catid = isset($_REQUEST["cat"]) ? htmlspecialchars($_GET["cat"]) : 1 ;
	$conn = new mysqli("localhost","root", "toor", "IERG4210");
	$sql = "SELECT * from categories WHERE catid=?";
	$query = $conn->prepare($sql);
	$query->bind_param('i',$catid);
	$query->execute();
	$result=$query->get_result();
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
	}
?>	
    <ul class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li><a><?php echo htmlspecialchars($row['name']);?></a></li>
    </ul>
  </div>
  <div class="row">
    <ul class="product_list">
		<?php
			$sql = "SELECT * FROM products WHERE catid=?";
			$query = $conn->prepare($sql);
			$query->bind_param('i', $catid);
			$query->execute();
			$result = $query->get_result();
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					echo"      <li id=\"" . htmlspecialchars($row["pid"]) . "\">";
					echo"        <a href=\"product.php?pid=" . htmlspecialchars($row["pid"]) . "\"><img src=\"img/products/" . htmlspecialchars($row["image"]) . "\"></a>";
					echo"        <div class=\"title\" ><a href=\"product.php?pid=" . htmlspecialchars($row["pid"]) . "\">" . htmlspecialchars($row['name']) . "</a></div>";
					echo"        <p class=\"price\">$" . htmlspecialchars($row["price"]) . "</p>";
					echo"        <a href=\"product.php?pid=" . htmlspecialchars($row["pid"]) . "\" class=\"btn btn-success details\"><i class=\"fas fa-search\"></i> Details</a>";
					echo"        <button class=\"btn btn-primary add_cart\"><i class=\"fas fa-plus\"></i> Add to cart</button>";
					echo"      </li>";
 
				}
			}
		?>

   </ul>
  </div>

<!-------------------------     Footer     ------------------------>
<footer>
  <p>Created by Seto Tsz Kin, IERG4210 proj. Hope you like it! :)</p>
  <p class="p2">(I dont know what to put here actually. but the page will seem odd if there is no footage.)</p>
</footer>



<!--imported js-->
<script src="import/jquery.js"></script>
<script src="import/bootstrap/js/bootstrap.js"></script>
<script src="import/bootstrap/js/bootstrap.bundle.js"></script>
<script src="import/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="import/OwlCarousel/dist/owl.carousel.min.js"></script>
<script src="import/jquery-ui/jquery-ui.js"></script>


<!--self-written js-->
<script src="js/index_theme.js"></script>
<script src="js/shopping_cart_index.js"></script>


</body>
</html>
