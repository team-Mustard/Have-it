<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    
    $routineID = $_GET['rouID'];
    
    $routine = "DELETE FROM routine WHERE routineID = '$routineID'";
    if($conn->query($routine) == TRUE){
        echo("<script> alert('루틴이 삭제되었습니다.');
        history.back(); </script>");
    }

?>