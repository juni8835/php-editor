<?php


require __DIR__.'/config/_autoload.php';
require __DIR__.'/core/_autoload.php';

$model = new Model();
$data = $model->findById($_GET['id'])[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- summernote -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/summernote/summernote.min.css">

    <!-- summernote -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="/summernote/summernote.min.js"></script>
    <script src="/summernote/lang/summernote-ko-KR.js"></script>
</head>

<body style="padding: 40px">

    <div class="container" style="max-width: 768px; margin:0 auto">

        <form method="post">
            <div>
                <label for="title">제목</label>
                <input type="text" name="title" id="title" value="<?=$data->title?>">
            </div>
            <div>
                <label for="content">내용</label>
                <textarea name="content" id="content"><?=DB::unesc($data->content)?></textarea>
                <!-- <textarea name="content" id="content"></textarea> -->
            </div>
            <button>수정</button>
            <a href="./index.php">목록</a>
        </form>
    </div>

    <script>
    const frm = document.forms[0];
    $('#content').summernote({
        lang: 'ko-KR',
        height: 300,
    })

    frm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(frm);
        fd.append('_method', 'patch');

        const params = new URLSearchParams(location.search);
        const url = '/api/create.php?' + params.toString();

        const resp = await fetch(url, {
            method: 'POST',
            body: fd
        });
        const result = await resp.json();

        alert(result.message);
        if (result.success) {
            location.reload();
        };
    })
    </script>
</body>

</html>