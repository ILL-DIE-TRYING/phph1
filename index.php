<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8">
<title>PHPH1 EXAMPLE EXPLORER</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
</head>
<body>
<?php
	include('config.php');
	include('phph1.php');
	if(isset($hmyv2_methods) && isset($_GET['method']) && in_array($_GET['method'], $hmyv2_methods)){
		$hmyv2_include_page = $_GET['method'];
	}
?>
<h1><a href="index.php">PHPH1 HOME</a></h1>

<div class="dropdown">
  <button onclick="LoadMethod()" class="dropbtn">METHODS</button>
  <div id="LoadMethodDropdown" class="dropdown-content">
    <input type="text" placeholder="Search.." id="LoadMethodInput" onkeyup="filterMethodInput()">
	<?php
	
	foreach($hmyv2_methods as $amethod){
		echo '<a href="/?method='.$amethod.'">'.$amethod.'</a>';
	}
	?>
	<!--
    <a href="/?method=hmyv2_getTransactionsHistory">hmyv2_getTransactionsHistory</a>
    <a href="/?method=hmyv2_getBlockByNumber">hmyv2_getBlockByNumber</a>
    <a href="/?method=hmyv2_getBalance">hmyv2_getBalance</a>
    <a href="/?method=hmyv2_getBalanceByBlockNumber">hmyv2_getBalanceByBlockNumber</a>
	-->
  </div>
</div>

<!--
<p><a href="hmyv2_getTransactionsHistory.php">Get Wallet Transactions History</a></p>
<p><a href="hmyv2_getBlockByNumber.php">Get Block By Block Number</a></p>
<p><a href="hmyv2_getBalance.php">Get Wallet Balance</a></p>
<p><a href="hmyv2_getBalanceByBlockNumber.php">Get Wallet Balance by Block Number</a></p>
-->

<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function LoadMethod() {
  document.getElementById("LoadMethodDropdown").classList.toggle("show");
}

function filterMethodInput() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("LoadMethodInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("LoadMethodDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>

<?php
include($hmyv2_include_page.'.php');
?>

</body>
</html>