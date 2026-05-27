<?php
    //응답하는 데이터늬 형식을 지정. 한글깨짐 방지
    header("Content-Type:text/html; charset=utf-8");

    //사용자가 post방식으로 보냔 데이터는 $_POST라는 특별한 배열변수에 저장되어 있다.
    // 이배열변수에서 원하는 값들을 추출한다.

    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $gender = $_POST['gender'];
    $message = $_POST['message'];
    $brand = $_POST['brand'];

    // textarea에서의 줄바꿈은 \n(new ilne)이다.
    //웹 브라우저는 줄바꿈을 <br>태그를 사용해야 한다.
    // 그래서 $message안에 있는\n 을 br태그로 변환해야 하는데
    // php에서는 이 작업을 해주는 기능 function함수가 존재

    $message= nl2br($message);

    //실무에서 이 데이터들을 Datavase에 저장하는 등의 코드를 작성한다.
    //이 예제에서는 간단하게 데이터를 잘 받았는지 확인하는 정도로
    // 받은 데이터들을 사용자에게 그대로 응답response해주기(브라우저에 보여주기)
    echo "<p>아이디: $user_id</p>";
    echo "<p>비밀번호: $user_pw</p>";
    echo "<p>성별: $gender</p>";
    echo "<p>자동차 브랜드: $brand</p>";
    echo "<p>메세지: <br>$message</p>";

    // checkbox는 다중 선택으로 여러개의 값을 동시에 보내기에 배열로 받아진다.
    $fruits = $_POST['fruits'];
    // $fruits는 뱅ㄹ변수이다. 파이썬의 리스트와 같은 구조, 인덱스 번호
    //배연의 요소 개수를 얻어오기
    $num = count($fruits);
    for($i=0; $i<$num; $i++){
    echo "$fruits[$i] ";
    }


?>