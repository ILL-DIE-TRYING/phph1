// When the user clicks on the top button, scroll to the top of the document
	function flyToTop() {
	  document.body.scrollTop = 0; // For Safari
	  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}

document.addEventListener("DOMContentLoaded", function(event) { 
	// hiddenSticky
	// When the user scrolls the page, execute stickyNav
	window.onscroll = function() {stickyNav()};

	// Get the hiddenSticky and bodywrap
	var hiddenSticky = document.getElementById("hiddenSticky");
	var bodyWrap = document.getElementById("bodyWrap");

	// Get the offset position of the navbar
	var sticky = hiddenSticky.offsetTop;

	// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function stickyNav() {
		if (window.pageYOffset >= sticky) {
			hiddenSticky.classList.add("sticky");
			bodyWrap.classList.add("stuck");
			document.getElementById('topbar').style.display = 'none';
			document.getElementById("hiddenSticky").style.height = "100px";
			document.getElementById("toTopBtn").style.display = "block";
		} else {
			hiddenSticky.classList.remove("sticky");
			bodyWrap.classList.remove("stuck");
			topbar.classList.remove("hidetopbar");
			document.getElementById('topbar').style.display = 'block';
			document.getElementById("hiddenSticky").style.height = "180px";
			document.getElementById("toTopBtn").style.display = "none";
		}
	}
	
	// SETTINGS MODAL BOX
	// Get the modal
	var modal = document.getElementById("settingsModal");

	// Get the button that opens the modal
	var btn = document.getElementById("settingsBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}	
});

/*
* jQuery used to populate the shard dropdown according to what net is selected
*/
$(document).ready(function(){
	$("#network").change(function(){
		var selectedNetwork = $("#network option:selected").val();
		$.get( "popshard.php", { net: selectedNetwork } )
		.done(function( data ) {
			$("#shard").html(data);
		});
    });
});

/*
method documentation dropdown
*/
		var coll = document.getElementsByClassName("collapsibleInfo");
		var i;

		for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("activeInfo");
			var infoContent = this.nextElementSibling;
			if (infoContent.style.display === "block") {
				infoContent.style.display = "none";
			} else {
				infoContent.style.display = "block";
			}
		});
		}
		
		/*
	filterMthodInput is for the search box in the method dropdown
	*/
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

