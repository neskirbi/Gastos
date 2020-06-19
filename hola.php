<?php

include "config/config.php";
echo mysqli_real_escape_string($con,"'hola'".'"más"');
?>