<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    $goal_name = $_POST['goalName'];
    
    
    $Interval = "";
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    
    $routineNum = $_POST['routineNum'];
    
        $i = $routineNum;
        $name = "routine_name".$i;
        $week = "routine".$i;
        $color = "colors".$i;
        $routine_name = $_POST[$name];
        $repeats = $_POST[$week];
        $colors = $_POST[$color];

    /*echo $goal_name.", ".$term_s_date.", ".$term_e_date.", ".$routine_name[$i].", ";*/
    foreach($repeats as $repeat){
        //echo $repeat.", ";
        
        if($repeat == "mon"){ 
            $arr[0] = "1"; 
        }
        else if($repeat == "tue"){ 
            $arr[1] = "1"; 
        }
        else if($repeat == "wed"){ 
            $arr[2] = "1"; 
        }
        else if($repeat == "thu"){ 
            $arr[3] = "1"; 
        }
        else if($repeat == "fri"){ 
            $arr[4] = "1"; 
        }
        else if($repeat == "sat"){ 
            $arr[5] = "1"; 
        }
        else if($repeat == "sun"){
            $arr[6] = "1"; 
        }
        
    }
    $Interval = implode(";", $arr);
           
            
    $goal = "SELECT * FROM goal WHERE goalName = '$goal_name'";
    $result2 = mysqli_query($conn, $goal);
    $row = mysqli_fetch_array($result2);
    $goalID = $row['goalID'];

    $sql3 = "UPDATE routine SET routineName='$routine_name', color='$colors',  rInterval='$Interval', habbitTracker='0' WHERE routineID='$i'";
    $result3 = $conn->query($sql3); 
            
    if($result3){ echo("<script>history.back();</script>"); }
    else{ echo "실패 ! "; }
        
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    
?>