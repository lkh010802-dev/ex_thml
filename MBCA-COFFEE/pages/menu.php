<?php
$category = $_GET['category'] ?? 'drink';

$menus = [
  [
    'category' => 'drink',
    'name' => '아이스 아메리카노',
    'price' => '1,500원',
    'desc' => '깔끔하고 시원한 MBCA 기본 커피',
    'nutrition' => '카페인 120mg / 칼로리 10kcal',
    'image' => '/coffee/assets/images/cat.png'
  ],
  [
    'category' => 'drink',
    'name' => '망고 코코 스무디',
    'price' => '3,900원',
    'desc' => '망고의 달콤함과 코코넛의 부드러움',
    'nutrition' => '칼로리 320kcal',
    'image' => '/coffee/assets/images/cat.png'
  ],
  [
    'category' => 'food',
    'name' => '초코 머핀',
    'price' => '2,800원',
    'desc' => '진한 초코 풍미의 부드러운 머핀',
    'nutrition' => '밀, 우유, 계란 포함',
    'image' => '/coffee/assets/images/cat.png'
  ],
  [
    'category' => 'goods',
    'name' => 'MBCA 텀블러',
    'price' => '9,900원',
    'desc' => 'MBCA 로고가 들어간 데일리 텀블러',
    'nutrition' => '상품 정보',
    'image' => '/coffee/assets/images/cat.png'
  ]
];

$categoryNames = [
  'drink' => '음료',
  'food' => '푸드',
  'goods' => '상품'
];

$filteredMenus = array_filter($menus, fn($menu) => $menu['category'] === $category);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MENU | MBCA COFFEE</title>
  <link rel="stylesheet" href="/coffee/assets/css/header.css">
  <link rel="stylesheet" href="/coffee/assets/css/nav.css">
  <link rel="stylesheet" href="/coffee/assets/css/menu.css">
  <link rel="stylesheet" href="/coffee/assets/css/modal.css">
</head>
<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main class="menu-page">
    <section class="menu-hero">
      <p>MBCA MENU</p>
      <h1><?= $categoryNames[$category] ?></h1>
    </section>

    <nav class="menu-tabs" aria-label="Menu category">
      <a class="<?= $category === 'drink' ? 'is-active' : '' ?>" href="/coffee/pages/menu.php?category=drink">음료</a>
      <a class="<?= $category === 'food' ? 'is-active' : '' ?>" href="/coffee/pages/menu.php?category=food">푸드</a>
      <a class="<?= $category === 'goods' ? 'is-active' : '' ?>" href="/coffee/pages/menu.php?category=goods">상품</a>
    </nav>

    <section class="menu-grid">
      <?php foreach ($filteredMenus as $menu): ?>
        <article
          class="menu-item"
          data-name="<?= $menu['name'] ?>"
          data-price="<?= $menu['price'] ?>"
          data-desc="<?= $menu['desc'] ?>"
          data-nutrition="<?= $menu['nutrition'] ?>"
          data-image="<?= $menu['image'] ?>"
        >
          <img src="<?= $menu['image'] ?>" alt="<?= $menu['name'] ?>">
          <h2><?= $menu['name'] ?></h2>
          <p><?= $menu['price'] ?></p>
        </article>
      <?php endforeach; ?>
    </section>
  </main>

  <div class="menu-modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" type="button">닫기</button>
      <img class="modal-image" src="" alt="">
      <h2 class="modal-name"></h2>
      <p class="modal-price"></p>
      <p class="modal-desc"></p>
      <small class="modal-nutrition"></small>
    </div>
  </div>

  <script src="/coffee/assets/js/nav.js"></script>
  <script src="/coffee/assets/js/menu-modal.js"></script>
</body>
</html>