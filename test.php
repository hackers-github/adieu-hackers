<?php
include $_SERVER['DOCUMENT_ROOT'] . '/common/common.php';

use classes\FileManager;

$test = $_GET['test'] ?? '';

if(empty($test)) {
    exit;
}

switch($test) {
    case 'phpinfo':
        phpinfo();
        break;

    case 'db':
        $db->connect();
        $db_slave->connect();

        var_dump($db->getDb());
        echo '<br><br>';
        var_dump($db_slave->getDb());
        break;

    case 's3':
        if(!empty($_FILES['file'])) {
            $fileManager = new FileManager();
            $result = $fileManager->upload($_FILES['file'], UPLOAD_PATH);

            var_dump($result);
            exit;
        } ?>
        <form action="/test.php?test=s3" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit">?—…ë¡œë“œ</button>
        </form>
        <?php break;
}
?>
