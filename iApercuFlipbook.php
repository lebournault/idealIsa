<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta name="viewport" content="width = 1050, user-scalable = no" />
<script type="text/javascript" src="../../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../../extras/modernizr.2.5.3.min.js"></script>
<a href ="index.php">Retour Gestion Magazine</a><br>
</head>
<body>

<div class="flipbook-viewport">
	<div class="container">
		<div class="flipbook">
			<?php
			//<div style="background-image:url(pages/1.jpg)"></div>
			//$image = "pages/1.jpg";

		    require_once('CBdd.php');
			
			function afficherImage($id){
				$cnx=new CBdd();

				$requete = "SELECT `img_type`, `img_blob` FROM `image` WHERE img_id = ?";
				$row = $cnx->lireEnregistrementParId($requete, $id);
		  
				if ( $row == null){
				  echo "image inconnue";
				} else {
		  
					$img_type = $row["img_type"];
					$img_blob = $row["img_blob"];
		   
					//convert a blob into an image file
					$image = imagecreatefromstring($img_blob); 
			
					ob_start(); //Capture de tampon
					if ($img_type == "image/jpeg" || $img_type  == "image/jpg"){
						imagejpeg($image, null, 80);
					}
					$data = ob_get_contents();
					ob_end_clean();
					
					$image = "data:". $img_type  .";base64," .  base64_encode($data);
					echo '<div style="background-image:url(' . $image . ')"></div>';				
				}
			}

            function afficherTexte($texte){
				echo '<div>' .$texte.'</div>';
			}
			
				afficherImage(2);
				afficherTexte("Coucou")

				

			//echo '<div style="background-image:url(' . $image . ')"></div>';
			//	echo '<div style="background-image:url(pages/1.jpg)"></div>';
			?>
			<!--<div style="background-image:url(pages/2.jpg)"></div>-->
			<div style="background-image:url(pages/3.jpg)"></div>
			<div style="background-image:url(pages/4.jpg)"></div>
			<div style="background-image:url(pages/5.jpg)"></div>
			<div style="background-image:url(pages/6.jpg)"></div>
			<div style="background-image:url(pages/7.jpg)"></div>
			<div style="background-image:url(pages/8.jpg)"></div>
			<div style="background-image:url(pages/9.jpg)"></div>
			<div style="background-image:url(pages/10.jpg)"></div>
			<div style="background-image:url(pages/11.jpg)"></div>
			<div style="background-image:url(pages/12.jpg)"></div>
		</div>
	</div>
</div>


<script type="text/javascript">

function loadApp() {

	// Create the flipbook

	$('.flipbook').turn({
			// Width

			width:922,
			
			// Height

			height:600,

			// Elevation

			elevation: 50,
			
			// Enable gradients

			gradients: true,
			
			// Auto center this flipbook

			autoCenter: true

	});
}

// Load the HTML4 version if there's not CSS transform

yepnope({
	test : Modernizr.csstransforms,
	yep: ['../../lib/turn.js'],
	nope: ['../../lib/turn.html4.min.js'],
	both: ['css/basic.css'],
	complete: loadApp
});

</script>

</body>
</html>