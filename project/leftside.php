<?php
    if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];
?>

    <div class="col-md-2 col-xs-7 col-sm-3 sidebar sidebar-left sidebar-animate sidebar-md-show">
            <!-- 목표 리스트 -->
        <div class="goal">
          <ul class="nav navbar-stacked">
            <li class="active">
              <a href="?page=goal">목표1</a>
            </li>
            <li>
              <a href="?page=goal">목표2</a>
            </li>
            <li>
              <a href="?page=goal">목표3</a>
            </li>
            <li>
              <a href="?page=goal">목표4</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-plus" style="color: red;"> 추가하기</i></a>
            </li>
          </ul>
        </div>
            <hr>
            <!-- 리포트 리스트 -->
<?php
        
        include "db/dbconn.php";
        $sql = "select * from WeeklyReport where userID = $userid";
        $result =  mysqli_query($conn, $sql);
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $weeklyID = $row['weeklyID'];
            $date = $row['date'];
              
        
?>
        <div class="report">
          <ul class="nav navbar-stacked">
            <li class="active">
              <a href="?page=weekly&weeklyID=<?=$weeklyID?>">리포트1</a>
            </li>
            <li>
              <a href="?page=weekly&weeklyID=2">리포트2</a>
            </li>
            <li>
              <a href="?page=weekly&weeklyID=3">리포트3</a>
            </li>
            <li>
              <a href="?page=weekly">리포트4</a>
            </li>
            <li>
              <a href="?page=monthly">리포트5</a>
            </li>
          </ul>
        </div>
        
        <?php }
        ?>
            <!-- 하단 버튼메뉴 -->
        <div class="setting">
          <a href="#"><i class="fas fa-cog pull-right fa-2"></i></a>  
          <a href="#"><i class="fas fa-question-circle pull-right fa-2"></i></a>  
        </div>
        </div>