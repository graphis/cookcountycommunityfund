<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cook County Community Fund</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
</head>

<body>

    <nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
        <a class="navbar-brand" href="#">Cook County Community Fund</a>
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">About <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/board">Board</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/directory">Directory</a>
            </li>
        </ul>
    </nav>

    <?php if ($this->section('intro')): ?>
    <div class="jumbotron">
        <?= $this->section('intro') ?>
    </div>
    <?php endif ?>

    <?= $this->section('content') ?>

    <div class="container">
        <hr>
        <footer>
            <p class="text-center">Copyright &copy; 2015 Cook County Community Fund</p>
        </footer>
    </div>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
