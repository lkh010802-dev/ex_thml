<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
include __DIR__ . '/../config/database.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($db, 'SELECT * FROM notices WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$post = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$post) {
    die('존재하지 않는 공지입니다.');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>공지 수정 | MBCA COFFEE</title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/notice.css">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <h1>공지 수정</h1>

        <form method="post" action="/coffee/actions/notice_update.php">
            <?= csrf_field() ?>

            <input
                type="hidden"
                name="id"
                value="<?= $id ?>"
            >

            <div class="form-row">
                <label>공지 제목</label>

                <input
                    type="text"
                    name="title"
                    value="<?= e($post['title']) ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>공지 내용</label>

                <textarea
                    name="content"
                    rows="10"
                    required
                ><?= e($post['content']) ?></textarea>
            </div>

            <label class="checkbox-row">
                <input
                    type="checkbox"
                    name="is_pinned"
                    value="1"
                    <?= $post['is_pinned'] ? 'checked' : '' ?>
                >
                중요공지로 고정
            </label>

            <div class="form-buttons">
                <a
                    href="/coffee/pages/news_view.php?id=<?= $id ?>&type=notice"
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

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="/coffee/assets/js/nav.js"></script>

</body>
</html>