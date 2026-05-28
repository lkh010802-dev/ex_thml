<?php
    header('Content-Type:text/html; charset=utf-8');

    // 1. DB 접속
    $db = mysqli_connect(
        'localhost',
        'lkh2026',
        'q1w2e3r4!',
        'lkh2026'
    );

    // 2. 한글 설정
    mysqli_query($db, 'set names utf8');

    // 3. 데이터 읽기
    $sql = 'SELECT * FROM bord';

    $result_table = mysqli_query($db, $sql);

    if($result_table){

        $row_num = mysqli_num_rows($result_table);

        for($i=0; $i<$row_num; $i++){

            $row = mysqli_fetch_array(
                $result_table,
                MYSQLI_ASSOC
            );

            $no = $row['no'];
            $name = $row['name'];
            $title = $row['title'];
            $message = $row['message'];
            $file_path = $row['file_path'];
            $date = $row['date'];

            $message= nl2br($message);

            echo "<h4>$no $name</h4>";
            echo "<h5>$title</h5>";
            echo "<p>$message</p>";
            echo "<p>$date</p>";

            if($file_path){
                echo "<img src='$file_path'
                           alt='첨부 이미지'
                           width='200'>";
            }

            echo "<hr>";
        }

    }else{

        echo "게시글 리스트를 불러오는 중 오류 발생";

    }

    // 4. 종료
    mysqli_close($db);
?>