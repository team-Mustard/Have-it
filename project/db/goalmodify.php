<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];

    $mode = $_POST['mode'];

    //루틴 삭제
    if($mode == 'x'){
        $goal_name = $_POST['goalName'];
        $goal = "SELECT * FROM goal WHERE goalName = '$goal_name'";
        $result2 = mysqli_query($conn, $goal);
        $row = mysqli_fetch_array($result2);
        $goalID = $row['goalID'];
        $c = $_POST['Bcount'];
        $r = "rouID".$c;
        $routineID = $_POST[$r];
        
        
        $rouDelete = "DELETE FROM routine WHERE routineID='$routineID'";
        if($conn->query($rouDelete) == TRUE){
            echo("<script> alert('루틴이 삭제되었습니다.');
            history.back(); </script>");        
        }
    }

    //루틴 수정
    else if($mode == '저장'){
        
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
                //echo("<script> history.back(); </script>");
                break;
            }
        }
        $goal = "UPDATE goal SET goalName='$goal_name', startTerm='$term_s_date', endTerm='$term_e_date' WHERE goalID='$goalID'";
        $result = $conn->query($goal);

        //if($result){ echo("<script>history.back();</script>"); }   
    }

    else if($mode == '루틴 저장'){
    
    $Interval = "";
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    $goalName = $_POST['goalName'];
    $GoalID = $_POST['GOALID'];
    $count = $_POST['count'];
            
    for($i=0; $i<$count; $i++){
        $rouID = "rouID".$i;
        $routineID = $_POST[$rouID];
        
        $rouName = "routine_name".$routineID;
        $routineName = $_POST[$rouName];
        $rouColor = "colors".$routineID;
        $color = $_POST[$rouColor];
        $week = "routine".$routineID;
        $repeats = $_POST[$week];
        
        $Interval = "";
        $arr = array("0", "0", "0", "0", "0", "0", "0");
        
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
            
        $sql5 = "UPDATE routine SET routineName='$routineName', color='$color',  rInterval='$Interval' WHERE routineID='$routineID'";
        $result5 = $conn->query($sql5); 
       
        $arr = array("0", "0", "0", "0", "0", "0", "0");
        
        //echo ".$routineName.", ".$color.";
    }
    
    /*추가한 루틴*/
        $bcount = $_POST['btn_count'];
        if($bcount!=null){
            
            for($j=0; $j<$bcount; $j++){
                $plusID = "plusID".$j;
                $p_routineID = $_POST[$plusID];
                
                $pName = "routine_name".$p_routineID;
                $p_routineName = $_POST[$pName];
                $pColor = "colors".$p_routineID;
                $pcolor = $_POST[$pColor];
                $pweek = "routine".$p_routineID;
                $prepeats = $_POST[$pweek];
  
                $pInterval = "";
                $parr = array("0", "0", "0", "0", "0", "0", "0");
                
                foreach($prepeats as $prepeat){
                    if($prepeat == "mon"){ 
                        $parr[0] = "1"; 
                    }
                    else if($prepeat == "tue"){ 
                        $parr[1] = "1"; 
                    }
                    else if($prepeat == "wed"){ 
                        $parr[2] = "1"; 
                    }
                    else if($prepeat == "thu"){ 
                        $parr[3] = "1"; 
                    }
                    else if($prepeat == "fri"){ 
                        $parr[4] = "1"; 
                    }
                    else if($prepeat == "sat"){ 
                        $parr[5] = "1"; 
                    }
                    else if($prepeat == "sun"){
                        $parr[6] = "1"; 
                    }
                }
                $pInterval = implode(";", $parr);
                
                $sql6 = "INSERT INTO routine(routineName, color, rInterval, habbitTracker, goalID) VALUES('$p_routineName', '$pcolor', '$pInterval', '0', '$GoalID')";
                $result6 = $conn->query($sql6);
                
                $parr = array("0", "0", "0", "0", "0", "0", "0");
            }
        }
                
        
    echo("<script>history.back();</script>");
    
    
    /*$sql3 = "UPDATE routine SET routineName='$routine_name', color='$colors',  rInterval='$Interval', habbitTracker='0' WHERE routineID='$i'";
    $result3 = $conn->query($sql3); 
            
    if($result3){ echo("<script>history.back();</script>"); }
    else{ echo "실패 ! "; }
       
    $arr = array("0", "0", "0", "0", "0", "0", "0"); */
    /*
        $i = $routineNum;
        $name = "routine_name".$i;
        $week = "routine".$i;
        $color = "colors".$i;
        $routine_name = $_POST[$name];
        $repeats = $_POST[$week];
        $colors = $_POST[$color];

    //echo $goal_name.", ".$term_s_date.", ".$term_e_date.", ".$routine_name[$i].", ";
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
           

    $sql3 = "UPDATE routine SET routineName='$routine_name', color='$colors',  rInterval='$Interval', habbitTracker='0' WHERE routineID='$i'";
    $result3 = $conn->query($sql3); 
            
    if($result3){ echo("<script>history.back();</script>"); }
    else{ echo "실패 ! "; }
       
    $arr = array("0", "0", "0", "0", "0", "0", "0");*/
    }
?>