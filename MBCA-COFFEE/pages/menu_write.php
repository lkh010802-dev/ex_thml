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
<title>메뉴 등록</title>
</head>
<body>

<?php include __DIR__ . '/../includes/admin_nav.php'; ?>

<main class="write-page">

    <section class="write-wrap">

        <p>
            <a href="/coffee/pages/admin_menus.php" class="back-link">
                ← 메뉴 관리로 돌아가기
            </a>
        </p>

        <h1>메뉴 등록</h1>

        <?php if ($uploadError): ?>
            <p class="form-message error">
                <?= e($uploadError) ?>
            </p>
        <?php endif; ?>

        <form
            method="post"
            action="/coffee/actions/menu_create.php"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <div class="form-row">
                <label>메뉴명</label>
                <input
                    type="text"
                    name="name"
                    placeholder="메뉴명을 입력하세요."
                    required
                >
            </div>

            <div class="form-row">
                <label>카테고리</label>
                <select name="category">
                    <option value="coffee">커피</option>
                    <option value="drink">음료</option>
                    <option value="food">푸드</option>
                    <option value="goods">상품</option>
                </select>
            </div>

            <div class="form-row" id="temp-wrap">
                <label>온도 타입</label>
                <select name="temperature_type">
                    <option value="">선택 안함</option>
                    <option value="ice">ICE</option>
                    <option value="hot">HOT</option>
                </select>
            </div>

            <div class="form-row">
                <label>가격</label>
                <input
                    type="number"
                    name="price"
                    placeholder="가격을 입력하세요."
                    required
                >
            </div>

            <div class="form-row">
                <label>설명</label>
                <textarea
                    name="description"
                    rows="6"
                    placeholder="메뉴 설명을 입력하세요."
                ></textarea>
            </div>

            <div class="form-row">
                <label>영양정보</label>
                <input
                    type="text"
                    name="nutrition"
                    placeholder="칼로리, 카페인 등 영양정보를 입력하세요."
                >
            </div>

            <div class="checkbox-group">
                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_best"
                        value="1"
                    >
                    베스트 메뉴
                </label>

                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_season"
                        value="1"
                    >
                    시즌 메뉴
                </label>
            </div>

            <div class="form-row">
                <label>이미지</label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                >
            </div>

            <img
                id="preview"
                src=""
                class="upload-preview upload-preview-bordered"
                alt="메뉴 이미지 미리보기"
            >

            <div class="form-buttons">
                <a
                    href="/coffee/pages/admin_menus.php"
                    class="cancel-btn"
                >
                    취소
                </a>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    메뉴 등록 →
                </button>
            </div>

        </form>

    </section>

</main>

<script src="/coffee/assets/js/image-preview.js"></script>

</body>
</html>
