<?php
$myfile = fopen("file.txt" , "w") or die("unable to open file.....!!!!");

$text = "projects";
fwrite($myfile,$text);


echo readfile("file.txt");

?>