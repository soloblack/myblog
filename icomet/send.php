<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $cname = test_input($_POST["cname"]);
   $content = test_input($_POST["content"]);
   comet_push($cname,$content);
   echo $_POST["cname"];
   echo $_POST["content"];
   echo "<br>";
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function comet_push($cname, $content){
    $cname = urlencode($cname);
    $content = urlencode($content);
    $url = "http://114.112.95.50:8000/push?cname=$cname&content=$content";
    $ch = curl_init($url) ;
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
    $result = curl_exec($ch) ;
    curl_close($ch) ;
    return $result;
}
?>
