<?php

require_once __DIR__ . '/../includes/auth.php';
require_login();
include __DIR__ . '/../config/database.php';

$userid = $_SESSION['userid'];

$stmt = mysqli_prepare($db, 'SELECT * FROM users WHERE userid = ?');
mysqli_stmt_bind_param($stmt, 's', $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

$stmt = mysqli_prepare(
    $db,
    "SELECT
        id,
        title,
        status,
        created_at
     FROM qna
     WHERE userid = ?
     ORDER BY id DESC
     LIMIT 3"
);
$countStmt = mysqli_prepare(
    $db,
    "
    SELECT COUNT(*) AS total
    FROM qna
    WHERE userid = ?
    "
);

mysqli_stmt_bind_param(
    $countStmt,
    's',
    $userid
);

mysqli_stmt_execute($countStmt);

$countResult =
    mysqli_stmt_get_result(
        $countStmt
    );

$qnaCount =
    mysqli_fetch_assoc(
        $countResult
    )['total'];
mysqli_stmt_bind_param($stmt, 's', $userid);
mysqli_stmt_execute($stmt);
$qnaResult = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>MY PAGE | MBCA COFFEE</title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/mypage.css">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="mypage">

<section class="mypage-grid">
  <article class="mypage-box profile-box">

    <h2>내 정보</h2>

    <div class="profile-image-wrap">

        <img
            src="<?= $user['profile_image']
                ? $user['profile_image']
                : '/coffee/assets/images/default-profile.png' ?>"
            class="profile-image"
        >

        <a
            href="/coffee/pages/profile_upload.php"
            class="profile-camera"
        >
            변경
        </a>

    </div>

    <h3 class="profile-name">
        <?= e($user['name']) ?>
    </h3>

    <div class="member-badge">
        <?= $user['role'] === 'admin'
            ? 'MBCA ADMIN'
            : 'MBCA MEMBER' ?>
    </div>

    <div class="profile-info">

        <strong>이메일</strong>

        <span>
            <?= e($user['email']) ?>
        </span>

    </div>

    <div class="mypage-actions">

        <a href="/coffee/pages/mypage_edit.php">
            정보 수정
        </a>

        <a href="/coffee/pages/mypage_password.php">
            비밀번호 변경
        </a>

        <?php if($user['role'] === 'admin'): ?>

            <a
                href="/coffee/pages/admin.php"
                class="admin-link"
            >
                관리자 대시보드
            </a>

        <?php endif; ?>

    </div>

</article>
<article class="mypage-box qna-box">

    <div class="qna-head">

        <h2>내 문의내역</h2>

        <a href="/coffee/pages/news.php?type=qna">
            전체보기 →
        </a>

    </div>

    <div class="qna-summary">

        <strong>
            <?= $qnaCount ?>
        </strong>

        <span>
            총 문의수
        </span>

    </div>

    <?php if(mysqli_num_rows($qnaResult) > 0): ?>

        <?php while($qna = mysqli_fetch_assoc($qnaResult)): ?>

            <div class="qna-item">

                <strong>
                    <a href="/coffee/pages/news_view.php?id=<?= $qna['id'] ?>&type=qna">
                        <?= e($qna['title']) ?>
                    </a>
                </strong>

                <span>
                    <?= $qna['status'] === 'answered'
                        ? '답변완료'
                        : '답변대기' ?>
                </span>

                <small>
                    <?= date('Y-m-d', strtotime($qna['created_at'])) ?>
                </small>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <p>등록된 문의가 없습니다.</p>

    <?php endif; ?>

</article>
</section>

</main>

<script src="/coffee/assets/js/nav.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
