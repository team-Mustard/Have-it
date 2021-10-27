<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    
    $goalID = $_POST['goalID'];
    
    $goal = "DELETE FROM goal WHERE goalID='$goalID'";
    if($conn->query($goal) == TRUE){
        
        echo("<script> alert('목표가 삭제되었습니다.');</script>");
        
        $sql = "SELECT * FROM goal WHERE userID='$userid' ORDER BY goalID DESC LIMIT 1"; 
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $last_goalID = $row['goalID'];
        
        $url = "http://localhost/Have-it/project/index.php?page=goal&goalID=".$last_goalID;
       echo("<script>location.href='$url'</script>");
    }

?>