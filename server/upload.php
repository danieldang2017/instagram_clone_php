<?php
include("connectToServer.php");
try {
   
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['file']['error']) ||
        is_array($_FILES['file']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['file']['error'] value.
    switch ($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['file']['size'] > 10240) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['file']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['file']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['file']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $root = $_SERVER['DOCUMENT_ROOT'];
    $dir = sprintf('%s/client/img/instagram_img/%s.%s', $root, sha1_file($_FILES['file']['tmp_name']), $ext);
    if (!move_uploaded_file($_FILES['file']['tmp_name'],$dir)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
    
    //for testing purpose only
    $_SESSION['login_user'] = 'hieutrantvvn2006@gmail.com';
    
    $sqlQuery = $mySQLConnection->prepare("SELECT ID FROM Users WHERE email = '".$_SESSION['login_user']."' LIMIT 1");
    $sqlQuery->execute();
    $row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
    $ID = $row['ID'];
    $insertStatement = sprintf('INSERT INTO Posts(user, image, status, hashTag, createdDate) VALUES (%s, "%s", "%s", "%s", NOW())', $ID, $_FILES['file']['name'], $_POST['status'], $_POST['hashtag']);
    $sqlQuery = $mySQLConnection->prepare($insertStatement);
    try {
        $sqlQuery->execute();
    } catch (Exception $e) {
        $e->getMessage();
    }
    
    $updateStatement = sprintf('UPDATE Users SET PostsCount = PostsCount + 1 WHERE ID = %s', $ID);
    $sqlQuery = $mySQLConnection->prepare($updateStatement);
    try {
        $sqlQuery->execute();
    } catch (Exception $e) {
        $e->getMessage();
    }
    
    echo $ID;
    } catch (RuntimeException $e) {
    
        echo $e->getMessage();
    
    }
?>