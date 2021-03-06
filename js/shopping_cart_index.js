function addcart(e){
	if(localStorage.getItem("cart") === null){
		var cart = {"cart":[ {"pid": e.target.parentElement.id, "quantity":"1"}  ]};
		localStorage.setItem("cart", JSON.stringify(cart) );
		updatecart(e.target.parentElement);
	}else{
		var cart = JSON.parse(localStorage.getItem("cart"));
		var flag = 0;
		for(var i = 0 ; i < cart.cart.length ; i++){
			if(cart.cart[i].pid == e.target.parentElement.id){
				flag = 1;
			}
		}
		if(flag == 0){
			var item_add = {"pid":e.target.parentElement.id , "quantity":"1"};
			cart.cart.push(item_add);
			localStorage.setItem("cart", JSON.stringify(cart));
			updatecart(e.target.parentElement);
		}
	}
}

function updatecart(product){
	var cart = document.querySelector(".expand_menu #content ul");
	var cart_item_new = document.createElement("li");
	cart_item_new.innerHTML = '<div class="row">' + 
					'  <a href="product.php?pid='+ product.id +'"> <img src="'+ product.children[0].children[0].src +'">  </a>' +
					'  <a href="product.php" class="title">'+ product.children[1].children[0].text +'</a>' +
        				'  <div class="quantity"> <input class="qty" min="0" value="1" > </div>' +
        				'  <div class="info"> <div class="price">'+ product.children[2].textContent +'</div> <a href="#"> Delete </a> </div>' +
        				'</div>';
	cart.appendChild(cart_item_new); 
	var quantin = document.querySelectorAll("#content li input");
	for(var i = 0 ; i < quantin.length ; i++){
		quantin[i].addEventListener("change", updatequan);
	}
	var delitems = document.querySelectorAll("#content li .info a");
	for(var i = 0 ; i < delitems.length ; i++){
		delitems[i].addEventListener("click", delitem);
	}
	updatesum();
}

function initialcart(){
	if(localStorage.getItem("cart") !== null){
		var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActionXObject("Microsoft.XMLHTTP"), async = true;
		xhr.open('POST','loadcart.php',true);
		xhr.setRequestHeader('content-type', 'application/json');
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && xhr.status == 200){
				var cart = document.querySelector(".expand_menu #content ul");
				cart.innerHTML = this.responseText;
				var quantin = document.querySelectorAll("#content li input");
				for(var i = 0 ; i < quantin.length ; i++){
					quantin[i].addEventListener("change", updatequan);
				}
				var delitems = document.querySelectorAll("#content li .info a");
				for(var i = 0 ; i < delitems.length ; i++){
					delitems[i].addEventListener("click", delitem);
				}
				updatesum();
			}
		}
		xhr.send(localStorage.getItem("cart"));
	}
}

function updatequan(e){
	var linode = e.target.parentElement.parentElement.parentElement;
	var cart = JSON.parse(localStorage.getItem("cart"));
	for(var i = 0 ; i < cart.cart.length ; i++){
		if( linode.parentElement.children[i]  == linode){
			cart.cart[i].quantity = e.target.value;
			localStorage.setItem("cart", JSON.stringify(cart));
		}
	}
	updatesum();
}

function updatesum(){
	var price = 0;
	var prices = document.querySelectorAll("#content li .price");
	for(var i = 0 ; i < prices.length ; i++){
		var quan = prices[i].parentElement.previousElementSibling.children[0].value;
		price += parseFloat(prices[i].textContent.substring(1)) * quan;
	}
	var total = document.querySelector(".total p");
	total.textContent = "Total:$" + price;
}

function delitem(e){
	var cart = JSON.parse(localStorage.getItem("cart"));
	var linode = e.target.parentElement.parentElement.parentElement;
	for(var i = 0 ; i < cart.cart.length ; i++){
		if( linode  == linode.parentElement.children[i]){
			cart.cart.splice(i,1);
			e.target.parentElement.parentElement.parentElement.remove();
			localStorage.setItem("cart", JSON.stringify(cart));
		}
	}
	updatesum();
}

function mysubmit(form){
	var my_cart_info = JSON.parse(localStorage.getItem("cart"));
	var xhr = (window.XMLHttpRequest)
		? new XMLHttpRequest()
		: new ActiveXObject("Microsoft.XMLHttp"),
		async=true;
	xhr.open('POST','checkout-process.php?action=genDigest',async);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function(){
//console.log('finished ajax with reasystate and status and responsetext:  ' + xhr.readyState +"   "+ xhr.status +"   "+  xhr.responseText);
		if(xhr.readyState == 4 && xhr.status == 200){
			//console.log(xhr.responseText);
			json = JSON.parse(xhr.responseText);
			form.custom.value = json[0]["digest"];
			form.invoice.value = json[0]["invoice"];
			for(var k in my_cart_info['cart']){
				
				var cart_item_paypal_name = document.createElement("input");
				cart_item_paypal_name.type = "hidden";
				cart_item_paypal_name.name = "item_name_"+(parseInt(k)+1);
				cart_item_paypal_name.value = json["name"][k];

				var cart_item_paypal_quan = document.createElement("input");
				cart_item_paypal_quan.type = "hidden";
				cart_item_paypal_quan.name = "quantity_"+(parseInt(k)+1);
				cart_item_paypal_quan.value = my_cart_info['cart'][k]["quantity"].toString();

				var cart_item_paypal_amount = document.createElement("input");
				cart_item_paypal_amount.type = "hidden";
				cart_item_paypal_amount.name = "amount_"+(parseInt(k)+1);
				cart_item_paypal_amount.value = json["price"][k];

				form.appendChild(cart_item_paypal_name);
				form.appendChild(cart_item_paypal_quan);
				form.appendChild(cart_item_paypal_amount);

			}
			//console.log(form);
			localStorage.clear();
			form.submit();
		}
	};
	xhr.send('cart='+JSON.stringify(my_cart_info));
	return false;
}

initialcart();
var add_btns = document.querySelectorAll(".add_cart");
for(var i = 0 ; i < add_btns.length ; i++){
	add_btns[i].addEventListener("click" , addcart);
}
document.onreadystatechange = function(){
	if(document.readyState === "complete"){
		var quantin = document.querySelectorAll("#content li input");
		for(var i = 0 ; i < quantin.length ; i++){
			quantin[i].addEventListener("change", updatequan);
		}
		var delitems = document.querySelectorAll("#content li .info a");
		for(var i = 0 ; i < delitems.length ; i++){
			delitems[i].addEventListener("click", delitem);
		}
	}
};

