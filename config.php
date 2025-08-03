<?php
 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'real_estate_db');

// define('DB_HOST', 'sql301.infinityfree.com');
// define('DB_USER', 'if0_39128200');
// define('DB_PASS', 'jCu9NnSHJEANdTx');
// define('DB_NAME', 'if0_39128200_real_estate_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

 
// if (!$conn) {
// echo "error connection ";
// }

// else{
//     echo "connected succesfully";
// }
 
session_start();
?>