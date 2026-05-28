<?php
    header('Content-Type:text/html; charset=utf-8');
    //사용자가 POST방식으로 보낸 글씨 데이터는 $_POST라는 특병한 배역변수에 저장한다.
    //사용자가 File을 보내면 실제 파일데이터들(픽셀정보들 bytes)은 임시저장소(tmp)에 임시로 저장되며 
    // 이 php파일에는 file의 정보를 가진 $_Files[]라는 배열이 전달된다/(일종의 택배송장 같은 개념)
    $file= $_FILES['img1'];

    // 파일정보들 확인.($file은 5칸짜리 배열)
    $file_name= $file['name']; //원본 파일명
    $file_size= $file['size']; //파일 사이즈
    $file_type= $file['type']; //파일타입(image/jpg, audio/mp3, MIME type)
    $error_info= $file['error']; //에러 정보
    $temp_name= $file['tmp_name']; //실제 파일데이터가 있는 임시저장소의 경로(위치)

    //일반적으로는 이파일정보들이 온전히 있다면 파일전송이 잘 된 것이다.

    //확인해보기
    echo "파일명: {$file_name} <br>";
    echo "파일 사이즈: {$file_size} <br>";
    echo "파일 타입: {$file_type} <br>";
    echo "에러정보: {$error_info} <br>";
    echo "임시저장소 위치: {$temp_name} <br>";
    // $temp_name위체에 있는 파일의 실제 데이터는 임시공간이기제
    //이 코드가 종료되면 휘발
    //그래서 반드시 서버에서 할당된 내 저장소 html폴더 내부 안에서 이동해야한다.
    //이동시킬 곳의 파일명이 중복되면 안되기에 보통은 날짜정보를 파일명으로 사용한다.
     //php에서는 문자열의 결합연산자가 .이다

    $dst_name = "./uploaded/" . date("YmdHis") . $file_name;

    $result= move_uploaded_file($temp_name, $dst_name);

    if($result){
        echo"성공";
    }else{
        echo"실패";
    }
?>