<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$email = $_POST['email'];
$password = $_POST['password'];

include "dbconn.php";
if($email != null){
    if($password != null){

        $sql = "select * from userinfo where email = '$email'";
        $result = mysqli_query($conn,$sql);
        if($result!=null){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($password == $row['pw']){
                
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['userid'] = $row['userID']; 
                
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
             
   
               }
               else {
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