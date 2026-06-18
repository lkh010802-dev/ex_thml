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
$keyword = trim(
    $_GET['keyword'] ?? ''
);
$page = (int)(
    $_GET['page'] ?? 1
);

if($page < 1){
    $page = 1;
}

$perPage = 10;

$offset =
    ($page - 1)
    * $perPage;

include __DIR__ . '/../config/database.php';

function e($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}
if ($boardType === 'notice') {
$result = mysqli_query(
    $db,
    "SELECT
        id,
        title,
        views,
        created_at,
        is_pinned
     FROM notices
     WHERE title LIKE '%$keyword%'
ORDER BY
is_pinned DESC,
id DESC
LIMIT $offset, $perPage"
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
WHERE title LIKE '%$keyword%'
ORDER BY id DESC
LIMIT $offset, $perPage"
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
            created_at,
            is_pinned
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
if ($boardType === 'notice') {

    $countResult = mysqli_query(
        $db,
        "SELECT COUNT(*)
         FROM notices
         WHERE title LIKE '%$keyword%'"
    );

} else {

    $countResult = mysqli_query(
        $db,
        "SELECT COUNT(*)
         FROM qna
         WHERE title LIKE '%$keyword%'"
    );
}

$totalRows =
    mysqli_fetch_row(
        $countResult
    )[0];

$totalPages = max(
    1,
    ceil($totalRows / $perPage)
);
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


<form method="get">

    <input
        type="hidden"
        name="type"
        value="<?= $boardType ?>"
    >

    <input
        type="text"
        name="keyword"
        value="<?= e($keyword) ?>"
        placeholder="검색어 입력"
    >

    <button type="submit">
        검색
    </button>

</form>
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
        <p>
전체 <strong><?= $totalRows ?></strong>건
현재 페이지
<strong>
<?= $page ?>/<?= $totalPages ?>
</strong>
</p>
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

    <th>번호</th>
    <th>제목</th>
    <th>작성자</th>
    <th>날짜</th>
    <th>조회수</th>

    <?php if ($boardType === 'qna'): ?>
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

<?php if(
    isset($row['is_pinned'])
    &&
    $row['is_pinned']
): ?>
📌
<?php endif; ?>

<?= e($row['title']) ?>

</a>
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
        <div class="pagination">

<?php for(
    $i = 1;
    $i <= $totalPages;
    $i++
): ?>

<a
href="?type=<?= $boardType ?>&keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"
>

<?= $i ?>

</a>

<?php endfor; ?>

</div>
      </div>
    </section>
  </main>

  <script src="/coffee/assets/js/nav.js"></script>
</body>
</html>