<?php
    // 응답할 데이터 형식 지정
    header('Content-Type:text/html; charset=utf-8');

    // GET 방식으로 전달받은 데이터
    $title = $_GET['title'];
    $message = $_GET['msg'];

    // 브라우저에 출력
    echo "<h2>This is php server</h2>";
    echo "<p>한글</p>";

    // 전달받은 데이터 출력
    echo "$title <br>";
    echo "$message";
?>