<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
$uploadError = pull_flash('upload_error', '');

require_once __DIR__ . '/../config/database.php';

$id = (int)$_GET['id'];

$stmt = mysqli_prepare($db, 'SELECT * FROM events WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$event) {
    die('존재하지 않는 이벤트입니다.');
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
<meta charset="UTF-8">
<title>이벤트 수정</title>
</head>
<body>

<?php include __DIR__ . '/../includes/admin_nav.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <p>
            <a href="/coffee/pages/admin_events.php" class="back-link">
                ← 이벤트 관리로 돌아가기
            </a>
        </p>

        <h1>이벤트 수정</h1>

        <?php if ($uploadError): ?>
            <p class="form-message error">
                <?= e($uploadError) ?>
            </p>
        <?php endif; ?>

        <form
            method="post"
            action="/coffee/actions/event_update.php"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <input
                type="hidden"
                name="id"
                value="<?= $id ?>"
            >

            <div class="form-row">
                <label>뱃지</label>
                <input
                    type="text"
                    name="badge"
                    value="<?= e($event['badge']) ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>제목</label>
                <input
                    type="text"
                    name="title"
                    value="<?= e($event['title']) ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>설명</label>
                <textarea
                    name="description"
                    rows="6"
                ><?= e($event['description']) ?></textarea>
            </div>

            <div class="form-grid-2">
                <div class="form-row">
                    <label>시작일</label>
                    <input
                        type="date"
                        name="start_date"
                        value="<?= $event['start_date'] ?>"
                        required
                    >
                </div>

                <div class="form-row">
                    <label>종료일</label>
                    <input
                        type="date"
                        name="end_date"
                        value="<?= $event['end_date'] ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-grid-2">

                <div class="form-row">
                    <label>현재 썸네일</label>
                    <img
                        src="<?= e(image_url($event['thumbnail'], 'event')) ?>"
                        class="current-image current-image-thumbnail"
                        alt="현재 이벤트 썸네일"
                    >
                </div>

                <div class="form-row">
                    <label>현재 상세 이미지</label>
                    <img
                        id="preview"
                        src="<?= e(image_url($event['image'], 'event')) ?>"
                        class="current-image current-image-detail"
                        alt="현재 이벤트 상세 이미지"
                    >
                </div>

            </div>

            <div class="form-row">
                <label>새 썸네일</label>
                <input
                    type="file"
                    name="thumbnail"
                    accept="image/*"
                >
            </div>

            <div class="form-row">
                <label>새 상세 이미지</label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                >
            </div>

            <div class="form-buttons">
                <a
                    href="/coffee/pages/admin_events.php"
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

<script src="/coffee/assets/js/image-preview.js"></script>

</body>
</html>
