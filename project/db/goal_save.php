<?php
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    $goal_name = $_POST['goal_name'];
    $term = $_POST['term'];
    $time = time();
    $term_s_date = date("Y-m-d", $time);
    if($term == "select"){
        $term_s_date = $_POST['term_s_date'];
        $term_e_date = $_POST['term_e_date'];
    }
    else if($term == "a-month"){
        $term_e_date = date("Y-m-d", strtotime("+1 month", $time));
    }  
    else if($term == "3-month"){
        $term_e_date = date("Y-m-d", strtotime("+3 month", $time));
    }
    else if($term == "year"){
        $term_e_date = date("Y-m-d", strtotime("+1 year", $time));
    }
    
    $gcheck = "SELECT * FROM goal";
    $check_result = mysqli_query($conn, $gcheck);
    $check1 = "true";

    while($grow = mysqli_fetch_array($check_result)){
        $check_goal = $grow['goalName'];
        
        if($check_goal == $goal_name){
            echo("<script> alert('중복된 목표가 존재합니다.');
            history.back(); </script>");
            $check1 = "false";
            break;
        }
    }
    
    if($check1 == "true"){
        $sql = "INSERT INTO goal(goalName, startTerm, endTerm, achievement, userID) VALUES('$goal_name', '$term_s_date', '$term_e_date', '0', '$userid')";    
        $result = $conn->query($sql);
    /*if($result){
        echo "등록완료";
    }
    else{ echo "FAIL"; }*/
    
    $Interval = "";
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    
    $routineNum = $_POST['routineNum'];
    
    for($i=0;$i<$routineNum; $i++) {
        $name = "routine_name".$i;
        $week = "routine".$i;
        $color = "colors".$i;
        $routine_name[$i] = $_POST[$name];
        $repeats = $_POST[$week];
        $colors = $_POST[$color];

    /*echo $goal_name.", ".$term_s_date.", ".$term_e_date.", ".$routine_name[$i].", ";*/
    foreach($repeats as $repeat){
        /*echo $repeat.", ";*/
        
        if($repeat == "mon"){ 
            $arr[1] = "1"; 
        }
        else if($repeat == "tue"){ 
            $arr[2] = "1"; 
        }
        else if($repeat == "wed"){ 
            $arr[3] = "1"; 
        }
        else if($repeat == "thu"){ 
            $arr[4] = "1"; 
        }
        else if($repeat == "fri"){ 
            $arr[5] = "1"; 
        }
        else if($repeat == "sat"){ 
            $arr[6] = "1"; 
        }
        else if($repeat == "sun"){
            $arr[0] = "1"; 
        }
        
    }
    $Interval = implode(";", $arr);
       
    $arr_count = count($routine_name);
    $uniq_count = count(array_unique($routine_name));
                    
    if($arr_count != $uniq_count){
        echo("<script> alert('동일한 루틴은 두 개 이상 넣을 수 없습니다.');</script>");
        $dgoal = "DELETE FROM goal WHERE goalName = '$goal_name'";
        $dresult = $conn->query($dgoal);
        
        echo("<script>history.back();</script>");
        
        }
            
            
    $goal = "SELECT * FROM goal WHERE goalName = '$goal_name'";
    $result2 = mysqli_query($conn, $goal);
    $row = mysqli_fetch_array($result2);
    $goalID = $row['goalID'];
            
    $sql3 = "INSERT INTO routine(routineName, color, rInterval, goalID) VALUES('$routine_name[$i]', '$colors', '$Interval', '$goalID')";
        
    $result3 = $conn->query($sql3); 
            
    /*if($result3){ echo "루틴 등록완료"; }
    else{ echo "실패 ! "; }*/
        
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    }
}

echo "<script>document.location.href='../index.php?page=goal&goalID=".$goalID."'</script>";        

?>
