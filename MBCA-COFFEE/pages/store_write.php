<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();



?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">

<title>매장 등록</title>

<link
    rel="stylesheet"
    href="/coffee/assets/css/admin.css"
>
<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/notice.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <h1>매장 등록</h1>

        <form
            method="post"
            action="/coffee/actions/store_create.php"
        >
            <?= csrf_field() ?>

            <div class="form-row">
                <label>매장명</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-row">
                <label>주소</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-row">
                <label>전화번호</label>
                <input type="text" name="phone">
            </div>

            <div class="form-row">
                <label>영업시간</label>
                <input
                    type="text"
                    name="hours"
                    value="08:00 - 22:00"
                >
            </div>

            <div class="form-row">
                <label>위도</label>
                <input type="text" name="lat" required>
            </div>

            <div class="form-row">
                <label>경도</label>
                <input type="text" name="lng" required>
            </div>

            <div class="form-buttons">

                <a
                    href="/coffee/pages/admin_stores.php"
                    class="cancel-btn"
                >
                    취소
                </a>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    매장 등록 →
                </button>

            </div>

        </form>

    </section>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
