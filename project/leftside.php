
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
        /*
            TODO: 월간 리포트 주간 리포트 날짜 별로 출력
        
        */
        $weeklySql = "select weeklyID, date from WeeklyReport where userID = $userid";
        $weeklyResult =  mysqli_query($conn, $weeklySql);
        if($weeklyResult){
 
            while( $weeklyRow = mysqli_fetch_array($weeklyResult,MYSQLI_ASSOC)){
                          
            $weeklyID = $weeklyRow['weeklyID'];
            $weeklyDate = $weeklyRow['date'];
                         
        
?>
            <li class="active">
              <a href="?page=weekly&weeklyID=<?=$weeklyID?>">[주] <?=$weeklyDate?> 리포트</a>
            </li>
              
      
        
        <?php 
            }
        }
        
        $monthlySql = "select monthlyID, date from MonthlyReport where userID = $userid";
        $monthlyResult = mysqli_query($conn,$monthlySql);    
        if($monthlyResult){
 
            while( $monthlyRow = mysqli_fetch_array($monthlyResult,MYSQLI_ASSOC)){
                          
            $monthlyID = $monthlyRow['monthlyID'];
            $monthlyDate = $monthlyRow['date'];
                         
        
?>
            <li class="active">
              <a href="?page=monthly&monthlyID=<?=$monthlyID?>">[월] <?=$monthlyDate?> 리포트</a>
            </li>
              
      
        
        <?php 
            }
        }      
          ?>   
              
          </ul>
        </div>
            <!-- 하단 버튼메뉴 -->
        <div class="setting">
          <a href="#"><i class="fas fa-question-circle fa-2"></i></a>  
        </div>
        </div>
