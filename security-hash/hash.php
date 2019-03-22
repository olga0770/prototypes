<?php
/**
 * Created by PhpStorm.
 * User: Olga
 * Date: 3/15/2019
 * Time: 9:25 AM
 */



$pass_register = "123456";
$db_password = "56cccb7b43c71513e2eb0ccd0bc50053b694356cd36f0097cd3dcc654166ee02";
$pass_login = "1234";

$options = [
    'cost' => 5
];

// $salt = rand(0,100);
$salt = 71;
echo $salt."<br>";

$static_peper = "dfdfswewegggfsdo034340fsfg3443213";

 $hashed_password = hash("sha256", $pass_register."my_secret".$salt.$static_peper);

if($hashed_password == $db_password){
    echo "success<br>";
}

 echo $hashed_password;





//$hashed_password = password_hash($pass_register, PASSWORD_DEFAULT); // bicreapted
//if(password_verify($pass_login, $hashed_password)){
//    echo "success"."<br>";
//}
//echo $hashed_password;




//echo md5("Hello World!")."<br>";
//
//echo hash("md5","Hello World!")."<br>";
//
//echo hash("sha1","Hello World!")."<br>";
//
//echo hash("sha256","Hello World!")."<br>";
//
//echo hash("sha512","Hello World!")."<br>";
//
//var_dump(hash_hmac_algos());
//echo "</pre>";




