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

$lastID = 1;

?>

<div class="main col-md-8 col-md-offset-2">
    <form name="goalForm" method="post" action="./db/goalmodify.php">
        <!-- goal id -->
        <input type="text" name="goalID" value="<?=$goalID?>" style="display:none;">
        
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
            <input value="목표 삭제" id="goalRemove" onclick="goalDelete(1);" class="word_4_btn bg_gray_btn round_btn" type="button" />
            <input value="목표 수정" id="goalModyfy" onclick="modify();" class="word_4_btn bg_purple_btn round_btn" type="button"/>
            <input value="수정 완료" id="goalSubmit" onclick="goalDelete(2);" class="word_4_btn bg_purple_btn round_btn modi_form" type="button"> 
        </div>

        <div class="clear"></div>

        <!-- routine (for) -->
        <?php
        $routine = "SELECT * FROM Routine WHERE goalID ='$goalID'";
        $result2 = mysqli_query($conn, $routine);
        
        while($row2 = mysqli_fetch_array($result2)){
            $routineID = $row2['routineID'];
            $color = $row2['color'];
            $routineName = $row2['routineName'];
            $Inter = $row2['rInterval'];
            $rInter = explode(';', $Inter);
            
        echo '    
        <div class="routine">
            <!-- routine id -->
            <input type="text" value="'.$routineID.'" style="display:none;">
            
            <!-- print -->
            <div class="routinePrint">
                <div class="routineIcon text-center left">
                    <i class="fas fa-tools" style="font-size:30px; color: '.$color.';"></i>
                    <p style="color: '.$color.';">'.$color.'</p>
                </div>
                <span class="routineName left">
                    <p class="fa-2" style="color:'.$color.';">'.$routineName.'</p>
                </span>
                <div id="basket'.$routineID.'" class="routineBasket clear" style="background-color: '.$color.'; height: 50px;">';
                
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
                $bcount = 0;
            
                while($dayNum<7){
                    $IntervalNum = $row2['rInterval'];
                    $interval = explode(';', $IntervalNum);
                    
                    if($interval[$dayNum] == 1){
                        $bcount += 1;
                       echo '<div class="col-xs-1 col-md-1 con">';
                       if($check>0){
                           echo '<i id="jew" class="fa fa-trophy fa-2x" style="margin-top:3px; margin-left:3px; color:'.$color.'; aria-hidden="true"></i>';
                            $check--;
                            }                       
                       echo '</div>'; 
                    }
                $dayNum += 1;    
                }
            
            echo '
                
                </div>
            </div>
            
            <!-- edit -->
            <div class="routineEdit modi_form goal_set_form">
                <input value="'.$routineName.'" type="text" class="routine_name"/>
                <input type="color" name="colors'.$routineID.'" value="'.$color.'">
                <input id="delete" class="rou" type="submit" name="mode" value="x"/>
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
        }
    ?>
        <!-- routine add button and logic -->
        <div class="routinePlus modi_form goal_set_form">
            <input id="plus_btn" value="+ 루틴 추가하기" onclick="addRoutine(<?=$lastID?>);" type="button" />
            <div id="bas<?=$lastID?>"></div>
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
        document.getElementById("goalModyfy").classList += ' modi_form';

    }
    
    function addRoutine(routine_num) {
        var newRoutine = document.getElementById("bas"+routine_num);

        var form = '<input name="routine_name'+routine_num+'" class="routine_name" type="text" placeholder="루틴 이름" required/>\
        <input type="color" name="colors'+routine_num+'"><br>\
        <p style="margin-bottom:10px;" required>주기　:\
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

        btn_count++;
        var routineSpace = routine_num + btn_count;
        form += '<div id="bas'+routineSpace+'"></div>';
        newRoutine.innerHTML += form;
    }
    
    function goalDelete(index){
        if (index == 1){
            document.goalForm.action='./db/goaldelete.php';
        }
        else if(index == 2){
            document.goalForm.action='./db/goalmodify.php';
        }
        document.goalForm.submit();
    }
    
</script>