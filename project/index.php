<?php
session_start();
if(isset($_SESSION['userid']))
    $_login = true; // 로그인 안돼있으면 소개 페이지로
else
    $_login = false;

if($_login == false){
    include_once "intro.php";
}
else {
    include_once "head.php";
    include_once "leftside.php";
    if(empty($_GET['page'])){
        include_once "example.php";
    } else if($_GET['page'] == 'goal') {
        include_once "goal.php";
    } else if($_GET['page'] == 'goal_set'){
        include_once "goal_set.php";  
    } else if($_GET['page'] == 'monthly') {
        include_once "monthly.php";
    } else if($_GET['page'] == 'weekly') {
        include_once "weekly.php";
    }
    include_once "rightside.php";
    include_once "bottom.php";
    
    echo "<script> bg_check(); $(function(){ $('html').removeClass('no-js'); }); </script>";
}

echo "<script> $(function() { $('*').attr('draggable', 'false').attr('unselectable', 'on').on('dragstart', function() {return false;}).find('*').attr('draggable', 'false').attr('unselectable', 'on'); }); </script>";

?>