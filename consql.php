<?php
$con=mysqli_connect("127.0.0.1","root","123456qwe","keshe");
mysqli_query($con,"set names utf8");
// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>