<?php
error_reporting(E_ALL);
session_start();
include "dbconn.php";

if(isset($_SESSION['userid'])) $userid = $_SESSION['userid']; else echo"dld";
$password = $_POST['password'];

$sql = "select * from userinfo where userID = $userid;";
if($res = mysqli_query($conn,$sql)){
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if($row['pw'] == $password) {
        $sql = "delete from userinfo where userID = $userid;";
        if(mysqli_query($conn,$sql)) {
            echo "<script>alert('계정이 삭제되었습니다.');</script>";
            session_destroy();
        }
        else {
            echo"<script>alert('알 수 없는 오류로 계정 삭제에 실패하였습니다.');history.back();";
        }
    }
    else {
        echo "<script>alert('계정 비밀번호가 일치하지 않습니다.'); history.back();</script>";
    }
}
mysqli_close($conn);

?>
<meta http-equiv="refresh" content="0;url=/index.php" />