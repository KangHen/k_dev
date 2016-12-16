<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DEV</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= asset('asset/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= asset('asset/bower_components/metisMenu/dist/metisMenu.min.css') ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= asset('asset/default/dist/css/sb-admin-2.css') ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= asset('asset/bower_components/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<center>
                        	<img src="<?= asset('image/logo.png') ?>" alt="">
                        </center>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="auth" method="POST">
                            <fieldset>
                                <div class="form-group">
                               		<label>Username</label>
                                    <input class="form-control" placeholder="username" name="user" type ="text" autofocus required />
                                </div>
                                <div class="form-group">
                                	<label>Password</label>
                                    <input class="form-control" placeholder="password" name="pass" type="password" required />
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= asset('asset/bower_components/jquery/dist/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= asset('asset/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= asset('asset/bower_components/metisMenu/dist/metisMenu.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= asset('asset/default/dist/js/sb-admin-2.js') ?>"></script>
</body>
</html>
