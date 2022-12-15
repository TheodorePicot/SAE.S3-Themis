<?php

require "vendor/autoload.php";
$parser = new Parsedown();
$parser->setBreaksEnabled(true);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formatting text</title>
</head>
</html>
<body>
<form method="post">

    <div>
        <textarea name="content" id="" cols="30" rows="10"></textarea>
    </div>

    <div>
        <button>Send</button>
    </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === "POST"): ?>

    <div>
        <?= $parser->text($_POST["content"])?>
    </div>
<?php endif ?>
</body>