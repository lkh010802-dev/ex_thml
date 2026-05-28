<?php
    header('Content-Type:text/html; charset=utf-8');
    //글씨 데이터 받기
    $name = $_POST['name'];
    $title = $_POST['title'];
    $message = $_POST['msg'];

    //파일 데이터(파일정보)받기
    $file= $_FILES['img1'];

    //받은 파일정보(5개) 중애서 필요한 정보만 추출하기
    $file_name= $file['name']; //원본 파일 영역
    $temp_name=$file['tmp_name']; //실제 파일이 있는 임시저장소 경로

    // 임시저장소에 있는 실제 파일을 영구적으로 서버에 저장하기 위해 이동한다.
    $dst_name = "./uploaded/" . date('YmdHis') . $file_name;
    $result = move_uploaded_file($temp_name,$dst_name);

    if($result){
        echo"파일 업로드 성공";
    }else{
        echo"파일 업로드 실패";
    }

    //글씨데이터도 잘 받았는지 확인
    echo "$name <br>";
    echo "$title <br>";
    echo "$message <br>";
    echo "$file_name <br>";
    echo "========<br>";

    $now= date('Y-m-d H-i-s');
    //MYSQL 데이터베이스의 bord라는  이름의 테이블 표 에 데이터를 저장한다.
    // 저장할 데이터들: $name, $title, $message, $dst_name(파일경로), $now

    //1.접속
    $db= mysqli_connect('localhost', 'lkh2026', 'q1w2e3r4!', 'lkh2026'); 

    //2.한글깨짐 방지
    mysqli_query($db, "set names utf8");


    //3. 데이터 삽입을 요청하는 쿼리문 작성 및 요청
    $sql = "INSERT INTO bord(name, title, message, file_path, date)
        VALUES('$name','$title','$message','$dst_name','$now')";
    $result = mysqli_query($db,$sql);
     if($result){
        echo"성공";
    }else{
        echo"실패";
    }   

    //4. 연결종료
    mysqli_close($db);
?>