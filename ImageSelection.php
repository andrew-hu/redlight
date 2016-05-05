<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
    Last Name:<br><input type="text" name="lastname" id="lastname" required><br><br>
    First Name:<br><input type="text" name="firstname" id="firstname" required><br><br>
    Password:<br><input type="text" name="password" id="password" required><br><br>
    Email:<br><input type="text" name="email" id="email" required><br><br>
    <input type="submit" value="Upload Image" name="submit" required><br>
</form>

</body>
</html>

<?php

echo "<hr>Image Upload Page <br>";
echo "<img src='test.gif'></img>";
$im = imagecreatefromgif("test.gif");
imagefilter($im, IMG_FILTER_GRAYSCALE);
echo 'Image converted to grayscale.';
 //save image resource to file
imagegif($im, "test2.gif");
echo "<img src='test2.gif'></img>";

?>
