<!Doctype html>
<html>
<head>
    <title>TERE</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://code.jquery.com/jquery-2.x-git.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/someStuff.js"></script>
    <script type="text/javascript" src="js/jquery.jplayer.js"></script>
    <link href="css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']; ?>">Kodune Musa</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form method="post" class="navbar-form navbar-left col-xs-6 col-sm-6" role="search">
                <div class="form-group">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="text" name="searchBox" class="form-control" placeholder="Otsi albumi, esineja, nime järgi" required>
                </div>
                <button type="submit" name="action" value="search" class="btn btn-default">Otsi</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= $_SERVER['PHP_SELF']; ?>?view=logout"><span class="glyphicon glyphicon-log-out"></span> Logi välja </a></li>
                </ul>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="row">
    <?php foreach (message_list() as $message):?>
        <?= $message; ?>
    <?php endforeach; ?>
</div>
<div class="container">
    <div class="list-group">
        <?php foreach (model_getSearch() as $result):?>
            <a href="#" class="list-group-item custom-item">
                <span class="glyphicon glyphicon-music"></span>
                <div class="inlineCustom">
                    <h4 class = "list-group-item-heading">
                        <?= $result['Title']?>
                    </h4>
                    <p class="list-group-item-text"><?= $result['Name']?></p>
                    <span class="hidden"><?= $result['Id']?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="footer navbar-fixed-bottom">
        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
        <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
            <div class="jp-type-single">
                <div class="jp-gui jp-interface">
                    <div class="jp-controls">
                        <button class="jp-play" role="button" tabindex="0">play</button>
                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                    </div>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-volume-controls">
                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                    <div class="jp-time-holder">
                        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                        <div class="jp-toggles">
                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                        </div>
                    </div>
                </div>
                <div class="jp-no-solution">
                    <span>Update Required</span>
                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
