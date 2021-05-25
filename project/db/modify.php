<?php
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    $goal_name = $_POST['goal_name'];
    $goalID = $_POST['goalID'];

    $term_s_date = $_POST['term_s_date'];
    $term_e_date = $_POST['term_e_date'];
       
    $gcheck = "SELECT * FROM goal";
    $check_result = mysqli_query($conn, $gcheck);
    $check1 = "true";

    while($grow = mysqli_fetch_array($check_result)){
        $check_goal = $grow['goalName'];
        
        if($check_goal == $goal_name){
            echo("<script> alert('중복된 목표가 존재합니다.'); </script>");
            $check1 = "false";
            echo("<script> history.back(); </script>");
            break;
        }
    }


    $goal = "UPDATE goal SET goalName='$goal_name', startTerm='$term_s_date', endTerm='$term_e_date' WHERE goalID='$goalID'";
    $result = $conn->query($goal);

    if($result){ echo("<script>history.back();</script>"); }   

?>