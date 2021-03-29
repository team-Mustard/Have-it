<?php
$_login = false; // 로그인 안돼있으면 소개 페이지로
$_page = 0; // 페이지 선택(처음 들어가면 example 페이지가 보이도록)
if($_login == false){
    include_once "intro.php";
}
else {
    include_once "head.php";
    include_once "leftside.php";
    if($_page == 0){
        include_once "example.php";
    }
    include_once "rightside.php";
    include_once "bottom.php";
}
?>