<?php

require_once __DIR__ . '/../includes/auth.php';
require_login();
include __DIR__ . '/../config/database.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($db, 'SELECT * FROM qna WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$qna = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if(!$qna){
    die('문의가 존재하지 않습니다.');
}

if(
    $_SESSION['userid'] !== $qna['userid']
){
    die('수정 권한이 없습니다.');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
<meta charset="UTF-8">
<title>문의 수정</title>
<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/notice.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <h1>문의 수정</h1>

        <form method="post">

            <div class="form-row">
                <label>문의 제목</label>
                <input
                    type="text"
                    name="title"
                    value="<?= e($qna['title']) ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>문의 내용</label>
                <textarea
                    name="content"
                    rows="10"
                    required
                ><?= e($qna['content']) ?></textarea>
            </div>

            <div class="form-buttons">
                <a
                    href="/coffee/pages/news_view.php?id=<?= $qna['id'] ?>&type=qna"
                    class="cancel-btn"
                >
                    취소
                </a>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    수정 완료 →
                </button>
            </div>

        </form>

    </section>

</main>

</body>
</html>
