<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "dbconn.php";
$email = $_POST['email'];
$password = $_POST['password'];
$passwordCheck = $_POST['password_check'];

if($email !=null){
    if($password != null){
        if($passwordCheck!=null){
            if($password==$passwordCheck){
                
                    $checkSql = "select * from userinfo where email = '$email'";
                    $result = mysqli_query($conn,$checkSql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if(isset($row['email'])){
                            echo("
                            <script>
                                alert('이미 존재하는 이메일입니다.');
                                history.back();
                            </script>"
                    );    
                                 
                    }else{
                   
                    if(strlen($password) >=8 && strlen($password) <=18){
                        
                    $sql = "insert into userinfo(email,pw) values('$email','$password')";
                    if(mysqli_query($conn,$sql)){
                            echo("
                                <script>
                                    alert('가입이 완료되었습니다!');
                                    location.href='../login.php';
                                </script>"
                            );
                        }
                    mysqli_close($conn);
                    }else{
                        echo("
                                <script>
                                    alert('비밀번호의 길이는 8자 이상 18자 이하만 가능합니다.');
                                    history.back();
                                </script>"
                            );
                        
                        
                    }
                }
                }else {
                echo("
                   <script>
                        alert('비밀번호가 일치하지 않습니다.');
                        history.back();
                    </script>"
                    );
                    }
    }else {
        echo("
               <script>
                    alert('비밀번호 확인란을 입력하세요.');
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
    }
else{
    echo("
               <script>
                    alert('이메일을 입력하세요.');
                    history.back();
                </script>"
                    );



     }
?>
