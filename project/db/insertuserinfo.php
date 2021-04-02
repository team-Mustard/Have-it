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
                    $sql = "insert into userinfo(email,pw) values('$email','$password')";
                    mysqli_query($conn,$sql);
                    mysqli_close($conn);
                    echo("
                    <script>
                        alert('가입이 완료되었습니다!');
                        location.href='./login.php';
                    </script>"
                    );
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
