<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8">
<title>PHPH1 :: A Harmony ONE Node API PHP Class</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="phph1.css">
</head>
<body>
<?php
	require_once('config.php');
	require_once('phph1.php');
	if(isset($hmyv2_methods) && isset($_GET['method']) && in_array($_GET['method'], $hmyv2_methods)){
		$hmyv2_include_page = $_GET['method'];
	}
?>
<h1><a href="index.php">PHPH1</a></h1>
<h2>A Harmony ONE Node API PHP Class</h2>

<div class="dropdown">
  <button onclick="LoadMethod()" onblur="startListener()" class="dropbtn" id="dropbtn">METHOD EXPLORER</button>
  <div id="LoadMethodDropdown" class="dropdown-content">
	<div class="dropdown-header">
    <input type="text" placeholder="Search.." id="LoadMethodInput" class="searchbox" onkeyup="filterMethodInput()">
	</div>
	<div class="dropdown-list">
	<?php foreach($hmyv2_methods as $amethod){ echo '<a href="/?method='.$amethod.'">'.$amethod.'</a>';}?>
	</div>
  </div>
</div>

<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function LoadMethod() {
  document.getElementById("LoadMethodDropdown").classList.toggle("show");
}

function startListener() {
  document.documentElement.addEventListener('click', closeMenuOnBodyClick);
}

function closeMenu(){
  document.getElementById("LoadMethodDropdown").classList.remove('show');
  // remove event listener from the html element
  document.documentElement.removeEventListener('click', closeMenuOnBodyClick);
}

function closeMenuOnBodyClick(event){
  // get the event path
  const path = event.composedPath();
  // check if it has the menu element
  if (path.some(elem => elem.id === 'LoadMethodDropdown')) {
    // terminate this function if it does
    return;
  }
  closeMenu();
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
if(isset($hmyv2_include_page)){
	/*
	We start with a default of no input is good input
	This way we have to explicitely tell it that it is okay to run the calls (security)
	there are val_ requests at the bottom of the class.
	NEVER remove/comment this line
	ALWAYS wrap your output code in this: if($validoutput ==1){   YOURCODEGOESHERE   };
	*/
	$validinput = 0;

	require_once('config.php');
	require_once('phph1.php');

	$phph1 = new phph1($apiaddr, $phph1_debug);

	/*
	This handle is temporary and is used to validate
	the variables for the $phph1 handle to successfully and safely load
	it will get destroyed once we have the real handle
	*/
	$phph1_boothandle = new phph1($apiaddr,$phph1_debug);

	echo "<h3>".$hmyv2_include_page."</h3>";
	include('methods/'.$hmyv2_include_page.'.php');
}else{
	require_once('index_body.php');
}	
?>

</body>
</html>