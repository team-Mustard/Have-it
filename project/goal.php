<div class="col-md-1">
</div>
<div class="main col-md-8 col-md-offset-2">
            
    <script>
       /* function changeColor(change,i){
            var temp = 'basket' + i;
            var color = document.getElementById(temp);
            color.style.backgroundColor = change;                    
        }
        
        function changeColor2(change2, j){
            var temp2 = 'jew' + j;
            var color2 = document.getElementById(temp2);
            color2.style.color = change2;
            
    
            
        }*/

    </script>
     
              
    <?php
        include "./db/dbconn.php";
        if(isset($_GET['goalID'])) $goalID = $_GET['goalID'];
        $goal = "SELECT * FROM goal WHERE goalID = '$goalID'";              
              
        $result = mysqli_query($conn, $goal);
        
        $row = mysqli_fetch_array($result); 
        $term_s = $row['startTerm'];
        $term_e = $row['endTerm'];
        $today = date("Y-m-d");
    
            echo '<div style="margin-top:20px;"><h3 style="display:inline;"><b>'.$row['goalName'].'</b></h3>
            <span style="float:right;">'.$term_s.' ~ '.$term_e.'</span>
            </div><hr style="border:0; height:3px;background: #04005E;">';
            $routine = "SELECT * FROM Routine WHERE goalID ='$goalID'";
            $result2 = mysqli_query($conn, $routine);
                          
        while($row2 = mysqli_fetch_array($result2)){
            
            $routineID = $row2['routineID'];
            $color = $row2['color'];
            $tRoutine = "SELECT * FROM t_routine WHERE routineID = '$routineID'";
            $result3 = mysqli_query($conn, $tRoutine);
            
            //루틴 제목 출력
            echo '<div class="container cart" style="margin-top: 20px;">
          
          <div class="con1 text-center" style="float: left; margin-top: 12px; margin-right: 15px;">
              <i class="fas fa-tools" style="font-size:30px; color:'.$color.';"></i>
              <p style="color: '.$color.';">'.$color.'</p>
          </div>
          <div class="con1" style="margin-top: 8px; float: left; line-height: 45px;">
              <p class="fa-2" style="color:'.$color.'">'.$row2['routineName'].'</p></div></div>
          <div class="con1" style="float:right;"></div>';
        ?>
              
        <!-- 해빗 트래커 칸 생성 -->    
         <div id="basket" class="container cart" style="background-color: <?=$color?>;">
            <div class="row incart no-gutters">
                
               <?php    
                $check = $row2['habbitTracker'];
            
                $dayNum = 0;
            
                while($dayNum<7){
                    $IntervalNum = $row2['rInterval'];
                    $interval = explode(';', $IntervalNum);
                    
                    if($interval[$dayNum] == 1){
                       echo '<div class="col-xs-1 col-md-1 con">';
                       for($i=$check; $i>0; $i--){
                           echo '<i id="jew" class="fa fa-trophy fa-2x" style="margin-top:3px; margin-left:3px; color:'.$color.'; aria-hidden="true"></i>';
                            }                       
                       echo '</div>'; 
                    }
                $dayNum += 1;    
                }
            
                ?>
                
            </div>
        </div>
              
  <?php 
        
        } echo '<br><br><br>'; ?>
              
  
              
              
              
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
<div class="col-md-1">
</div>
© 2021 GitHub, Inc.
Terms
Privacy
Security
Status
Docs
Contact GitHub
Pricing
API
Training
Blog
About
Loading complete