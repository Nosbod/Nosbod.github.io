<?php
include_once 'request.php';
$rest = new Request();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<p>Parameters: <?php echo $rest->parameters ?></p>
<p>URL Elements: <?php echo $rest->url_elements ?></p>
<p>Verb: <?php echo $rest->verb ?></p>
</body>
</html>
