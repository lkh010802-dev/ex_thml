<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
$uploadError = pull_flash('upload_error', '');

require_once __DIR__ . '/../config/database.php';

$id = (int)$_GET['id'];
$stmt = mysqli_prepare($db, 'SELECT * FROM menus WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$menu = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$menu) {
    die('존재하지 않는 메뉴입니다.');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    
<link rel="stylesheet" href="/coffee/assets/css/admin.css">
<meta charset="UTF-8">
<title>메뉴 수정</title>
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

        <h1>메뉴 수정</h1>

        <?php if ($uploadError): ?>
            <p class="form-message error">
                <?= e($uploadError) ?>
            </p>
        <?php endif; ?>

        <form
            method="post"
            action="/coffee/actions/menu_update.php"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <input
                type="hidden"
                name="id"
                value="<?= $id ?>"
            >

            <div class="form-row">
                <label>메뉴명</label>

                <input
                    type="text"
                    name="name"
                    value="<?= e($menu['name']) ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>카테고리</label>

                <select name="category">
                    <option
                        value="coffee"
                        <?= $menu['category'] == 'coffee' ? 'selected' : '' ?>
                    >
                        커피
                    </option>

                    <option
                        value="drink"
                        <?= $menu['category'] == 'drink' ? 'selected' : '' ?>
                    >
                        음료
                    </option>

                    <option
                        value="food"
                        <?= $menu['category'] == 'food' ? 'selected' : '' ?>
                    >
                        푸드
                    </option>

                    <option
                        value="goods"
                        <?= $menu['category'] == 'goods' ? 'selected' : '' ?>
                    >
                        상품
                    </option>
                </select>
            </div>

            <div class="form-row" id="temp-wrap">
                <label>온도 타입</label>

                <select name="temperature_type">
                    <option
                        value=""
                        <?= empty($menu['temperature_type']) ? 'selected' : '' ?>
                    >
                        선택 안함
                    </option>

                    <option
                        value="ice"
                        <?= $menu['temperature_type'] == 'ice' ? 'selected' : '' ?>
                    >
                        ICE
                    </option>

                    <option
                        value="hot"
                        <?= $menu['temperature_type'] == 'hot' ? 'selected' : '' ?>
                    >
                        HOT
                    </option>
                </select>
            </div>

            <div class="form-row">
                <label>가격</label>

                <input
                    type="number"
                    name="price"
                    value="<?= $menu['price'] ?>"
                    required
                >
            </div>

            <div class="form-row">
                <label>설명</label>

                <textarea
                    name="description"
                    rows="6"
                ><?= e($menu['description']) ?></textarea>
            </div>

            <div class="form-row">
                <label>영양정보</label>

                <input
                    type="text"
                    name="nutrition"
                    value="<?= e($menu['nutrition']) ?>"
                >
            </div>

            <div class="checkbox-group">
                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_best"
                        value="1"
                        <?= $menu['is_best'] ? 'checked' : '' ?>
                    >
                    베스트 메뉴
                </label>

                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_season"
                        value="1"
                        <?= $menu['is_season'] ? 'checked' : '' ?>
                    >
                    시즌 메뉴
                </label>
            </div>

            <div class="form-row">
                <label>현재 이미지</label>

                <img
                    id="preview"
                    src="<?= e(image_url($menu['image'], 'menu')) ?>"
                    class="current-image-thumbnail"
                    alt="현재 메뉴 이미지"
                >
            </div>

            <div class="form-row">
                <label>새 이미지</label>

                <input
                    type="file"
                    name="image"
                    accept="image/*"
                >
            </div>

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
                    수정 완료 →
                </button>
            </div>

        </form>

    </section>

</main>

<script src="/coffee/assets/js/image-preview.js"></script>

</body>
</html>
