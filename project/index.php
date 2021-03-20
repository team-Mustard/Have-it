<?php
$_page = 0; // 페이지 선택(처음 들어가면 example 페이지가 보이도록)
    include_once "head.php";
    include_once "leftside.php";
    if($_page == 0){
        include_once "example.php";
    }
    include_once "rightside.php";
    include_once "bottom.php";
?>