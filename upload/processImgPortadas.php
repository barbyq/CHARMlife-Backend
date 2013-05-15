<?php
$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
      //echo $_FILES["file"]["error"];
      echo 'error';
    }
  else
    {
      if (isset($_POST['action'])){
          
          $dir = "portadas/temp/" . $_POST['temp'] . '/';
          if (!is_dir($dir)){ 
              mkdir($dir);
          }

          //print_r($_POST);
          if (isset($_POST['mob'])){
            
            if ($_POST['mob'] == 'true'){
              move_uploaded_file($_FILES["file"]["tmp_name"], $dir . 'thumb_' . $_FILES["file"]["name"]);
              echo 'upload/' . $dir . 'thumb_' . $_FILES["file"]["name"];
            }else{
              move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $_FILES["file"]["name"]);
              echo 'upload/' . $dir . $_FILES["file"]["name"];     
            }

          }
          
      }

    }
  }
else
  {
  echo "Invalid file";
  }
?>