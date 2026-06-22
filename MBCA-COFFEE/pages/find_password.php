<?php

session_start();

require_once __DIR__ . '/../config/database.php';

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $userid =
        trim($_POST['userid']);

    $email =
        trim($_POST['email']);

    $newPassword =
        trim($_POST['new_password']);

    $stmt = mysqli_prepare(
        $db,
        "
        SELECT *
        FROM users
        WHERE userid=?
        AND email=?
        "
    );

    mysqli_stmt_bind_param(
        $stmt,
        'ss',
        $userid,
        $email
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $user =
        mysqli_fetch_assoc($result);

    if($user){

        $hash =
            password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );

        $updateStmt =
            mysqli_prepare(
                $db,
                "
                UPDATE users
                SET password=?
                WHERE userid=?
                "
            );

        mysqli_stmt_bind_param(
            $updateStmt,
            'ss',
            $hash,
            $userid
        );

        mysqli_stmt_execute(
            $updateStmt
        );

        $message =
            '비밀번호가 변경되었습니다.';

    }else{

        $error =
            '아이디 또는 이메일이 일치하지 않습니다.';

    }

}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>비밀번호 찾기 | MBCA COFFEE</title>

<link rel="stylesheet" href="/coffee/assets/css/header.css">
<link rel="stylesheet" href="/coffee/assets/css/nav.css">
<link rel="stylesheet" href="/coffee/assets/css/forms.css">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="form-page">

<div class="form-card">

<h1>
비밀번호 찾기
</h1>

<form method="post">

<p>
아이디<br>

<input
type="text"
name="userid"
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

<p>
새 비밀번호<br>

<input
type="password"
name="new_password"
required
>

</p>

<button type="submit">
비밀번호 변경
</button>

</form>

<?php if($message): ?>

<p class="form-success">
<?= $message ?>
</p>

<?php endif; ?>

<?php if($error): ?>

<p class="form-error">
<?= $error ?>
</p>

<?php endif; ?>

<div class="form-links">

<a href="/coffee/pages/login.php">
로그인
</a>

<a href="/coffee/pages/find_id.php">
아이디 찾기
</a>

</div>

</div>

</div>

</main>

<script src="/coffee/assets/js/nav.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>