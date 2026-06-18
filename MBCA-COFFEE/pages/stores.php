<?php

require_once __DIR__ . '/../config/database.php';

$result = mysqli_query(
    $db,
    "
    SELECT *
    FROM stores
    ORDER BY id DESC
    "
);

$stores = [];

while($row = mysqli_fetch_assoc($result)){
    $stores[] = $row;
}

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
  <script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=189902bbe93b113649d2eeeb9e4b90e9"></script>
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
       <div id="map"></div>
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
  <script>

const container =
    document.getElementById('map');

const options = {
    center: new kakao.maps.LatLng(
        37.5665,
        126.9780
    ),
    level: 5
};

const map =
    new kakao.maps.Map(
        container,
        options
    );

</script>
</body>
</html>