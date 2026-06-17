<?php
$isAdmin = true;

$events = [
  [
    'id' => 1,
    'title' => '여름 시즌 할인 이벤트',
    'description' => '시즌 메뉴와 함께 전 메뉴 최대 20% 할인 혜택을 제공합니다.',
    'image' => '/coffee/assets/images/cat.png',
    'start_date' => '2026-06-01',
    'end_date' => '2026-08-31',
    'status' => 'active'
  ],
  [
    'id' => 2,
    'title' => '신규 회원 웰컴 쿠폰',
    'description' => 'MBCA COFFEE 회원가입 시 아메리카노 할인 쿠폰을 드립니다.',
    'image' => '/coffee/assets/images/cat.png',
    'start_date' => '2026-06-10',
    'end_date' => '2026-12-31',
    'status' => 'active'
  ],
  [
    'id' => 3,
    'title' => '봄 이벤트',
    'description' => '봄 시즌 메뉴 구매 고객 대상 스탬프 적립 이벤트입니다.',
    'image' => '/coffee/assets/images/cat.png',
    'start_date' => '2026-03-01',
    'end_date' => '2026-04-30',
    'status' => 'ended'
  ]
];

function e($value) {
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>이벤트 | MBCA COFFEE</title>
  <link rel="stylesheet" href="/coffee/assets/css/header.css">
  <link rel="stylesheet" href="/coffee/assets/css/nav.css">
  <link rel="stylesheet" href="/coffee/assets/css/event.css">
</head>
<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main class="event-page">
    <section class="event-hero">
      <p>MBCA EVENT</p>
      <h1>이벤트</h1>
      <span>MBCA COFFEE의 다양한 이벤트와 혜택을 확인해보세요.</span>
    </section>

    <section class="event-search">
      <input id="eventSearchInput" type="search" placeholder="검색어 입력">
      <button id="eventSearchButton" type="button">검색</button>
    </section>

    <section class="event-grid" id="eventGrid">
      <?php foreach ($events as $event): ?>
        <?php $isEnded = $event['status'] === 'ended'; ?>
        <article
          class="event-card <?= $isEnded ? 'is-ended' : '' ?>"
          data-title="<?= e($event['title']) ?>"
          data-description="<?= e($event['description']) ?>"
        >
          <?php if ($isAdmin && !$isEnded): ?>
            <button class="admin-end-button" type="button">종료</button>
          <?php endif; ?>

          <a href="#" aria-label="<?= e($event['title']) ?> 상세 보기">
            <div class="event-image">
              <img src="<?= e($event['image']) ?>" alt="<?= e($event['title']) ?>">
              <?php if ($isEnded): ?>
                <div class="ended-overlay">
                  <strong>이벤트 종료</strong>
                </div>
              <?php endif; ?>
            </div>

            <div class="event-info">
              <span class="event-status <?= $isEnded ? 'ended' : 'active' ?>">
                <?= $isEnded ? '종료' : '진행중' ?>
              </span>
              <h2><?= e($event['title']) ?></h2>
              <p><?= e($event['description']) ?></p>
              <small><?= e($event['start_date']) ?> - <?= e($event['end_date']) ?></small>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
    </section>

    <p class="event-empty" id="eventEmpty">검색 결과가 없습니다.</p>
  </main>

  <script src="/coffee/assets/js/nav.js"></script>
  <script src="/coffee/assets/js/event.js"></script>
</body>
</html>