<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Secure Login: Error</title>
    </head>
    <body>
        <h1 id="error-title">There was a problem</h1>
        <p id="error-desc"><?php echo $error; ?></p>
    </body>
</html>
