<?php

    include_once "./head.php";
    include_once "./leftside.php";
    include_once "./rightside.php";
?>


        <div class="main col-md-10 col-md-offset-2">
          <div class="page-header">
            
    <script>
        function changeColor(change){
            var color = document.getElementById("basket");
            var color2 = document.getElementById("jew");
            color.style.backgroundColor = change;
            color2.style.color = change;                       
        }
        
        function changeColor2(change){
            var color = document.getElementById("basket2");
            var color2 = document.getElementById("jew2");
            color.style.backgroundColor = change;
            color2.style.color = change;
        }
    </script>
     
              
    <?php
        include "./db/dbconn.php";
        $goal_title = "SELECT * FROM goal WHERE userID = 1";
        $routine = "SELECT * FROM Routine WHERE goalID = 1";
        
            
        $result = mysqli_query($conn, $goal_title);
        $result2 = mysqli_query($conn, $routine);
        
        
              
        $row = mysqli_fetch_array($result);
        echo '<h3>'.$row['goalName'].'</h3>';
        
        while($row2 = mysqli_fetch_array($result2)){
        
            $routineID = $row2['routineID'];
            $checkRoutine = "SELECT * FROM t_routine WHERE routineID = '$routineID'";
            $result3 = mysqli_query($conn, $checkRoutine);
            
            echo '<div class="container cart" style="background-color: white; margin-top: 20px;">
          <div class="con1" style="float: left; margin-right: 40px;">
              <form>
                  <div class="colors">
                      <p> 색깔 설정 </p>
                      <input type=\'color\' id=\'myColor\' onclick="changeColor(this.value)">
                  </div>
              </form>
          </div>
          <div class="con1" style="float: left; margin-top: 12px; margin-right: 15px;">
              <img src="title.png" width="52px" height="50px">
          </div>
          <div class="con1" style="margin-top: 8px; float: left;">
              <h3>'.$row2['routineName'].'</div></div>';
    ?>
            
         <div id="basket" class="container cart">
            <div class="row incart no-gutters">
                
               <?php    
                $check = 1;
                while($row3 = mysqli_fetch_array($result3)){
                    if($row3['checkRoutine'] == 0){
                        $check = 0;
                    }
                }
            
                $dayNum = 0;
                while($dayNum<7){
                    $IntervalNum = $row2['rInterval'];
                    $interval = explode(';', $IntervalNum);
                    
                    if($interval[$dayNum] == 1){
                       echo '<div class="col-xs-1 col-md-1 con">';
                       if($check == 1){
                           echo '<i id="jew" class="jew fa fa-trophy fa-3x" style="margin-top:7px; margin-left:7px" aria-hidden="true"></i>';
                       }                       
                       echo '</div>'; 
                    }
                $dayNum += 1;    
                }
            
                ?>
                
            </div>
        </div>
              
  <?php } ?>
              
              
    <!-- 위에 들어가있는 코드 (보기 편한 버전 냄겨놓음..)
       <div class="container cart" style="background-color: white; margin-top: 20px;">
          <div class="con1" style="float: left; margin-right: 40px;">
              <form>
                  <div class="colors">
                      <p> 색깔 설정 </p>
                      <input type='color' id='myColor' onclick="changeColor(this.value)">
                  </div>
              </form>
          </div>
          <div class="con1" style="float: left; margin-top: 12px; margin-right: 15px;">
              <img src="title.png" width="52px" height="50px">
          </div>
          <div class="con1" style="margin-top: 8px; float: left;">
              <h3> 에메랄드 광산 캐기 </h3>
          </div>
      </div>      
        
        <div id="basket2" class="container cart">
            <div class="row incart no-gutters">             
                <div class="col-xs-1 col-md-1 con"><i id="jew2" class="jew fa fa-trophy fa-3x" style="margin-top:7px; margin-left:7px" aria-hidden="true"></i></div>
                <div class="col-xs-1 col-md-1 con"></div>
                <div class="col-xs-1 col-md-1 con"></i></div>
                <div class="col-xs-1 col-md-1 con"></div>
                
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>
                <div class="col-xs-1 col-md-1 con"> </div>  

            </div>
        </div>
-->
</div>
</div>