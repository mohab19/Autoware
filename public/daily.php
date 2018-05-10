<?php
/**
 * Created by PhpStorm.
 * User: karim
 * Date: 01/12/16
 * Time: 01:08 ص
 */


$user = new \App\User();
$user->first_name = "Admin";
$user->last_name = "";
$user->birthdate = "";
$user->address = "";
$user->password  = bcrypt("admin");
$user->email = "admin5";
$user->phone = "";
$user->national_id = "";
$user->role_id = "1";
$user->save();

?>
