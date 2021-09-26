<div class="col-md-1">
</div>

<?php

// 여기서 DB 처리해주세용

$goalID = "1";
$routineID = ['a', 'b', 'c'];

$goalName = "목표 이름입니다.";
$term_s = "2020-05-05";
$term_e = "2020-05-05";
$term_s_dot = str_replace("-", ".", $term_s);
$term_e_dot = str_replace("-", ".", $term_e);

$color = "#ff00ff";
$routineName = "루틴 이름입니다.";
$lastID = 1;

?>

<div class="main col-md-8 col-md-offset-2">
    <form method="post" action="./db/goalmodify.php">
        <!-- goal id -->
        <input type="text" value="<?=$goalID?>" style="display:none;">
        
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
            <input value="목표 삭제" id="goalRemove" class="word_4_btn bg_gray_btn round_btn" type="submit" />
            <input value="목표 수정" id="goalModyfy" onclick="modify();" class="word_4_btn bg_purple_btn round_btn" type="button"/>
            <input value="수정 완료" id="goalSubmit" class="word_4_btn bg_purple_btn round_btn modi_form" type="submit"> 
        </div>

        <div class="clear"></div>

        <!-- routine (for) -->

        <div class="routine additional_space">
            <!-- routine id -->
            <input type="text" value="<?=$routineID?>" style="display:none;">
            
            <!-- print -->
            <div class="routinePrint">
                <div class="routineIcon text-center left">
                    <i class="fas fa-tools" style="font-size:30px; color: <?=$color?>;"></i>
                    <p style="color: <?=$color?>;"><?=$color?></p>
                </div>
                <span class="routineName left">
                    <p class="fa-2" style="color:<?=$color?>;"><?=$routineName?></p>
                </span>
                <div id="basket<?=$routineID?>" class="routineBasket clear" style="background-color: <?=$color?>; height: 50px;">
                </div>
            </div>

            <!-- edit -->
            <div class="routineEdit modi_form goal_set_form">
                <input value="<?=$routineName?>" type="text" class="routine_name"/>
                <input type="color" name="colors<?=$routineID?>" value="<?=$color?>">
                <input id="delete" class="rou" type="submit" name="mode" value="x"/>
                <p style="margin-bottom:10px;">주기　:
                    <input id="sun<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="sun"><label for="sun<?=$routineID?>">일</label>
                    <input id="mon<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="mon"><label for="mon<?=$routineID?>">월</label>
                    <input id="tue<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="tue"><label for="tue<?=$routineID?>">화</label>
                    <input id="wed<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="wed"><label for="wed<?=$routineID?>">수</label>
                    <input id="thu<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="thu"><label for="thu<?=$routineID?>">목</label>
                    <input id="fri<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="fri"><label for="fri<?=$routineID?>">금</label>
                    <input id="sat<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="sat"><label for="sat<?=$routineID?>">토</label>
                </p>
            </div>
        </div>

        <div class="routine additional_space">
            <!-- routine id -->
            <input type="text" value="<?=$routineID?>" style="display:none;">
            
            <!-- print -->
            <div class="routinePrint">
                <div class="routineIcon text-center left">
                    <i class="fas fa-tools" style="font-size:30px; color: <?=$color?>;"></i>
                    <p style="color: <?=$color?>;"><?=$color?></p>
                </div>
                <span class="routineName left">
                    <p class="fa-2" style="color:<?=$color?>;"><?=$routineName?></p>
                </span>
                <div id="basket<?=$routineID?>" class="routineBasket clear" style="background-color: <?=$color?>; height: 50px;">
                </div>
            </div>

            <!-- edit -->
            <div class="routineEdit modi_form goal_set_form">
                <input value="<?=$routineName?>" type="text" class="routine_name"/>
                <input type="color" name="colors<?=$routineID?>" value="<?=$color?>">
                <input id="delete" class="rou" type="submit" name="mode" value="x"/>
                <p style="margin-bottom:10px;">주기　:
                    <input id="sun<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="sun"><label for="sun<?=$routineID?>">일</label>
                    <input id="mon<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="mon"><label for="mon<?=$routineID?>">월</label>
                    <input id="tue<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="tue"><label for="tue<?=$routineID?>">화</label>
                    <input id="wed<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="wed"><label for="wed<?=$routineID?>">수</label>
                    <input id="thu<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="thu"><label for="thu<?=$routineID?>">목</label>
                    <input id="fri<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="fri"><label for="fri<?=$routineID?>">금</label>
                    <input id="sat<?=$routineID?>" type="checkbox" name="routine<?=$routineID?>[]" value="sat"><label for="sat<?=$routineID?>">토</label>
                </p>
            </div>
        </div>
        
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
</script>