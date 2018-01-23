<?php

session_start();
define("SERVER", "mysql.cba.pl" );
define("USERNAME", "s14091" );
define("PASSWORD", "Asd321qwe" );
define("DATABASE", "ecz_2");
$baza =  mysqli_connect(SERVER,USERNAME,PASSWORD,DATABASE);

mysqli_query($baza,"set names 'utf8'");
mysqli_query($baza,"SET CHARSET 'utf8'");
if (!mysqli_connect(SERVER,USERNAME,PASSWORD,DATABASE)){
    exit('Error: Nie można połączyć się z bazą danych');
}
?>