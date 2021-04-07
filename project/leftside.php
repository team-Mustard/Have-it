
<?php
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
?>

    <div class="col-md-2 col-xs-7 col-sm-3 sidebar sidebar-left sidebar-animate sidebar-md-show">

 
        <div class="goal">
          <ul class="nav navbar-stacked">
<?php
        include "db/dbconn.php";
        $goal = "select * from goal where userID = $userid";
        $result2 = mysqli_query($conn, $goal);
        
        if($result2){
            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                $goalID = $row2['goalID'];
                $goalName = $row2['goalName'];
?>
        <li class="active">
            <a href="?page=goal&goalID=<?=$goalID?>"> <?=$goalName?></a>
        </li>
            <!-- 목표 리스트 -->
        
        <?php } } ?>
            <li>
              <a href="#"><i class="fas fa-plus" style="color: red;"> 추가하기</i></a>
            </li>
          </ul>
        </div>
        
        
            <hr>
            <!-- 리포트 리스트 -->

        <div class="report">
          <ul class="nav navbar-stacked">
<?php
        
        $sql = "select * from WeeklyReport where userID = $userid";
        $result =  mysqli_query($conn, $sql);
        if($result){
 
            while( $row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                          
            $weeklyID = $row['weeklyID'];
            $date = $row['date'];
                         
        
?>
            <li class="active">
              <a href="?page=weekly&weeklyID=<?=$weeklyID?>">[주] <?=$date?> 리포트</a>
            </li>
              
      
        
        <?php 
            }
        }
        ?>
                      
              
          </ul>
        </div>
            <!-- 하단 버튼메뉴 -->
        <div class="setting">
          <a href="#"><i class="fas fa-cog pull-right fa-2"></i></a>  
          <a href="#"><i class="fas fa-question-circle pull-right fa-2"></i></a>  
        </div>
        </div>
