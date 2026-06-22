<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
$uploadError = pull_flash('upload_error', '');

?>

<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
<meta charset="UTF-8">
<title>이벤트 등록</title>
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

        <h1>이벤트 등록</h1>

        <?php if ($uploadError): ?>
            <p class="form-message error">
                <?= e($uploadError) ?>
            </p>
        <?php endif; ?>

        <form
            method="post"
            action="/coffee/actions/event_create.php"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <div class="form-row">
                <label>뱃지</label>
                <input
                    type="text"
                    name="badge"
                    placeholder="예: 진행중, NEW, 할인"
                    required
                >
            </div>

            <div class="form-row">
                <label>제목</label>
                <input
                    type="text"
                    name="title"
                    placeholder="이벤트 제목을 입력하세요."
                    required
                >
            </div>

            <div class="form-row">
                <label>설명</label>
                <textarea
                    name="description"
                    rows="6"
                    placeholder="이벤트 설명을 입력하세요."
                ></textarea>
            </div>

            <div class="form-grid-2">
                <div class="form-row">
                    <label>시작일</label>
                    <input
                        type="date"
                        name="start_date"
                        required
                    >
                </div>

                <div class="form-row">
                    <label>종료일</label>
                    <input
                        type="date"
                        name="end_date"
                        required
                    >
                </div>
            </div>

            <div class="form-row">
                <label>썸네일 이미지</label>
                <input
                    type="file"
                    name="thumbnail"
                    accept="image/*"
                    required
                >
            </div>

            <div class="form-row">
                <label>상세 이미지</label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    required
                >
            </div>

            <img
                id="preview"
                src=""
                class="upload-preview upload-preview-spaced"
                alt="이벤트 이미지 미리보기"
            >

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
                    이벤트 등록 →
                </button>
            </div>

        </form>

    </section>

</main>

<script src="/coffee/assets/js/image-preview.js"></script>

</body>
</html>
