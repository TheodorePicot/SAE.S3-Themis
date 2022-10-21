<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
</head>
    <body>
        <header>
            <nav>
                <div id="nav-content">
                    <a href="">QUESTIONS</a>
                </div>
            </nav>
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