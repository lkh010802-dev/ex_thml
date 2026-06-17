<?php

session_start();

include __DIR__ . '/../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$type = $_GET['type'] ?? 'notice';

if (!$id) {
    die('잘못된 접근입니다.');
}

if ($type === 'notice') {

    mysqli_query(
        $db,
        "UPDATE notices
         SET views = views + 1
         WHERE id = $id"
    );

    $sql = "SELECT *
            FROM notices
            WHERE id = $id";

} else {

    $sql = "SELECT *
            FROM qna
            WHERE id = $id";
}

$result = mysqli_query($db, $sql);

$post = mysqli_fetch_assoc($result);

if (!$post) {
    die('게시글이 존재하지 않습니다.');
}
if (
    $type === 'qna' &&
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'admin' &&
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $reply = trim($_POST['reply']);

    $adminId = $_SESSION['userid'];

    mysqli_query(
        $db,
        "INSERT INTO qna_reply
        (qna_id, admin_id, content)
        VALUES
        ($id, '$adminId', '$reply')"
    );

    mysqli_query(
        $db,
        "UPDATE qna
         SET status='answered'
         WHERE id=$id"
    );

    header(
        "Location: news_view.php?id=$id&type=qna"
    );
    exit;
}

?>

<!DOCTYPE html>

<html lang="ko">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($post['title']) ?></title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/notice.css">

</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="notice-page">

<section class="board-title-bar">
    <h1>
        <?= $type === 'notice'
            ? '공지사항'
            : 'Q&A' ?>
    </h1>
</section>

<section class="board-wrap">

<div class="view-card">

```
<h2>
    <?= htmlspecialchars($post['title']) ?>
</h2>

<div class="view-meta">

    <?php if($type === 'notice'): ?>

    <span>
        조회수 :
        <?= $post['views'] ?>
    </span>

    <?php endif; ?>

    <span>
        작성일 :
        <?= $post['created_at'] ?>
    </span>

</div>

<hr>

<div class="view-content">

    <?= nl2br(htmlspecialchars($post['content'])) ?>

</div>
```

</div>
<?php if(
    $type === 'qna' &&
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'admin'
): ?>

<hr>

<div class="reply-write-box">

    <h3>관리자 답변 작성</h3>

    <form method="post">

        <textarea
            name="reply"
            rows="6"
            required
        ></textarea>

        <button type="submit">
            답변 등록
        </button>

    </form>

</div>

<?php endif; ?>
<?php if(
    $type === 'notice' &&
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'admin'
): ?>

<a href="/coffee/pages/notice_edit.php?id=<?= $post['id'] ?>">
수정
</a>

<a
href="/coffee/pages/notice_delete.php?id=<?= $post['id'] ?>"
onclick="return confirm('삭제하시겠습니까?')"
>
삭제
</a>

<?php endif; ?>

<?php

if ($type === 'qna') {

    $replySql = "SELECT *
                 FROM qna_reply
                 WHERE qna_id = $id
                 ORDER BY id DESC
                 LIMIT 1";

    $replyResult = mysqli_query($db, $replySql);

    $reply = mysqli_fetch_assoc($replyResult);
      mysqli_query(
        $db,
        "UPDATE qna
         SET views = views + 1
         WHERE id = $id"
    );

    if ($reply):

?>

<hr>

<div class="reply-box">

```
<h3>관리자 답변</h3>

<p>
    <?= nl2br(htmlspecialchars($reply['content'])) ?>
</p>
```

</div>

<?php
    endif;
}
?>

<a href="/coffee/pages/news.php?type=<?= $type ?>">
목록으로
</a>

</section>

</main>

<script src="/coffee/assets/js/nav.js"></script>

</body>
</html>
