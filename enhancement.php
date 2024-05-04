<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="author" content="The shoesroom" />
  <meta name="topic" content="Enhancement page" />
  <meta name="keywords" content="HTML, CSS" />
  <meta name="description" content="This is the enhancement page" />
  <link rel="stylesheet" type="text/css" href="styles/style.css" />
  <title>Enhancement</title>
</head>

<body>
<div id="background">
    <?php
    include_once("includes/bg.inc")
    ?>
    <div id="page">
	<?php
		include_once("includes/navbar.inc");
    include_once("includes/enhancement.inc");
		include_once("includes/footer.inc");
	?>
    </div>
</div>
</body>

</html>