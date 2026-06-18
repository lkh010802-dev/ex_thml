<?php

/*
=========================================
MBCA COFFEE NOTICE WRITE PAGE

기능
- 관리자 공지 작성

=========================================
*/

session_start();

include __DIR__ . '/../config/database.php';

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    die('관리자만 접근 가능합니다.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $isPinned =
    isset($_POST['is_pinned'])
    ? 1
    : 0;

    $writer = $_SESSION['userid'];

    $sql = "INSERT INTO notices
            (title, content, writer)
            VALUES
            ('$title', '$content', '$writer')";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        die(mysqli_error($db));
    }

    header(
        'Location: /coffee/pages/news.php?type=notice'
    );
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="ko">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>공지 작성</title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/forms.css">

</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="auth-page">

<section class="auth-card">

<h1>공지사항 작성</h1>

<form method="post">

    <label>공지 제목</label>

    <input
        type="text"
        name="title"
        required
    >

    <label>공지 내용</label>

    <textarea
        name="content"
        rows="10"
        required
    ></textarea>
    <label>

    <input
        type="checkbox"
        name="is_pinned"
        value="1"
    >

    중요공지로 고정

    </label>

    <button type="submit">
        공지 등록
    </button>

</form>

</section>

</main>

</body>
</html>
