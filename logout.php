<?php
function redirect($url){
    echo"
    <script>
        window.location.href='$url';
    </script>
    ";
    exit;
}
    session_start();
    session_destroy();
    redirect("hotel.php");
?>
