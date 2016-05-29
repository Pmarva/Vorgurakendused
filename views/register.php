<!Doctype html>
<html>
<head>
    <title>Registreeri</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-2.x-git.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/someStuff.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Kodune Musa</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= $_SERVER['PHP_SELF']; ?>?view=registration"><span class="glyphicon glyphicon-user"></span> Registreeri </a></li>
                    <li><a href="<?= $_SERVER['PHP_SELF']; ?>?view=login"><span class="glyphicon glyphicon-log-in"></span> Logi sisse </a></li>
                </ul>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    <div class="row">
        <form class="form-horizontal col-sm-3 col-sm-offset-4" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <input type="txt" class="form-control" name="username" id="username" placeholder="Kasutajanimi" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Parool" required>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Parooli kordus" required>
        </div>
        <div class="form-group">
            <button type="submit" name="action" value="registration" class="btn btn-default">Registreeri</button>
        </div>
        </form>
    </div>
    <div class="row">
        <?php foreach (message_list() as $message):?>
            <?= $message; ?>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
