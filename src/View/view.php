<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <!-- css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Navbar content -->
            <a class="navbar-brand">Themis</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="frontController.php?action=readAll">Questions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="frontController.php?action=create">Creer Question</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Test</a>
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