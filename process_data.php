<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    exit("POST request method required");
}

if (empty($_FILES))
{
    exit("$_FILES is empty, is file_uploads enabled in php.ini?");
}

if ($_FILES["data"]["error"] !== UPLOAD_ERR_OK)
{
    switch ($_FILES["data"]["error"])
    {
        case UPLOAD_ERR_PARTIAL:
            exit("File only partially uploaded");
            break;
        case UPLOAD_ERR_NO_FILE:
            exit("No file uploaded");
            break;
        case UPLOAD_ERR_EXTENSION:
            exit("File upload stopped by php");
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            exit("Temp folder not found");
            break;
        case UPLOAD_ERR_CANT_WRITE:
            exit("Failed to write to file");
            break;
        default:
            exit("Unknown upload error");
            break;
    }
}

$mime_types = ["text/plain"];

if ( ! in_array($_FILES["data"]["type"], $mime_types))
{
    exit("Invalid file type");
}

$filename = htmlspecialchars($user["email"]);

$destination = __DIR__ . "/uploaded_data/" . $filename;

rename($_FILES["data"]["tmp_name"], "$destination");

print_r($_FILES);