<?php

$haslo='gites majones';

$hashowaneHaslo=  password_hash($haslo, PASSWORD_BCRYPT);

echo $haslo." oraz ".$hashowaneHaslo;
$hashowaneHaslo2= password_hash($haslo, PASSWORD_BCRYPT);
$hashowaneHaslo3= password_hash($haslo, PASSWORD_BCRYPT);
$hashowaneHaslo4= password_hash($haslo, PASSWORD_BCRYPT);
$hashowaneHaslo5= password_hash($haslo, PASSWORD_BCRYPT);
$hashowaneHaslo6= password_hash($haslo, PASSWORD_BCRYPT);

echo "<br/>".$haslo." oraz ".$hashowaneHaslo2;
echo "<br/>".$haslo." oraz ".$hashowaneHaslo3;
echo "<br/>".$haslo." oraz ".$hashowaneHaslo4;
echo "<br/>".$haslo." oraz ".$hashowaneHaslo5;
echo "<br/>".$haslo." oraz ".$hashowaneHaslo6;


var_dump(password_verify($haslo, $hashowaneHaslo));



$data=date("Y-m-d H:i:s");
echo $data;



