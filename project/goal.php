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
        $goalName = $row['goalName'];
        $term_s = $row['startTerm'];
        $term_e = $row['endTerm'];
    
            //목표 수정 폼
            echo '<form name="goal_modify_form" method="post" action="db/modify.php">';
            echo '<input style="display:none" id="goalID" type="text" name="goalID" value="'.$goalID.'">';        
    
            echo '<div id="goalName" style="margin-top:20px;"><h3 style="display:inline;"><b>'.$goalName.'</b></h3>
            <div id="goal_term" style="float:right;">'.$term_s.' ~ '.$term_e.'</div>
            </div><hr style="border:0; height:3px;background: #04005E;">';
    
            echo '</form>';
        ?>
    
            <form method="post">
                <input type="button" id="gmodify" style="float:right;" name="gmodify" onclick="goal_modify()" value="목표 수정"/>
                <input style="float:right;" type="submit" name="test" id="test" value="목표 삭제"/>
            </form>
    
        <?php
            function delete(){
                include "./db/dbconn.php";
                if(isset($_GET['goalID'])) $goalID = $_GET['goalID'];
                $goalDelete = "DELETE FROM goal WHERE goalID = '$goalID'";
                    
                if($conn->query($goalDelete) == TRUE){
                    echo("<script> alert('목표가 삭제되었습니다.');</script>");
                    /*$before = $goalID - 1;
                    echo "<script>location.href='goal.php?goalID=<?=$before?>'</script>";*/
                }
            }
    
            if(array_key_exists('test', $_POST)){
                delete();
            }
        ?>
    
            <?php
            $routine = "SELECT * FROM Routine WHERE goalID ='$goalID'";
            $result2 = mysqli_query($conn, $routine);
            $bid = 0;    
            $routineCount = 0;
        while($row2 = mysqli_fetch_array($result2)){
            $routineCount++;
            $routineID = $row2['routineID'];
            $routineName = $row2['routineName'];
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
              <input class="fa-2" style="color:'.$color.'"value="'.$row2['routineName'].'" readonly/></div>
              
            <button class="btn_prompt" onclick="dis('.$routineID.');" style="display:none;">루틴 수정</button>
            <form method="post">
                <input style="display:none;" type="text" name="rouID" value="'.$routineID.'"/>
                <input type="submit" style="display:none;" name="rou'.$bid.'" class="rou" value="루틴 삭제"/>
            </form>
        </div>
          ';
       ?> 
        
         <form class="goal_set_form" id="frm" name="goal_set_form" method="post" action="db/goalmodify.php">
        <!--해빗 트래커 칸 생성-->    
         <div id="basket<?=$routineID?>" class="container cart" style="background-color: <?=$color?>;">
             
            <!--루틴 수정 버튼 누를 시 데이터 넘겨줌-->
            <input style="display:none" id="goalName" type="text" name="goalName" value="<?=$goalName?>">
            <input style="display:none" id="routineNum" type="text" name="routineNum" value="<?=$routineID?>">
            <div class="row incart no-gutters">
            
                
               <?php
                /* 루틴 시작후 일주일 지났을 때 마다 check 초기화 */
                $today = date("Y-m-d");
                $start_yoli = date('w', strtotime($term_s)); //시작한 날의 요일
                $today_yoli = date('w', strtotime($today)); //현재 요일
                
                if($start_yoli == $today_yoli && $term_s != $today){
                    //시작한 요일과 현재 요일이 같고 && 지금이 시작일이 아니라면
                    $up = "update routine set habbitTracker='0' where routineID = '$routineID'";
                    $upresult = $conn->query($up); }
            
                $check = $row2['habbitTracker'];
            
                $dayNum = 0;
            
                while($dayNum<7){
                    $IntervalNum = $row2['rInterval'];
                    $interval = explode(';', $IntervalNum);
                    
                    if($interval[$dayNum] == 1){
                       echo '<div class="col-xs-1 col-md-1 con">';
                       if($check>0){
                           echo '<i id="jew" class="fa fa-trophy fa-2x" style="margin-top:3px; margin-left:3px; color:'.$color.'; aria-hidden="true"></i>';
                            $check--;
                            }                       
                       echo '</div>'; 
                    }
                $dayNum += 1;    
                }
            
                ?>
                
            </div>
        </div>
        </form>     
  <?php 
        $bid++;
        } echo '<br><br><br>'; 
    
        if(array_key_exists("rouID", $_POST)){
            $routineID = $_POST['rouID'];
            routine_delete($routineID);
        }
    
        function routine_delete($rou_ID){
            include "./db/dbconn.php";
            $rouDelete = "DELETE FROM routine WHERE routineID='$rou_ID'";
            if(isset($_GET['goalID'])) $goalID = $_GET['goalID'];
            
            if($conn->query($rouDelete) == TRUE){
                echo("<script> alert('루틴이 삭제되었습니다.');
                location.href='index.php?page=goal&goalID='+$goalID;
            </script>");
            
            }
        }
    
    
    ?>
        
    
    
       
      
        
    </div>
   
    
    <script>
        //var routine_num = 0;
        
        function dis(routine_num) {
            var content = document.getElementById("basket"+routine_num);
            var new_routine = '<input name="routine_name'+routine_num+'" class="routine_name" type="text" placeholder="루틴 이름" required/> <input type="color" name="colors'+routine_num+'"><br><p style="margin-bottom:10px;" required>주기　:<input id="mon'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="mon"><label for="mon'+routine_num+'">월</label><input id="tue'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="tue"><label for="tue'+routine_num+'">화</label><input id="wed'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="wed"><label for="wed'+routine_num+'">수</label><input id="thu'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="thu"><label for="thu'+routine_num+'">목</label><input id="fri'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="fri"><label for="fri'+routine_num+'">금</label><input id="sat'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sat"><label for="sat'+routine_num+'">토</label><input id="sun'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sun"><label for="sun'+routine_num+'">일</label><br/></p>';     
            routine_num++;
            new_routine += '<div id="div_routine'+routine_num+'"></div>';
            new_routine += '<input type="reset" value="삭제"><input type="submit" value="저장">';

            content.innerHTML += new_routine;
    }
        
        function goal_modify(){
            var modify_name = document.getElementById("goalName");
            var goal = '<input id="goal_name" name="goal_name" type="text" value="<?=$goalName?>" />';
            modify_name.innerHTML ='';
            modify_name.innerHTML += goal;
            
            var term = document.getElementById("goal_term");
            var goalTerm = '<label style="font-weight:normal;"><input type="date" value="<?=$term_s?>" name="term_s_date" style="margin-left: 60px; margin-top:10px;"> 부터 </label><label style="font-weight:normal;"><input type="date" value="<?=$term_e?>" name="term_e_date" style="margin-top:10px;"> 까지</label>';
            
            goalTerm += '<input type="button" onclick="javascript:location.reload(true)" value="취소">';
            goalTerm += '<input type="submit" value="저장">';
            modify_name.innerHTML += goalTerm;
            
            var rou_mod_btn = document.getElementsByClassName("btn_prompt");
            var rou_del_btn = document.getElementsByClassName("rou");
            var count = <?=$routineCount?>;
            for(var i=0;i<count;i++){
                rou_mod_btn[i].style = "display:visible";
                rou_del_btn[i].style = "display:visible";
            }
            
            var gmodify = document.getElementById("gmodify");
            
        }
    </script>
          
              
              
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
