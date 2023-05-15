<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MSSW</title>
</head>

<body>

	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
			height: 100%;
			width: 100%;
		}

		.mySlides {
			display: none;
		}

		img {
			vertical-align: middle;
			height:100vh !important;
		}

		.slideshow-container {
			position: relative;
			margin: auto;
		}

		.active {
			background-color: #717171;
		}

		.fade {
			-webkit-animation-name: fade;
			-webkit-animation-duration: 1.5s;
			animation-name: fade;
			animation-duration: 1.5s;
		}

		@-webkit-keyframes fade {
			from {
				opacity: .4
			}

			to {
				opacity: 1
			}
		}

		@keyframes fade {
			from {
				opacity: .4
			}

			to {
				opacity: 1
			}
		}

	</style>
	</head>

	<body>

		<div class="slideshow-container">



        
        <?php foreach ($gallery as $key => $value) { ?>


<div class="mySlides fade">
  <img src="<?=base_url()?>digitalBanner/<?=$value->image_name?>" style="width:100%;" >
</div>
                  
  <?php  } ?> 
			

		</div>
		<br>

		<script>




			let slideIndex = 0;
			showSlides();

			function showSlides() {
				let slides = document.getElementsByClassName("mySlides");
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}
				slideIndex++;
				if (slideIndex > slides.length) {
					slideIndex = 1
				}
				slides[slideIndex - 1].style.display = "block";
				setTimeout(showSlides, 2000);
			}

			setInterval(function() {
					window.location.replace('<?=base_url()."DigitalBanner"?>');
                }, 60000);  
		</script>

	</body>

</html>
