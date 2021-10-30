<div class="col-md-1">
</div>

<?php

include "./db/dbconn.php";
if(isset($_SESSION['userid'])) $userid = $_SESSION['userid'];

if(isset($_GET['goalID'])) $goalID = $_GET['goalID'];
$goal = "SELECT * FROM goal WHERE goalID = '$goalID'";              
$result = mysqli_query($conn, $goal);
$row = mysqli_fetch_array($result);

$goalName = $row['goalName'];
$term_s = $row['startTerm'];
$term_e = $row['endTerm'];
$term_s_dot = str_replace("-", ".", $term_s);
$term_e_dot = str_replace("-", ".", $term_e);

$last = "SELECT * FROM routine ORDER BY routineID DESC LIMIT 1";
$l_result = mysqli_query($conn, $last);
$l_row = mysqli_fetch_array($l_result);
$lastID = $l_row['routineID'];
$lastID += 1;

/* 루틴 예외처리를 위해 필요한 데이터들 */
$e_routine = "SELECT * FROM Routine WHERE goalID ='$goalID'";
$e_result = mysqli_query($conn, $e_routine);
$e_row = mysqli_fetch_array($e_result);

$e_count = mysqli_num_rows($e_result); //루틴 개수
$e_ID = $e_row['routineID']; // 처음 루틴 ID

?>

<div class="main col-md-8 col-md-offset-2">
    <form name="goalForm" method="post" action="./db/goalmodify.php">
        <!-- goal id -->
        <input type="text" name="goalID" value="<?=$goalID?>" style="display:none;">
        <input type="text" name="ex_goalName" value="<?=$goalName?>" style="display:none;"> 
        
        <div class="goalNameZone">
            <!-- goal edit -->
            <div class="goalEdit modi_form">
                <input type="text" name="goalName" id="goalName" value="<?=$goalName?>"/>
                <span class="right">
                    <input type="date" value="<?=$term_s?>" name="termS"/> ~ 
                    <input type="date" value="<?=$term_e?>" name="termE"/>
                </span>
            </div>
            <div class="clear"></div>
            <!-- goal print -->
            <div class="goalPrint">
                <h3 style="display: inline;"><b><?=$goalName?></b></h3>
                <span class="right"><?=$term_s_dot?> ~ <?=$term_e_dot?></span>
            </div>
            
        </div>
        <hr style="border:0; height:3px;background: #04005E;">
        <div class="clear"></div>

        <!-- buttons --> 
        <div class="right">
            <input value="목표 삭제" id="goalRemove" onclick="goalDelete();" class="word_4_btn bg_gray_btn round_btn" type="button" />
            <input value="목표 수정" id="goalModify" onclick="modify()" class="word_4_btn bg_purple_btn round_btn" type="button"/>
            <input value="수정 완료" id="goalSubmit" onclick="count_return(); modifyDone();" class="word_4_btn bg_purple_btn round_btn modi_form" type="button"> 
        </div>

        <div class="clear"></div>
        
        <!-- routine (for) -->
        <?php
        $routine = "SELECT * FROM Routine WHERE goalID ='$goalID'";
        $result2 = mysqli_query($conn, $routine);
        $bid = 0;
        
        echo "<script> let a = 0; let arrID = []; 
        let plus_a = 0; let plus_arrID = [];
        </script>";
               
        while($row2 = mysqli_fetch_array($result2)){
            $routineID = $row2['routineID'];
            $color = $row2['color'];
            $routineName = $row2['routineName'];
            $Inter = $row2['rInterval'];
            $rInter = explode(';', $Inter);
            $all_routine[$bid] = $routineID;
            
            echo "
            <script>
            arrID[a] = ".$routineID.";
            a++; </script>";
            
        echo '    
        <div class="routine text-center">
            <!-- routine id -->
            <input style="display:none;" type="text" name="rouID'.$bid.'" value="'.$routineID.'">
            
            <!-- print -->
            <div class="routinePrint">
                <div class="routineIcon text-center left">
                    <i class="fas fa-tools" style="font-size:30px; color: '.$color.';"></i>
                    <p style="color: '.$color.';">'.$color.'</p>
                </div>
                <span class="routineName left">
                    <p class="fa-2" style="color:'.$color.';">'.$routineName.'</p>
                </span>
                <div id="basket'.$routineID.'" class="routineBasket clear" style="background-color: '.$color.'; height: 45px;">';
                
                /* 루틴 시작후 월요일마다 check 초기화 */
                $today = date("Y-m-d");
                $today_yoli = date('w', strtotime($today)); //현재 요일
                
                if($today_yoli == 1 && $term_s != $today){
                    //지금이 월요일이고 && 지금이 시작일이 아니라면
                    $up = "update routine set habbitTracker='0' where routineID = '$routineID'";
                    $upresult = $conn->query($up); }
            
                $check = $row2['habbitTracker'];
            
                $dayNum = 0;
                $bcount = 0;
            
                while($dayNum<7){
                    $IntervalNum = $row2['rInterval'];
                    $interval = explode(';', $IntervalNum);
                    $habbit = explode(';', $check);
                    
                    if($interval[$dayNum] == 1){
                        $bcount += 1;
                        echo '<div class="col-xs-1 col-md-1 con">';
                        if($habbit[$dayNum] >= 1){ 
                           echo '<i id="jew" class="fa fa-trophy fa-2x" style="margin-top:4px; margin-left:-11.5px; color:'.$color.'; aria-hidden="true"></i>';
                            }
                        else if($habbit[$dayNum] == 0){
                            switch($dayNum){
                                case 1:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-12px; color:'.$color.';">MON</p>';
                                    break;
                                case 2:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-10.5px; color:'.$color.';">TUE</p>';
                                    break;
                                case 3:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-12px; color:'.$color.';">WED</p>';
                                    break;
                                case 4:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-10px; color:'.$color.';">THU</p>';
                                    break;
                                case 5:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-7.5px; color:'.$color.';">FRI</p>';
                                    break;
                                case 6:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-9px; color:'.$color.';">SAT</p>';
                                    break;
                                case 0:
                                    echo '<p class="wday" style="margin-top:7px; margin-left:-11px; color:'.$color.';">SUN</p>';
                                    break;
                            }
                        }
                       echo '</div>'; 
                    }
                $dayNum += 1;    
                }
            
            echo '
                
                </div>
            </div>
            
            <!-- edit -->
            <div id="rouedit" class="routineEdit modi_form goal_set_form additional_space">
                <input name="rouName'.$routineID.'" value="'.$routineName.'" type="text" class="routine_name"/>
                <input type="color" name="colors'.$routineID.'" value="'.$color.'">
                <input id="delete" class="rou" onclick="plusrouID('.$routineID.')" type="button" name="mode" value="x"/>
                <p style="margin-bottom:10px;">주기　:      
                
                    <input id="sun'.$routineID.'" type="checkbox"';
                    echo ($rInter[0]==1 ? 'checked' : ''); echo ' name="routine'.$routineID.'[]" value="sun"><label for="sun'.$routineID.'">일</label>
                    <input id="mon'.$routineID.'" type="checkbox"';
                    echo ($rInter[1]==1 ? 'checked' : ''); echo '  name="routine'.$routineID.'[]" value="mon"><label for="mon'.$routineID.'">월</label>
                    <input id="tue'.$routineID.'" type="checkbox"';
                    echo ($rInter[2]==1 ? 'checked' : ''); echo '
                    name="routine'.$routineID.'[]" value="tue"><label for="tue'.$routineID.'">화</label>
                    <input id="wed'.$routineID.'" type="checkbox"';
                    echo ($rInter[3]==1 ? 'checked' : ''); echo ' name="routine'.$routineID.'[]" value="wed"><label for="wed'.$routineID.'">수</label>
                    <input id="thu'.$routineID.'" type="checkbox"';
                    echo ($rInter[4]==1 ? 'checked' : ''); echo ' name="routine'.$routineID.'[]" value="thu"><label for="thu'.$routineID.'">목</label>
                    <input id="fri'.$routineID.'" type="checkbox"';
                    echo ($rInter[5]==1 ? 'checked' : ''); echo ' name="routine'.$routineID.'[]" value="fri"><label for="fri'.$routineID.'">금</label>
                    <input id="sat'.$routineID.'" type="checkbox"';
                    echo ($rInter[6]==1 ? 'checked' : ''); echo ' name="routine'.$routineID.'[]" value="sat"><label for="sat'.$routineID.'">토</label>
                </p>
            </div>
        </div>';
        $bid++;
        }
    ?>
        <!-- routine add button and logic -->
        <div class="routinePlus modi_form goal_set_form">
            <div id="bas<?=$lastID?>" class="text-center additional_space"></div>
            <input id="plus_btn" value="+ 루틴 추가하기" onclick="addRoutine(<?=$lastID?>);" type="button" />
            <div id="bas<?=$lastID?>"></div>
            <div id="btn_count_return"></div>
        </div>
    
    </form>
</div>
</div>
<div class="col-md-1">
</div>

<script>
    let btn_count = 0;

    function modify() {
        let modi_form = document.getElementsByClassName("modi_form");
        let routines = document.getElementsByClassName("routinePrint");

        for(let i = modi_form.length-1 ; i >= 0; i--) {
            modi_form[i].classList.remove("modi_form");
        }
        for(let i = routines.length-1 ; i >= 0; i--) {
            routines[i].classList += ' modi_form';
        }
        document.getElementsByClassName("goalPrint")[0].classList += ' modi_form';
        document.getElementById("goalModify").classList += ' modi_form';

    }
    
    function addRoutine(routine_num) {
        routine_num += btn_count;
        var newRoutine = document.getElementById("bas"+routine_num);

        var form = '<input name="routine_name'+routine_num+'" class="routine_name" type="text" placeholder="루틴 이름" required/>\
        <input type="color" name="colors'+routine_num+'"><br>\
        <p style="margin-bottom:25px;" required>주기　:\
        <input id="sun'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sun">\
        <label for="sun'+routine_num+'">일</label>\
        <input id="mon'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="mon">\
        <label for="mon'+routine_num+'">월</label>\
        <input id="tue'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="tue">\
        <label for="tue'+routine_num+'">화</label>\
        <input id="wed'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="wed">\
        <label for="wed'+routine_num+'">수</label>\
        <input id="thu'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="thu">\
        <label for="thu'+routine_num+'">목</label>\
        <input id="fri'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="fri">\
        <label for="fri'+routine_num+'">금</label>\
        <input id="sat'+routine_num+'" type="checkbox" name="routine'+routine_num+'[]" value="sat">\
        <label for="sat'+routine_num+'">토</label>';
        
        form += '<input name="plusID'+btn_count+'" type="text" style="display:none;" value="'+routine_num+'">';
        
        btn_count++;
        var routineSpace = routine_num + 1;
        //arrID[a++] = routine_num;
        plus_arrID[plus_a++] = routine_num;
        form += '<div id="bas'+routineSpace+'" class="text-center additional_space"></div>';
        newRoutine.innerHTML += form;
    }
    
    function goalDelete(){
        document.goalForm.action='./db/goaldelete.php';
        document.goalForm.submit();
    }
    
    function modifyDone(){
        //받아와야 하는 것 -> 첫번째 루틴의 아이디, 루틴의 개수, 새로 추가한 루틴의 아이디/개수는->btn_count 있음
       
        if(goal_submit() == false){
            return;
        }
        else{
            document.goalForm.action='./db/goalmodify.php';
            document.goalForm.submit();
        }
        
    }
    
    function goal_submit(){
        var rad = document.goalForm.term;
        
        let c = <?=$e_count?>;
        let r = <?=$e_ID?>;
        
        //목표 입력 x, 30자 초과
        var goal_name = document.getElementsByName("goalName")[0].value;
        var g_length = goal_name.length;
        
        if(g_length == 0){
            alert("목표 이름을 입력해 주세요!");
            return false;
        }
        else if(g_length > 30){
            alert("목표 이름이 30자를 초과하였습니다!");
            return false;
        }
      
        /* 기존의 루틴 요일 체크 */
        for(var i=0; i<a; i++){
            var x = arrID[i];
            var routines = document.getElementsByName("routine"+x+"[]");
            var check = checkbox_permit(routines);
            
            if (check == false) {
                //var name_routine = document.getElementsByName("routine_name"+r)[0].value;
                alert("루틴의 주기를 하루 이상 체크해 주세요!");
                return false;
            }
        }
        
        /* 추가된 루틴 요일 체크 */
        for(var h=0; h<a; h++){
            var n = arrID[h];
            var p_routines = document.getElementsByName("routine"+n+"[]");
            var p_check = checkbox_permit(p_routines);
            
            if (p_check == false) {
                //var name_routine = document.getElementsByName("routine_name"+r)[0].value;
                alert("루틴의 주기를 하루 이상 체크해 주세요!");
                return false;
            }
        }
        
        /* 기존의 루틴 오류처리 */
        for(var j=0; j<a; j++){
            var y = arrID[j];
            var routineName = document.getElementsByName("rouName"+y)[0].value;
            var r_length = routineName.length;
            
            if(r_length == 0){
                var z = j+1; 
                alert(z+"번째 루틴의 이름을 입력하세요");
                return false;
            }
            else if(r_length > 50){
                var z = j+1;
                alert(z+"번째 루틴이 50자를 초과하였습니다.");
                return false;
            }
        }
        
        /* 추가된 루틴 오류처리 */
        for(var q=0; q<plus_a; q++){
            var k = plus_arrID[q];
            var p_routineName = document.getElementsByName("routine_name"+k)[0].value;
            var p_r_length = p_routineName.length;
            
            if(p_r_length == 0){
                var t = a+q+1; 
                alert(t+"번째 루틴의 이름을 입력하세요");
                return false;
            }
            else if(p_r_length > 50){
                var t = a+q+1;
                alert(t+"번째 루틴이 50자를 초과하였습니다.");
                return false;
            }
        }
    }
    
    function checkbox_permit(routines) {
        let result = false;
        for(var i=0; i<routines.length; i++) {
            if(routines[i].checked){
                //console.log(routines[i]);
                result = true;
            }
        }
        return result;
    }
    
    function plusrouID(routineID){
        document.goalForm.action='./db/routinedelete.php?rouID='+routineID;
        document.goalForm.submit();
    }
    
    function count_return(){
        var con = document.getElementById("btn_count_return");
        var plus_con = '<input name="btn_count" type="text" value="'+btn_count+'" style="display:none;">';
        
        con.innerHTML += plus_con;
    }
</script>