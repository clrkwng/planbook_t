<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Edit profile page - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">


        body{
            background:#f5f5f5;
            padding-top: 60px;

        }
        /**
         * Panels
         */
        /*** General styles ***/
        .panel {
            box-shadow: none;
        }
        .panel-heading {
            border-bottom: 0;
        }
        .panel-title {
            font-size: 17px;
        }
        .panel-title > small {
            font-size: .75em;
            color: #999999;
        }
        .panel-body *:first-child {
            margin-top: 0;
        }
        .panel-footer {
            border-top: 0;
        }

        .panel-default > .panel-heading {
            color: #333333;
            background-color: transparent;
            border-color: rgba(0, 0, 0, 0.07);
        }

        form label {
            color: #999999;
            font-weight: 400;
        }

        .form-horizontal .form-group {
            margin-left: -15px;
            margin-right: -15px;
        }
        @media (min-width: 768px) {
            .form-horizontal .control-label {
                text-align: right;
                margin-bottom: 0;
                padding-top: 7px;
            }
        }

        .profile__contact-info-icon {
            float: left;
            font-size: 18px;
            color: #999999;
        }
        .profile__contact-info-body {
            overflow: hidden;
            padding-left: 20px;
            color: #999999;
        }
    </style>
</head>
<body>
<?php require_once "template_items/navbar.php";?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
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

<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">


</script>
</body>
</html>