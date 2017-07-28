<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Edit profile page - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="../../libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/user/user-profile.css" rel="stylesheet" type="text/css">

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="../index.html">Planbook</a></li>
            </ul>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="UserProfile.php">Profile</a></li>
                    <li><a href="#">Group Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="../auth/Login.php">Log out</a></li>
                </ul>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container bootstrap snippets">

    <div class="starter-template">
        <h1>Profile Settings</h1>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-9">
            <form class="form-horizontal">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contact info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone number</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email address</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <h4 class="panel-title">Security</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Old password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">New password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Re-enter password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <div class="col-xs-12 col-sm-3">

            <div class="profile__contact-info">
                <div class="profile__contact-info-item">
                    <div class="profile__contact-info-icon">
                        <i class="fa fa-comment"></i>
                    </div>
                    <div class="profile__contact-info-body">
                        <h5 class="profile__contact-info-heading">
                            Quick tip
                        </h5>
                        Never share your password with anyone besides your parents!
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="../../libs/bootstrap/dist/js/bootstrap.min.js" type="text/javascript" ></script>


</body>
</html>