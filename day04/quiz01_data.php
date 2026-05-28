<?php
    header('Content-Type:text/html; charset=utf-8');

    // 사용자가 보낸 데이터 받기
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];

    // 현재 시간
    $now = date('Y-m-d H:i:s');

    // DB 연결
    $data_base = mysqli_connect(
        'localhost',
        'lkh2026',
        'q1w2e3r4!',
        'lkh2026'
    );

    // 한글 설정
    mysqli_query($data_base, 'set names utf8');

    // INSERT SQL
    $sql = "INSERT INTO quiz01_ba(name, phone, email, date)
            VALUES('$name', '$phone', '$email', '$now')";

    // 실행
    $result = mysqli_query($data_base, $sql);

    // 결과 확인
    if($result){
        echo "예약 저장 성공";
    }else{
        echo "예약 저장 실패 <br>";
        echo mysqli_error($data_base);
    }

    echo "<hr>";

    echo "이름 : $name <br>";
    echo "전화번호 : $phone <br>";
    echo "이메일 : $email <br>";
    echo "예약시간: $now <br>";

    // 연결 종료
    mysqli_close($data_base);
?>