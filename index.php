<!Doctype html>
<?php
if(isset($_GET['st'])){
	if($_GET['st'] = 'Completed'){
		$conn = new mysqli("localhost","root","toor","IERG4210");
		$query = $conn->prepare("UPDATE orders SET tid=? WHERE digest=?");
		$query->bind_param('ss', $_GET['tx'], $_GET['cm']);
		$query->execute();
		$conn->close();
	}
}
?>
<html>

<head>

	<meta charset="utf-8">

	<!--title for the page-->
	<link rel="shortcut icon" href="img/web_icon.ico">
	<title>E-commerce</title>

	<!--imported css-->
	<link rel="stylesheet" href="import/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="import/fontawesome/css/all.css">
  <link rel="stylesheet" href="import/OwlCarousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="import/OwlCarousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="import/jquery-ui/jquery-ui.css">
	
	<!--self-written css-->
	<link rel="stylesheet" href="css/index_theme.css">
  
	
</head>

<body>
<div id="fb-root"></div>
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
									echo "<li><a href=\"category.php?cat=" . htmlspecialchars($row["catid"]) . "\">" . htmlspecialchars($row["name"]) . "</a></li>";
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
            <li>
              <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
            </li>
          </ul>
	<ul id="pagination"><li><a href="#today">Today's Choice</a></li><li><a href="#seller">Best sell</a></li></ul>
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
<div class="row">
<!--------------------      menu      --------------------------------------->
  <div class="col-2 categories">
    <div class="cat_title">
      <h2>Categories</h2>
    </div>
    <ul>
      <?php 
        $conn = new mysqli("localhost", "root", "toor", "IERG4210");
				if($conn->connect_error){
					die($conn->connect_error);
				}
        $sql = "SELECT * FROM categories ORDER BY catid ASC";
        $result = $conn->query($sql);
				if($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						echo "<li><a href=\"category.php?cat=" . htmlspecialchars($row["catid"])  . "\">" . htmlspecialchars($row["name"]) . "</a></li>";
					}
				}
				$conn->close();	
      ?>
    </ul>
  </div>

<!--------------------    carousel    --------------------------------------->
  <div id="demo" class="col-9 carousel slide" data-ride="carousel">

    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="img-fluid" src="img/carousel1.jpg">
        <div class="carousel-caption">
          <h3>Back To School</h3>
          <p>Gadget sales for students</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="img-fluid" src="img/carousel2.jpg">
        <div class="carousel-caption">
          <h3>Happiness</h3>
          <p>Enjoy shopping here</p>
        </div>
      </div>
      <div class="carousel-item">
        <img class="img-fluid" src="img/carousel3.jpg">
        <div class="carousel-caption">
          <h3>Vest supply chain</h3>
          <p>Adequate supply just for your need</p>
        </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>
</div>


<!--------------------    today's deal    --------------------------------------->
<div id="today" class="row best_deal">
    <div class="row title">
      <div class="col-11">
        <h2>Today's deal</h2>
      </div>
      <div class="col-1">
        <a class="btn btn-primary " href="">more</a>
      </div>
    </div>
    <div class="row" name="carousel_row">
      <div class="col-12 owl-carousel">
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html" class="item_title">Shoes</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
          
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Two Shoe</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Converse</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$700</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Wore shoes</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$150</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Good shoes</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Buy it</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Expensive two</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Fantastic shoes</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$200</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Is</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$1</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">This</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$1.</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">Loss</a>
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$11</p>
        </div>
        <div class="item">
          <a href="product.html"><img src="img/products/product1.jpg"></a>
          <div class="row" id="1">
            <div class="col-7">
              <a href="product.html"  class="item_title">?</a>   
            </div>
            <a class="col-2 btn btn-primary add_cart" href=""><i class="fas fa-plus"></i></a>
          </div>
          <p class="item_price">$1_</p>
        </div>
      </div>
    </div>

</div>



<!--------------------    Best sellers    --------------------------------------->
<div id="seller" class="row best_sellers">
    <div class="row title">
      <div class="col">
        <h2>Best sellers</h2>
      </div>
    </div>
    <div class="row">
      <ul class="table">
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="img/products/product2.jpeg">
          </button>
        </li>
      </ul>
    </div>
</div>



</div>

<!-------------------------     Footer     ------------------------>
<footer>
  <p>Created by Seto Tsz Kin, IERG4210 proj. Hope you like it! :)</p>
  <p class="p2">(I dont know what to put here actually. but the page will seem odd if there is no footage.)</p>
</footer>



<!-------------------------     Modal     ------------------------>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-5">
            <img src="img/products/product2.jpeg">
          </div>
          <div class="col-7">
            <div class="title">
              <h2>Whiskey</h2>
              <p>$999</p>
            </div>
            <p>This is a bottle of whiskey, drink it happily !</p>
            <a class="btn btn-success" href="product.html" >more</a>
          </div>
        </div>
      </div>
      <div class="modal-footer" id="1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary add_cart" data-dismiss="modal">Add To Cart<i class="fas fa-plus"></i></button>
      </div>
    </div>
  </div>
</div>



<!--imported js-->
<script src="import/jquery.js"></script>
<script src="import/bootstrap/js/bootstrap.js"></script>
<script src="import/bootstrap/js/bootstrap.bundle.js"></script>
<script src="import/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="import/OwlCarousel/dist/owl.carousel.min.js"></script>
<script src="import/jquery-ui/jquery-ui.js"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v3.2';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!--self-written js-->
<script src="js/index_theme.js"></script>
<script src="js/shopping_cart_index.js"></script>


</body>
</html>
