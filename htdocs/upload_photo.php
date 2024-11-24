<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = basename($_FILES['photo']['name']);
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
        $target_file = $target_dir . uniqid() . "_" . $file_name;

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['photo']['type'], $allowed_types)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                $upload_success = true;
                $uploaded_file_path = $target_file;
            } else {
                $error_message = "Failed to upload the file.";
            }
        } else {
            $error_message = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        $error_message = "No file uploaded or an error occurred.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Photo</title>
</head>
<body>
    <h1>Upload Photo</h1>
    <?php if (isset($upload_success) && $upload_success): ?>
        <p>Photo uploaded successfully!</p>
        <img src="<?php echo htmlspecialchars($uploaded_file_path); ?>" alt="Uploaded Photo" width="300">
    <?php elseif (isset($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="photo">Choose a photo to upload:</label>
        <input type="file" name="photo" id="photo" accept="image/*" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
