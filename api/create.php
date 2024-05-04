<?php

require dirname(__DIR__).'/config/_autoload.php';
require dirname(__DIR__).'/core/_autoload.php';

$model = new Model();
$method = isset($_POST['_method']) ? $_POST['_method'] : 'post'; 

function getResultData($result = array(), $message = ''){
    return array(
        'success' => (bool) $result,
        'result' => $result, 
        'message' => $message
    ); 
}

$result = null; 

switch ($method){
    case 'post':
        $result = getResultData($model->insert($_POST), '정상적으로 등록되었습니다.');
        break; 
    case 'patch':
        $result = getResultData($model->update($_GET['id'], $_POST), '정상적으로 수정되었습니다.');
        break; 
    case 'delete':
        $result = getResultData($model->delete($_GET['id']), '정상적으로 삭제되었습니다.');
        break; 
}

echo json_encode($result);