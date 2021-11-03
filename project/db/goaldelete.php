<?php
    
    include "dbconn.php";
    session_start();
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];


    $arrID = [];
    $res = 0;   

    $goalID = $_POST['goalID'];

    $Dgoal = "DELETE FROM goal WHERE goalID='$goalID'";

    if($conn->query($Dgoal) == TRUE){
        echo("<script> alert('목표가 삭제되었습니다.');</script>");
        
        /*기간 내에 존재하는 목표 ID 받아옴 */
        $goal = "select * from goal where userID = $userid";
        $result2 = mysqli_query($conn, $goal);   
        $today = date("Y-m-d");      
                    
        if($result2){
            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                $goalID = $row2['goalID'];
                $goalName = $row2['goalName'];

                $start = $row2['startTerm'];
                $end = $row2['endTerm'];
                $str_now = strtotime($today);
                $str_target = strtotime($start);
                $str_target2 = strtotime($end);

                if($str_now >= $str_target && $str_now <= $str_target2){
                    $arrID[$res++] = $goalID;
                }
            }
        }
        /* 여기까지 */
        
        if(empty($arrID)){ //배열이 비어있으면
            $url = "http://localhost/Have-it/project/index.php";
            echo("<script>location.href='$url'</script>");
        }
        else{
            $l_goalID = $arrID[0];
            $url2 = "http://localhost/Have-it/project/index.php?page=goal&goalID=".$l_goalID;
            echo("<script>location.href='$url2'</script>");
        }
        
    }

?>