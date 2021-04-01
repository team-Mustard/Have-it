<?php
$_login = true; // 로그인 안돼있으면 소개 페이지로
if($_login == false){
    include_once "intro.php";
}
else {
    include_once "head.php";
    include_once "leftside.php";
    if($_page == 0){
        include_once "goal.php";
    if(empty($_GET['page'])){
        include_once "example.php";
    } else if($_GET['page'] == 'goal') {
        include_once "goal.php";
    } else if($_GET['page'] == 'monthly') {
        include_once "monthly.php";
    } else if($_GET['page'] == 'weekly') {
        include_once "weekly.php";
    }
    include_once "rightside.php";
    include_once "bottom.php";
}
?>