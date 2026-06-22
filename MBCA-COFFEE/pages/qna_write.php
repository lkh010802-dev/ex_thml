<?php

require_once __DIR__ . '/../includes/auth.php';
require_login();


?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A 작성 | MBCA COFFEE</title>

    <link rel="stylesheet" href="/coffee/assets/css/header.css">
    <link rel="stylesheet" href="/coffee/assets/css/nav.css">
    <link rel="stylesheet" href="/coffee/assets/css/notice.css">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <h1>문의 등록</h1>

        <form
            method="post"
            action="/coffee/actions/qna_create.php"
        >

            <?= csrf_field() ?>

            <div class="form-row">

                <label>문의 제목</label>

                <input
                    type="text"
                    name="title"
                    placeholder="문의 제목을 입력하세요."
                    required
                >

            </div>

            <div class="form-row">

                <label>문의 내용</label>

                <textarea
                    name="content"
                    rows="10"
                    placeholder="문의 내용을 입력하세요."
                    required
                ></textarea>

            </div>

            <div class="form-buttons">

                <a
                    href="/coffee/pages/news.php?type=qna"
                    class="cancel-btn"
                >
                    취소
                </a>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    문의 등록 →
                </button>

            </div>

        </form>

    </section>

</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="/coffee/assets/js/nav.js"></script>

</body>
</html>
