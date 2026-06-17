<?php
$stores = [
  [
    'name' => 'MBCA COFFEE 홍대점',
    'address' => '서울 마포구 와우산로 123',
    'phone' => '02-123-4567',
    'hours' => '08:00 - 22:00'
  ],
  [
    'name' => 'MBCA COFFEE 강남점',
    'address' => '서울 강남구 테헤란로 45',
    'phone' => '02-222-3333',
    'hours' => '07:30 - 23:00'
  ],
  [
    'name' => 'MBCA COFFEE 부산서면점',
    'address' => '부산 부산진구 중앙대로 77',
    'phone' => '051-123-9876',
    'hours' => '09:00 - 22:00'
  ]
];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STORE | MBCA COFFEE</title>
  <link rel="stylesheet" href="/coffee/assets/css/header.css">
  <link rel="stylesheet" href="/coffee/assets/css/nav.css">
  <link rel="stylesheet" href="/coffee/assets/css/store.css">
</head>
<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main class="store-page">
    <section class="store-hero">
      <p>MBCA STORE</p>
      <h1>매장 찾기</h1>
    </section>

    <section class="store-search">
      <input type="search" placeholder="지역명 또는 매장명을 입력하세요">
      <button type="button">검색</button>
    </section>

    <section class="store-layout">
      <div class="store-map">
        <p>카카오 지도 API 영역</p>
      </div>

      <div class="store-list">
        <?php foreach ($stores as $store): ?>
          <article class="store-card">
            <h2><?= $store['name'] ?></h2>
            <p><?= $store['address'] ?></p>
            <span><?= $store['phone'] ?></span>
            <small><?= $store['hours'] ?></small>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <script src="/coffee/assets/js/nav.js"></script>
</body>
</html>