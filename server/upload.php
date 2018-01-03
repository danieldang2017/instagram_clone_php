<?php
    include("connectToServer.php");
    session_start();
    
    try {
   
        // Undefined | Multiple Files | $_FILES Corruption Attack
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

        // Check MIME Type 
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

        // Obtain safe unique name from its binary data.
        $root = $_SERVER['DOCUMENT_ROOT'];
        $fileName = sprintf('%s.%s', sha1_file($_FILES['file']['tmp_name']), $ext);
        $dir = sprintf('%s/client/img/instagram_img/%s.%s', $root, sha1_file($_FILES['file']['tmp_name']), $ext);
        if (!move_uploaded_file($_FILES['file']['tmp_name'],$dir)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
        
        // Get user's ID
        $sqlQuery = $mySQLConnection->prepare("SELECT ID FROM Users WHERE email = '".$_SESSION['login_user']."' LIMIT 1");
        $sqlQuery->execute();
        $row = $sqlQuery->fetch(PDO::FETCH_ASSOC);
        $ID = $row['ID'];
        
        // Insert a new Post into Posts table
        $insertStatement = sprintf('INSERT INTO Posts(user, image, status, hashTag, createdDate) VALUES (%s, "%s", "%s", "%s", NOW())', $ID, $fileName, $_POST['status'], $_POST['hashtag']);
        $sqlQuery = $mySQLConnection->prepare($insertStatement);
        try {
            $sqlQuery->execute();
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        // Increase PostsCount of that user
        $updateStatement = sprintf('UPDATE Users SET PostsCount = PostsCount + 1 WHERE ID = %s', $ID);
        $sqlQuery = $mySQLConnection->prepare($updateStatement);
        try {
            $sqlQuery->execute();
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        // Return user's ID
        echo $ID;
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
?>