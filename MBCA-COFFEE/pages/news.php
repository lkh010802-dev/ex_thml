<!-- 
MBCA COFFEE COMMUNITY PAGE
기능
- 공지사항 목록
- Q&A 목록
- 게시글 상세페이지 이동
-->

<?php


session_start();

$boardType = $_GET['type'] ?? 'notice';

include __DIR__ . '/../config/database.php';

function e($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}
$boardType = $_GET['type'] ?? 'notice';

if ($boardType === 'notice') {

    $result = mysqli_query(
        $db,
        "SELECT
            id,
            title,
            views,
            created_at
         FROM notices
         ORDER BY id DESC"
    );

    $rows = [];

while ($row = mysqli_fetch_assoc($result)) {

    $row['type'] = 'notice';

    $row['date'] = substr(
        $row['created_at'],
        0,
        10
    );

    $rows[] = $row;
}
}

elseif ($boardType === 'qna') {

$result = mysqli_query(
    $db,
    "SELECT
        id,
        userid,
        title,
        status,
        views,
        created_at
     FROM qna
     ORDER BY id DESC"
);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $row['type'] = 'qna';
        $row['date'] = substr(
            $row['created_at'],
            0,
            10
        );
        $row['masked_userid'] =
    substr($row['userid'], 0, 3)
    . str_repeat(
        '*',
        max(strlen($row['userid']) - 3, 0)
    );

        $rows[] = $row;
    }
}

else {

    $rows = [];

    $noticeResult = mysqli_query(
        $db,
        "SELECT
            id,
            title,
            views,
            created_at
         FROM notices"
    );

    while ($row = mysqli_fetch_assoc($noticeResult)) {

        $row['type'] = 'notice';
        $row['date'] = substr(
            $row['created_at'],
            0,
            10
        );

        $rows[] = $row;
    }

    $qnaResult = mysqli_query(
        $db,
        "SELECT
            id,
            title,
            status,
            created_at
         FROM qna"
    );

    while ($row = mysqli_fetch_assoc($qnaResult)) {

        $row['type'] = 'qna';
        $row['views'] = '-';
        $row['date'] = substr(
            $row['created_at'],
            0,
            10
        );

        $rows[] = $row;
    }

    usort(
        $rows,
        fn($a, $b) => $b['id'] <=> $a['id']
    );
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>공지사항 | MBCA COFFEE</title>
  <link rel="stylesheet" href="/coffee/assets/css/header.css">
  <link rel="stylesheet" href="/coffee/assets/css/nav.css">
  <link rel="stylesheet" href="/coffee/assets/css/notice.css">
</head>
<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main class="news-page">
    <section class="board-title-bar">
      <h1><?= $boardType === 'qna' ? 'Q&A' : '공지사항' ?></h1>
      <button type="button" aria-label="open board menu">⌄</button>
    </section>

    <section class="board-wrap">
    <nav class="board-tabs" aria-label="board category">
        <a class="<?= $boardType === 'notice' ? 'is-active' : '' ?>" href="/coffee/pages/news.php?type=notice">공지사항</a>
        <a class="<?= $boardType === 'qna' ? 'is-active' : '' ?>" href="/coffee/pages/news.php?type=qna">Q&A</a>
    </nav>

      <div class="board-tools">
        <?php
if(
    $boardType === 'notice' &&
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'admin'
):
?>

<a
    href="/coffee/pages/notice_write.php"
    class="write-btn"
>
    공지 작성
</a>

<?php endif; ?>
        <p>전체 <strong><?= count($rows) ?></strong>건 현재 페이지 <strong>1/1</strong></p>
      <?php if($boardType === 'qna'): ?>

<a
    class="write-btn"
    href="/coffee/pages/qna_write.php"
>
    문의 등록
</a>

<?php endif; ?>
      <div class="board-table-wrap">
        <table class="board-table">
          <thead>
            <tr>

              <th>제목</th>
              <th>작성자</th>
              <th>조회 수</th>
              <?php if ($boardType === 'qna'): ?>
              <th>날짜</th>
              <th>상태</th>

              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?= e($row['id']) ?></td>
                <td class="board-subject">
                <a href="/coffee/pages/news_view.php?id=<?= $row['id'] ?>&type=<?= $row['type'] ?>">
               <?= e($row['title']) ?>
                </a>
                </td>
                <?php if ($boardType === 'qna'): ?>
    <td><?= e($row['masked_userid']) ?></td>
<?php else: ?>
    <td>관리자</td>
<?php endif; ?>
                <td><?= e($row['date']) ?></td>
                <td><?= e($row['views']) ?></td>
                <?php if ($boardType === 'qna'): ?>
                  <td><?= e($row['status']) ?></td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <script src="/coffee/assets/js/nav.js"></script>
</body>
</html>