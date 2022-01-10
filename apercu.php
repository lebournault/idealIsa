<?php
    
    if ( isset($_GET['id']) ){
        $id = intval ($_GET['id']);
               
        $mysqli = mysqli_connect("localhost:3306", "flipbook", "Dt5[uctF@A_048Nf", "flipbook");
        
        $result = $mysqli->query("SELECT `img_id`, `img_type`, `img_blob` FROM `images` WHERE img_id =". $id);
       
       
        $row = $result->fetch_array();
                if ( !$row[0] ){
                    echo "Id d'image inconnu";
                } else {
                  //  header ("Content-type: " . $row[1]);
                    echo $row[1];
                   // echo $row[2];
                    
                    //convert a blob into an image file
                   $image = imagecreatefromstring($row[2]); 
                  // imagejpeg($image);
                //  imagejpeg($image, 'img.jpg');
                                
                   ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
                    imagejpeg($image, null, 80);
                    $data = ob_get_contents();
                    echo $data;
                    ob_end_clean();
                    echo '<img src="data:image/jpeg;base64,' .  base64_encode($data)  . '" width="40%"/>';
                
              /*   echo "<html>
                         <head>
                         <title>Stock d'images</title>
                         </head>
                         <body>
                  <img src='img.jpg'>
                 </body>
              </html>";

                 //echo '<img src="data:image/jpg;base64, ' .base64_encode($data) .'>';
*/
                }        

    } else {
        echo "Mauvais id d'image";
    }

?>
