<?php

$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < 20000000)
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
          
          if ($_POST['temp'] == ''){
            $date = new DateTime();
            $dir = "upload/colaboradores/temp/" . $date->getTimestamp() . '/';

            if (!is_dir($dir)){ 
              mkdir($dir);
            }
          }else{
              $temp = $_POST['temp'];
              $vars = explode("/", $temp);
              
              $dir = "upload/colaboradores/temp/" . $vars[0] . '/';
              unlink($dir . $vars[1]);
          }

          move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $_FILES["file"]["name"]);
          echo $dir . $_FILES["file"]["name"];
          
      }else{
        /*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";*/
        /*if (file_exists("upload/colaboradores/" . $_POST['id'] . '/' . $_FILES["file"]["name"])){
          //echo $_FILES["file"]["name"] . " already exists. ";
            echo 'error';
        }
        else{*/
          move_uploaded_file($_FILES["file"]["tmp_name"], "upload/colaboradores/" . $_POST['id'] . '/' .  $_FILES["file"]["name"]);
          echo  "upload/colaboradores/" . $_POST['id'] . '/' .  $_FILES["file"]["name"];
        //}
      }


    }
  }
else
  {
  echo "Invalid file";
  }
?>