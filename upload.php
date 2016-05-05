<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


    echo "File name is" .$_FILES["fileToUpload"]["name"]."<br>";
	$im = imagecreatefromgif($target_file);


	if($im && imagefilter($im, IMG_FILTER_GRAYSCALE))
	{
        imagefilter($im, IMG_FILTER_GRAYSCALE);
	    echo 'Image converted to grayscale.<br>';
        //save image resource to file
	    imagegif($im, $target_file);
        //upload grayscale image
        //move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
	}
	else
	{
	    echo 'Conversion to grayscale failed.';
	}
    $job_id = rand(0,999999);
    $client = $_POST["lastname"] . ", " . $_POST["firstname"];
    $psswd = $_POST["password"];
    $email = $_POST["email"];
    //change image to base64
    $imagedata = file_get_contents($target_file);
    $base64 = base64_encode($imagedata);

    $ar = array(
        "job_id" => $job_id,
        "client" => $client, 
        "passwd" => $psswd, 
        "email" => $email,
        "image" => $base64
    );
    $jsonstr = json_encode($ar, JSON_FORCE_OBJECT);
    echo $jsonstr;

	imagedestroy($im);

    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    echo "<img src='" . $target_file ."'></img><br>";

    //encoding json
    echo "Encoding JSON File " . $job_id . "REQ.json<br>";
    $fp = fopen("json_req/". $job_id . 'REQ.json', 'w');
    fwrite($fp, json_encode($jsonstr));
    fclose($fp);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>