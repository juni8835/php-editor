<?php


require __DIR__.'/config/_autoload.php';
require __DIR__.'/core/_autoload.php';

$model = new Model();
$data = $model->find();

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
        <ul>
            <?php foreach ($data as $row): ?>
            <li>
                <div>
                    <a href="./edit.php?id=<?=$row->id?>">
                        <?=$row->title?>
                    </a>
                    <button type="button" onclick="handleClick(<?=$row->id?>);">삭제</button>
                </div>
            </li>
            <?php endforeach ; ?>
        </ul>
        <hr>
        <form method="post">
            <div>
                <label for="title">제목</label>
                <input type="text" name="title" id="title">
            </div>
            <div>
                <label for="content">내용</label>
                <textarea name="content" id="content"></textarea>
            </div>
            <button>전송</button>
        </form>
    </div>

    <script>
    const handleClick = async (id) => {
        if (confirm('정말로 삭제하시겠습니까?')) {
            const resp = await fetch(`/api/create.php?id=${id}`, {
                method: 'POST',
                body: new URLSearchParams({
                    _method: 'delete'
                })
            });
            const result = await resp.json();

            // console.log(result);
            alert(result.message);
            if (result.success) {
                location.reload();
            }
        }
    }

    const frm = document.forms[0];
    $('#content').summernote({
        lang: 'ko-KR',
        height: 300,
    })

    frm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(frm);
        const resp = await fetch('/api/create.php', {
            method: 'POST',
            body: fd
        });
        const result = await resp.json();

        // console.log(result);
        alert(result.message);
        if (result.success) {
            location.reload();
        }
    })
    </script>
</body>

</html>