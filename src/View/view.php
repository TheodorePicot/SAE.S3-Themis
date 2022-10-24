<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <!-- css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">

</head>
<body>
<header>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent fs-5">
            <!-- Navbar content -->
            <a class="navbar-brand"><h1>Themis</h1></a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="frontController.php?action=readAll"><h4>Questions</h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="frontController.php?action=create"><h4>Creer Question</h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><h4>Test</h4></a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <?php
    require __DIR__ . "/{$pathBodyView}";
    ?>
</main>
<footer>

</footer>
</body>
</html>