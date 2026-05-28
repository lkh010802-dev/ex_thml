<?php
    header("Content-Type:text/html; charset=utf-8");
    //사용자가 get방식으로 보낸 데이터를 받기
    $name = $_GET['name'];
    $message = $_GET['msg'];

    // $name과 $message 변수에 있는 데이터를 Database에 저장하기
    // Database는 엑셀같은 구조를 가진 프로그램
    // 그래서 데이터를 저장하려면 구조를 가진 표table을 만들어야 한다.
    // 닷홈 호스팅을 사용하면 이미 datavase가 설치되어 있으며
    // 미리 표를 만들어 놓고 데이터만 삽입하는 것이 가능하다.
    // 데이터를 삽입하는 작업은 sql이라는 데이터베이스 전용 언어를 쓴다.

    // MYSQL DBMS에 접속하여 memo테이블에 이름, 메세지 데이터를 삽입하기
    //1. MYSQL에 접속하기
    $db = mysqli_connect('localhost','lkh2026','q1w2e3r4!','lkh2026'); //DB서버URL, DB접속 아이디, DB접속 비번, DB명

    //2. DB안에서 한글이 깨지지 않도록 요청.
    mysqli_query($db,'set names utf8');

    //3. 원하는 CRUD작업을 요청하는 질의문 만들고 요청.
    $sql="INSERT INTO memo(name,message) VALUES('$name','$message')";
    $result = mysqli_query($db,$sql);

    if($result){
        echo "메모 저장 성공";
    }else{
        echo "실패";
    }


    //4. 연결종료
    mysqli_close($db);
?>