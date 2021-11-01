
<?php
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
?>

    <div class="col-md-2 col-xs-7 col-sm-3 sidebar sidebar-left sidebar-animate sidebar-md-show">

 
        <div class="goal">
          <h5 class="list-header text-center"><b>💎나의 보석함💎</b></h5>
          <ul class="nav navbar-stacked">
<?php
        include "db/dbconn.php";
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
?>
        <li class="active">
            <a href="?page=goal&goalID=<?=$goalID?>"> <?=$goalName?></a>
        </li>
            <!-- 목표 리스트 -->
        
        <?php } } } ?>
            <li>
              <a href="?page=goal_set"><i class="fas fa-plus" style="color: red;"> 추가하기</i></a>
            </li>
          </ul>
        </div>
        
        
            <hr>
            <!-- 리포트 리스트 -->

        <div class="report">
          <h5 class="list-header text-center"><b>📃품질 보증서📃</b></h5>
          <ul class="nav navbar-stacked">
<?php
        
        $weeklySql = "select weeklyID, date from WeeklyReport where userID = $userid";
        $weeklyResult =  mysqli_query($conn, $weeklySql);
        $count = 0;
        if($weeklyResult){
 
            while( $weeklyRow = mysqli_fetch_array($weeklyResult,MYSQLI_ASSOC)){
                          
                $reportID[$count] = $weeklyRow['weeklyID'];
                $reportDate[$count] = $weeklyRow['date'];
                $reportKind[$count] = 1;
                $count++;

?>
      
              
      
        
        <?php 
            }
        }
        
        $monthlySql = "select monthlyID, date from MonthlyReport where userID = $userid";
        $monthlyResult = mysqli_query($conn,$monthlySql);    
        if($monthlyResult){
 
            while( $monthlyRow = mysqli_fetch_array($monthlyResult,MYSQLI_ASSOC)){
                          
                $reportID[$count] = $monthlyRow['monthlyID'];
                $reportDate[$count] = $monthlyRow['date'];
                $reportKind[$count] = 2;
                $count++;
                
?>
            
              
      
        
        <?php 
            }
        }   
  
        for($i=0;$i<$count-1;$i++){
          for($j = $i+1;$j<$count;$j++){
              $min = $i;
              if(strtotime($reportDate[$j]) < strtotime($reportDate[$min])){
                  $min = $j;
              }
              $temp = $reportDate[$min];
              $reportDate[$min] = $reportDate[$i];
              $reportDate[$i] = $temp;
              
              $temp = $reportID[$min];
              $reportID[$min] = $reportID[$i];
              $reportID[$i] = $temp;
              
              $temp = $reportKind[$min];
              $reportKind[$min] = $reportKind[$i];
              $reportKind[$i] = $temp;
              
              
          }
    
        }
              
    
              
        for($w=$count-1;$w>=0;$w--){
            
            if($reportKind[$w]==1){
                $tmpDate =  date("Y-m-d",strtotime($reportDate[$w].'-1 days'));
                echo "<li class='active'>
                <a href='?page=weekly&weeklyID=$reportID[$w]'>[주] $tmpDate 리포트</a>
                </li>";
               
            }
            if($reportKind[$w]==2){
                $tmpDate =  date("Y-m-d",strtotime($reportDate[$w].'-1 days'));
                echo "<li class='active'>
                <a href='?page=monthly&monthlyID=$reportID[$w]'>[월] $tmpDate 리포트</a>
                </li>";
               
            }
            
        }
             
          ?>   
              
          </ul>
        </div>
        </div>
