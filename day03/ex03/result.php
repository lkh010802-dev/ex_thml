<?php

// 사용자가 입력한 데이터 받기
$user_name = $_POST['user_name'];
$payment = $_POST['payment'];
$count = $_POST['count'];
$request = $_POST['request'];

// checkbox는 여러 개 선택 가능해서 배열로 받음
$coffee = $_POST['coffee'];
$option = $_POST['option'];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>주문 결과</title>
    </head>

    <body>

        <h1>☕ 주문이 완료되었습니다!</h1>

        <hr>

        <h3>주문자 정보</h3>

        <?php
            echo "이름 : " . $user_name;
        ?>

        <br><br>

        <?php
            echo "결제 방법 : " . $payment;
        ?>

        <br><br>

        <?php
            echo "주문 수량 : " . $count;
        ?>

        <br><br>

        <h3>선택한 메뉴</h3>

        <?php

        foreach($coffee as $menu)
        {
            echo $menu . "<br>";
        }

        ?>

        <br>

        <h3>추가 옵션</h3>

        <?php

        foreach($option as $op)
        {
            echo $op . "<br>";
        }

        ?>

        <br>

        <h3>요청 사항</h3>

        <?php
            echo $request;
        ?>

    </body>
</html>