<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    
    $goalID = $_POST['goalID'];
    
    $goal = "DELETE FROM goal WHERE goalID='$goalID'";
    if($conn->query($goal) == TRUE){
        
        echo("<script> alert('목표가 삭제되었습니다.');
        history.back(); </script>");
    }

?>