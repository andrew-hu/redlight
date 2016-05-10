<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
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
    // "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


    //echo "File name is" .$_FILES["fileToUpload"]["name"]."<br>";
    $im = imagecreatefromgif($target_file);


    if($im && imagefilter($im, IMG_FILTER_GRAYSCALE))
    {
        imagefilter($im, IMG_FILTER_GRAYSCALE);
        //echo 'Image converted to grayscale.<br>';
        //save image resource to file
        imagegif($im, $target_file);
        //upload grayscale image
        //move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
    else
    {
        //echo 'Conversion to grayscale failed.';
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
    //echo $jsonstr;

    imagedestroy($im);

    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    //echo "<img src='" . $target_file ."'></img><br>";

    //encoding json
    //echo "Encoding JSON File " . $job_id . "REQ.json<br>";
    $fp = fopen("json_req/". $job_id . 'REQ.json', 'w');
    fwrite($fp, json_encode($jsonstr));
    fclose($fp);
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
}
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="">
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Red Light Home</title>
<link href="styles/boilerplate.css" rel="stylesheet" type="text/css">
<link href="styles/fluid-grid.css" rel="stylesheet" type="text/css">
<link href="styles/main.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="scripts/respond.min.js"></script>
<!-- HTML5 shim for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<![endif]-->
</head>
<body>
<div class="gridContainer clearfix">
  <div id="header" class="fluid "><img src="_images/red light test.jpg" class="img-responsive" alt="Placeholder image"></div>
      <nav>
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand" href="index.html">Home</a></div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="defaultNavbar1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="ImageSelection.php">Image Selection<span class="sr-only">(current)</span></a></li>
              <li><a href="#">Print</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li></li>
              <li class="dropdown">
<ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
      </nav>
<div id="mainContent" class="fluid "><p><h2>Printing Progress</h2>
<?php echo '<button id="kill" onclick="killcmd()">Kill Print Process</button>' ?>
   
</div>
      <div id="artwork" class="fluid" ><h2>Converting/Etching Progress</h2>
<!--div class="gallery"> <img id="img02" src="test2.gif" -->
<?php echo '<div class="gallery"> <img id="img02" src="' . $target_file . '" >'?>
  <p class="caption"><i>Grayscale output</i></p>
  <?php
  if (file_exists ("json_prog/". $job_id ."PROG.json" )){
    $string = file_get_contents("json_prog/". $job_id ."PROG.json" );
  } else {
    $string = file_get_contents("json_prog/SamplePROG.json");
  }
  //$string = file_get_contents("json_prog/". $job_id ."PROG.json");
  $json = json_decode($string, true);
  ?>
  <progress id="progressbar" value="0" max="100">
  </progress>
  <table id="progress">
  <tr>
  <td>Laser Coordinates (X, Y)</td>
        <td><span id="coordx"></span>,&nbsp;
        <span id="coordy"></span></td>
    </tr>
    <tr>
        <td>Temperature (Celcius)</td>
        <td><span id="temp"></span> Degrees</td>
    </tr>

  </table>
  
</div>
</div>
      <div id="footer" class="fluid "><p> Red light&trade; Ohlone college</p></div>
    </div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
<script>

  setInterval(function() {
    update();
  }, 2000);

function killcmd() {
    <?php 
        $myfile = fopen( "kill/" . $job_id . ".txt", "w") or die("Unable to open file!");
        fclose($myfile);
    ?>
}

function update() {
    var myfile = <?php echo "\"json_prog/".$job_id ."PROG.json\""; ?>;

    $.ajax({
        url:myfile,
        error: function()
        {
           
        },
        success: function()
        {
             $.getJSON( <?php echo "\"json_prog/".$job_id ."PROG.json\""; ?> , function(json) {
            //$.getJSON("json_prog/". <?php echo $job_id; ?> ."PROG.json", function(json) {
            //console.log(json); // this will show the info it in firebug console
            document.getElementById("progressbar").value = json.prgrss;
            document.getElementById("temp").innerHTML = json.temp;
            document.getElementById("coordx").innerHTML = json.coordx;
            document.getElementById("coordy").innerHTML = json.coordy;
            });
        }
    });

   
    
}
</script>


