<?php

require_once __DIR__ . '/../includes/auth.php';
require_login();

require_once __DIR__ . '/../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $userid = $_SESSION['userid'];

    if(
        isset($_FILES['profile'])
        &&
        $_FILES['profile']['error'] === 0
    ){

        $fileName =
            time().'_'.
            basename(
                $_FILES['profile']['name']
            );

        $uploadDir =
            $_SERVER['DOCUMENT_ROOT']
            . '/coffee/assets/images/profile/';

        move_uploaded_file(
            $_FILES['profile']['tmp_name'],
            $uploadDir.$fileName
        );

        $imagePath =
            '/coffee/assets/images/profile/'
            .$fileName;

        mysqli_query(
            $db,
            "
            UPDATE users
            SET profile_image='$imagePath'
            WHERE userid='$userid'
            "
        );

    }

    header('Location: mypage.php');
    exit;
}
?>
<link rel="stylesheet" href="/coffee/assets/css/profile_upload.css">
<div class="upload-wrap">

    <h1>프로필 사진 변경</h1>

    <form
        method="post"
        enctype="multipart/form-data"
    >

        <img
            id="preview"
            src="/coffee/assets/images/default-profile.png"
            class="upload-preview"
        >

        <label class="upload-select">

            사진 선택

            <input
                type="file"
                name="profile"
                id="profile"
                accept="image/*"
                required
            >

        </label>

        <button
            type="submit"
            class="upload-btn"
        >
            업로드
        </button>

    </form>
    <script>
const fileInput =
    document.getElementById('profile');

const preview =
    document.getElementById('preview');

fileInput.addEventListener(
    'change',
    function(){

        const file =
            this.files[0];

        if(!file) return;

        const reader =
            new FileReader();

        reader.onload =
            function(e){

                preview.src =
                    e.target.result;

            };

        reader.readAsDataURL(file);

    }
);
</script>

</div>