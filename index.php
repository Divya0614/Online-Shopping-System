<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Welcome!!</title>
  <style>
    body { font-family: Arial,sans-serif; margin:0; background:#f5f7fa; }
    header { background:#0077cc;color:white;padding:12px 20px;display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:100;}
    header .icons span { font-size:22px; cursor:pointer; }
    header input, header select { padding:6px 10px;border:none;border-radius:4px; }
    .category { margin-bottom:24px; }
    .category-title { background:#0077cc;color:#fff;padding:10px 20px;margin:0;border-top:4px solid #005fa3; }
    .products { display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;padding:0 20px 20px; }
    .product { background:#fff;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);padding:12px;text-align:center; }
    .product img { width:100%;height:160px;object-fit:cover;border-radius:4px;margin-bottom:10px; }
    .product h3 { font-size:16px;margin:8px 0 5px; }
    .product p { color:#0077cc;font-weight:bold;margin-bottom:10px; }
    .product .add-to-cart { background:#0077cc;color:#fff;border:none;padding:8px 14px;border-radius:20px;cursor:pointer; }
    .product .add-to-cart:hover { background:#005fa3; }
  </style>
</head>
<body>
<h2>Welcome, <?= $_SESSION['email']; ?>!</h2>
    
  <header>
    <span title="Home" onclick="window.location.reload()">🏠</span>
    <a href="cart.php" title="Cart" style="text-decoration:none; color:white; font-size:22px;">🛒</a>
    <input id="search" type="text" placeholder="Search products..." />
    <select id="categoryFilter">
      <option value="All">All Categories</option>
      <option>Electronics</option><option>Dresses</option><option>Cosmetics</option>
      <option>Footwear</option><option>Books</option>
    </select>
    <select id="priceSort">
      <option value="default">Sort by Price</option>
      <option value="low">Low → High</option>
      <option value="high">High → Low</option>
    </select>
  </header>

  <div id="productContainer"></div>

  <script>
    const products = [
      // Electronics (12 items)
      {id:1,name:'Wireless Headphones',price:59.99,img:'assets/images/headphones.jpg',category:'Electronics'},
      {id:2,name:'Smartphone',price:499.99,img:'assets/images/smartphone.jpg',category:'Electronics'},
      {id:3,name:'Laptop',price:899.99,img:'assets/images/laptop.jpg',category:'Electronics'},
      {id:4,name:'Smartwatch',price:129.99,img:'assets/images/smartwatch.jpg',category:'Electronics'},
      {id:5,name:'Tablet',price:249.99,img:'assets/images/tablet.jpg',category:'Electronics'},
      {id:6,name:'Bluetooth Speaker',price:79.99,img:'assets/images/speaker.jpg',category:'Electronics'},
      {id:7,name:'Gaming Console',price:399.99,img:'assets/images/gamingconsole.jpg',category:'Electronics'},
      {id:8,name:'External Hard Drive',price:99.99,img:'assets/images/harddrive.jpg',category:'Electronics'},
      {id:9,name:'4K Monitor',price:299.99,img:'assets/images/monitor.jpg',category:'Electronics'},
      {id:10,name:'Wireless Mouse',price:29.99,img:'assets/images/mouse.jpg',category:'Electronics'},
      {id:11,name:'VR Headset',price:349.99,img:'assets/images/vrheadphone.jpg',category:'Electronics'},
      {id:12,name:'Portable Charger',price:49.99,img:'assets/images/powerbank.jpg',category:'Electronics'},

      // Dresses (11 items)
      {id:13,name:"Men's T-Shirt",price:19.99,img:'assets/images/tshirts.jpg',category:'Dresses'},
      {id:14,name:"Women's Dress",price:49.99,img:'assets/images/womendress.jpg',category:'Dresses'},
      {id:15,name:"Jeans",price:34.99,img:'assets/images/jeans.jpg',category:'Dresses'},
      {id:16,name:"Jacket",price:59.99,img:'assets/images/jacket.jpg',category:'Dresses'},
      {id:17,name:"Formal Shirt",price:29.99,img:'assets/images/formalshirt.jpg',category:'Dresses'},
      {id:18,name:"Kurti",price:24.99,img:'assets/images/kurti.jpg',category:'Dresses'},
      {id:19,name:"Saree",price:79.99,img:'assets/images/saree.jpg',category:'Dresses'},
      {id:20,name:"Skirt",price:39.99,img:'assets/images/skirt.jpg',category:'Dresses'},
      {id:21,name:"Sweatshirt",price:44.99,img:'assets/images/sweatshirt.jpg',category:'Dresses'},
      {id:22,name:"Hoodie",price:49.99,img:'assets/images/hoodie.jpg',category:'Dresses'},
      {id:23,name:"Blazer",price:89.99,img:'assets/images/blazer.jpg',category:'Dresses'},

      // Cosmetics (10 items)
      {id:24,name:"Lipstick",price:9.99,img:'assets/images/lipstick.jpg',category:'Cosmetics'},
      {id:25,name:"Foundation",price:19.99,img:'assets/images/foundation.jpg',category:'Cosmetics'},
      {id:26,name:"Mascara",price:14.99,img:'assets/images/mascara.jpg',category:'Cosmetics'},
      {id:27,name:"Face Cream",price:24.99,img:'assets/images/facecream.jpg',category:'Cosmetics'},
      {id:28,name:"HairSerum",price:12.99,img:'assets/images/hair serum.jpg',category:'Cosmetics'},
      {id:29,name:"Eyeliner",price:7.99,img:'assets/images/eyeliner.jpg',category:'Cosmetics'},
      {id:30,name:"Compact Powder",price:14.99,img:'assets/images/compactpowder.jpg',category:'Cosmetics'},
      {id:31,name:"Blush",price:11.99,img:'assets/images/blush.jpg',category:'Cosmetics'},
      {id:32,name:"Nail Polish",price:5.99,img:'assets/images/nailpolish.jpg',category:'Cosmetics'},

      // Footwear (8 items)
      {id:34,name:"Running Shoes",price:59.99,img:'assets/images/shoes.jpg',category:'Footwear'},
      {id:35,name:"Sandals",price:29.99,img:'assets/images/sandals.jpg',category:'Footwear'},
      {id:36,name:"Formal Shoes",price:69.99,img:'assets/images/formalshoes.jpg',category:'Footwear'},
      {id:37,name:"Flip Flops",price:9.99,img:'assets/images/flipflop.jpg',category:'Footwear'},
      {id:38,name:"Boots",price:89.99,img:'assets/images/boots.jpg',category:'Footwear'},
      {id:39,name:"Heels",price:49.99,img:'assets/images/heels.jpg',category:'Footwear'},
      {id:40,name:"Sneakers",price:54.99,img:'assets/images/sneakers.jpg',category:'Footwear'},
      {id:41,name:"Loafers",price:39.99,img:'assets/images/loufers.jpg',category:'Footwear'},

      
    ];

    const container = document.getElementById('productContainer');

    function showProducts(list) {
      container.innerHTML = list.reduce((html, p) => 
        html + `
        <div class="product">
          <img src="${p.img}" alt="${p.name}">
          <h3>${p.name}</h3>
          <p>$${p.price.toFixed(2)}</p>
        <form method="post" action="cart/add_to_cart.php">
  <input type="hidden" name="id" value="${p.id}">
  <input type="hidden" name="name" value="${p.name}">
  <input type="hidden" name="price" value="${p.price}">
  <button type="submit" class="add-to-cart">Add to Cart</button>
</form>

        </div>`, '<div class="products">'
      ) + '</div>';
    }

    function updateDisplay() {
      let filtered = products.filter(p =>
        p.name.toLowerCase().includes(search.value.toLowerCase()) &&
        (categoryFilter.value === 'All' || p.category === categoryFilter.value)
      );
      if (priceSort.value === 'low') filtered.sort((a,b)=>a.price-b.price);
      if (priceSort.value === 'high') filtered.sort((a,b)=>b.price-a.price);
      showProducts(filtered);
    }

    document.querySelectorAll('input,select').forEach(el => el.addEventListener('input', updateDisplay));

    // Initial load
    showProducts(products);
  </script>
<a href="logout.php">Logout</a>
</body>
</html>
