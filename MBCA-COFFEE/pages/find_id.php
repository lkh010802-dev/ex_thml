<?php

session_start();

require_once __DIR__ . '/../config/database.php';

$foundUserId = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $stmt = mysqli_prepare(
        $db,
        "SELECT userid
         FROM users
         WHERE name = ?
         AND email = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        'ss',
        $name,
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    if ($user) {

        $userid = $user['userid'];

        $foundUserId =
            substr($userid, 0, 3)
            . str_repeat('*', max(strlen($userid) - 3, 0));

    } else {

        $error = '일치하는 회원 정보를 찾을 수 없습니다.';

    }
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>아이디 찾기 | MBCA COFFEE</title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/forms.css">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="form-page">

    <section class="form-card">

        <h1>아이디 찾기</h1>

        <form method="post">

            <p>
                이름<br>
                <input
                    type="text"
                    name="name"
                    required
                >
            </p>

            <p>
                이메일<br>
                <input
                    type="email"
                    name="email"
                    required
                >
            </p>

            <button type="submit">
                아이디 찾기
            </button>

        </form>

        <?php if($foundUserId): ?>
            <p class="form-success">
                회원님의 아이디는
                <strong><?= htmlspecialchars($foundUserId) ?></strong>
                입니다.
            </p>
        <?php endif; ?>

        <?php if($error): ?>
            <p class="form-error">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <div class="form-links">
            <a href="/coffee/pages/login.php">로그인</a>
            <a href="/coffee/pages/find_password.php">비밀번호 찾기</a>
        </div>

    </section>

</main>

<script src="/coffee/assets/js/nav.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>