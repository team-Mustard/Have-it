<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$email = $_POST['email'];
$password = $_POST['password'];
$time = time();
//$today = '2021-10-01';
$today = date("Y-m-d", $time);
    
include "dbconn.php";
if($email != null){
    if($password != null){

        $sql = "select * from userinfo where email = '$email'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($row != null){
            if($password == $row['pw']){
                
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['userid'] = $row['userID']; 
                
                $userid = $_SESSION['userid'];
                $todayWeek = date('w',strtotime($today));
                $todayDay = date('d',strtotime($today));
                if($todayWeek == 1){
                    $weeklySql = "select date from weeklyreport where userid = '$userid' and date = '$today'";
                    $weeklyResult = mysqli_query($conn,$weeklySql);
                    $weeklyRow = mysqli_fetch_array($weeklyResult,MYSQLI_ASSOC);
                    if($weeklyRow == null){
                        echo("
                            <script>
                                location.href='../adminWeekly.php?mode=1';
                            </script>"
                            );
                   }
                    
                }
                if($todayDay == 1){
                    $monthlySql = "select date from monthlyreport where userid = '$userid' and date = '$today'";
                    $monthlyResult = mysqli_query($conn,$monthlySql);
                    $monthlyRow = mysqli_fetch_array($monthlyResult,MYSQLI_ASSOC);
                    if($monthlyRow == null){
                        echo("
                            <script>
                                location.href='../adminMonthly.php';
                            </script>"
                            );
                   }
                }
                echo("
                    <script>
                        location.href='../index.php';
                    </script>"
                    );
                
            }else{
                echo("
                    <script>
                        alert('비밀번호가 일치하지 않습니다.');
                        history.back();
                    </script>"
                    );}
             
   
               }else {
                   echo("
                    <script>
                        alert('존재하지 않는 이메일입니다.');
                        history.back();
                    </script>"
                    );
               }
               
               }else {
                   echo("
                    <script>
                        alert('비밀번호를 입력하세요.');
                        history.back();
                    </script>"
                    );
               }
               }else {
                   echo("
                    <script>
                        alert('이메일을 입력하세요.');
                        history.back();
                    </script>"
                    );
               }
        
    

?>