<?php

setcookie('RF_Sess_Cookie', "", time()-3600,"",".zkiz.com");


setcookie('Sess_Cookie', "", time()-3600,"",".zkiz.com");


setcookie('RF_Sess_Cookie', "", time()-3600);


setcookie('Sess_Cookie', "", time()-3600);


echo "Done! Thanks for your cooperation!";
include("Connections/zkizblog.php");
include(template('header'));
echo "Expired zkiz.com RF_Sess_Cookie<br />";
echo "Expired zkiz.com Sess_Cookie<br />";
echo "Expired RealForum RF_Sess_Cookie<br />";
echo "Expired RealForum Sess_Cookie<br />";
include(template('footer'));
?>