<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (Login::isLoggedIn()) { 
  Login::redirectToHome(); 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</title>

    <?php 

        Assets::renderCss([
            'bootstrap.min.css', 
            'sb-admin-2.css',
            'font-awesome.min.css'
        ]); 
    ?>

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
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo Link::createUrl('Controllers/Login.php'); ?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <?php if (Login::checkIfLoginHasError()) { ?>
                                          <div class="alert alert-danger">
                                              <p> Account Does Not Exist. </p>
                                          </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type='submit' class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>