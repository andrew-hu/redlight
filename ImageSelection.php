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
<div id="mainContent" class="fluid "><p><h2>Image Upload</h2>
 <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
    Last Name:<br><input type="text" name="lastname" id="lastname" required><br><br>
    First Name:<br><input type="text" name="firstname" id="firstname" required><br><br>
    Password:<br><input type="text" name="password" id="password" required><br><br>
    Email:<br><input type="text" name="email" id="email" required><br><br>
    <input type="submit" value="Upload Image" name="submit" required><br>
</form>     
   
</div>
      <div id="artwork" class="fluid" ><h2>Grayscale Convert Example</h2>
<?php
$im = imagecreatefromgif("test.gif");
imagefilter($im, IMG_FILTER_GRAYSCALE);
 //save image resource to file
imagegif($im, "test2.gif");
?>
<div class="gallery"> <img id="img01" src="test.gif" >
  <p class="caption"><i>Input Example Image</i></p>
</div>
<div class="gallery"> <img id="img02" src="test2.gif" >
  <p class="caption"><i>Grayscale output</i></p>
</div>
</div>
      <div id="footer" class="fluid "><p> Red light&trade; Ohlone college</p></div>
	</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
<script>
document.getElementById("fileToUpload").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("img01").src = e.target.result;
        document.getElementById("img02").src = e.target.result;
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
</script>