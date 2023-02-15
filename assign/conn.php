<?PHP


$ip = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "user";

if (!$con = mysqli_connect($ip, $user, $password, $dbname)){
    die("failed to connect");
}