<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
    
    $goalID = $_POST['goalID'];
    $Interval = "";
    $arr = array("0", "0", "0", "0", "0", "0", "0");
    $goalName = $_POST['goalName'];

    $sql = "SELECT * FROM routine WHERE goalID='$goalID'";
    $data = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($data);
   
    for($i=0; $i<$count; $i++){
        $rouID = "rouID".$i;
        $routineID = $_POST[$rouID];
        
        $rouName = "rouName".$routineID;
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
    
    }
?>