<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
    $uploadOk = 1;

    // Check file type
    $fileType = mime_content_type($_FILES["uploaded_file"]["tmp_name"]);
    if ($fileType != 'image/png' && $fileType != 'image/jpeg') {
	    echo "Only '.jpg' and '.png' files are allowed.";
        $uploadOk = 0;
    }

    // check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        echo $target_file;
        $uploadOk = 0;
    }

    // check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if all good, upload file
    } else {
        if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["uploaded_file"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Injection 0x02</title>
    <link href="../assets/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/custom.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container px-4 py-5" id="custom-cards">
            <h2 class="pb-2 border-bottom"><a href="../index.php">Labs</a> / Insecure file upload 0x02</h2>

            <div class="p-5 mb-4 bg-light rounded-3">
                <h2>Choose a file</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Default file input example</label>
                        <input class="form-control" type="file" id="formFile" name="uploaded_file" onchange="validateFileInput(this);">
                    </div>
                    <div class="mb-3">
                        <button class=" btn btn-outline-secondary" type="submit">Upload</button>
                    </div>
                </form>

                <hr>

                <div>
                    <h2>Uploaded files:</h2>
                    <?php
                    $dir = "./uploads/";
                    if (is_dir($dir)) {
                        $files = scandir($dir);
                        $files = array_diff($files, array('.', '..'));
                        foreach ($files as $file) {
                            echo $file . "<br>";
                        }
                    } else {
                        echo "Directory $dir does not exist.";
                    }
                    ?>
                </div>

            </div>
        </div>
    </main>

    <script src="../assets/popper.min.js"></script>
    <script src="../assets/bootstrap.min.js"></script>

    <script>
        function validateFileInput(input) {
            var validExtensions = ['jpg', 'png'];
            var fileName = input.files[0].name;
            var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            if (!validExtensions.includes(fileNameExt.toLowerCase())) {
                input.value = '';
                alert("Only '.jpg' and '.png' files are allowed.");
            }
        }
    </script>

</body>

</html>
