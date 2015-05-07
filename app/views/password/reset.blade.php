<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Athele Profile</title>
    <link rel="shortcut icon" href="{{ asset('images/athlete-favicon.png') }}">

    <!-- Bootstrap -->

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main-bootsrap-replace.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700') }}" rel="stylesheet"
          type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body ng-app="myApp" ng-controller="userCtrl">


<!--PROVIDED BY MARCELO MARTINS - BOOTLY @ mmartins-->
<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default" id="middle-pannel">
                    <div class="panel-body">
                        <div class="text-center">
                            <img src="{{ asset('images/athlete-logo.png') }}" class="img-responsive center-block" id="login">

                            <h3 class="text-center text-white text-thin">Forgot Password?</h3>

                            <p class="text-white">If you have forgotten your password - reset it here.</p>

                            <div class="panel-body">

                                <form action="{{ action('RemindersController@postReset') }}" method="POST" class="form"
                                      name="myForm"><!--start form--><!--add form action as needed-->
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <fieldset>
                                        <div class="form-group  has-feedback" id="email-fb">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-envelope"></i></span>
                                                <!--EMAIL ADDRESS-->
                                                <input id="email" name="email" placeholder="email address"
                                                       class="form-control" type="email"
                                                       aria-describedby="inputSuccess2Status" required>
                                                <!--span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span-->

                                            </div>
                                        </div>
                                        <!-- fg-->

                                        <div class="form-group  has-feedback" id="pwd-fb">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-eye-open"></i></span>
                                                <!--PWD-->
                                                <input ng-model="user.password" id="password" name="password"
                                                       placeholder="New Password" class="form-control" type="password"
                                                       required
                                                       data-ng-class="{'ng-invalid':myForm.password_confirmation.$error.match}">
                                                <!--span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span-->
                                            </div>
                                        </div>
                                        <!-- fg-->

                                        <div class="form-group  has-feedback" id="re-pwd-fb">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="glyphicon glyphicon-eye-open"></i></span>
                                                <!--RE PWD-->
                                                <input ng-model="user.passwordConfirm" id="password_confirmation"
                                                       name="password_confirmation" placeholder="Confirm Password"
                                                       class="form-control" type="password" required
                                                       data-match="user.password">

                                                <!--span data-ng-show="myForm.password_confirmation.$error.match" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span-->
                                            </div>
                                        </div>
                                        <!-- fg-->


                                        <div class="form-group">
                                            <input class="btn btn-lg btn-bg btn-block" value="Reset Password"
                                                   type="submit">
                                        </div>

                                        <div class="form-group has-success has-feedback">

                                            <p class="text-white">Reset Password Link Sent To the Email</p>


                                        </div>

                                    </fieldset>
                                </form>
                                <!--/end form-->

                            </div>
                        </div>
                    </div>
                    <!-- panel body-->
                </div>
                <!-- panel-->
            </div>
            <!-- col-->
        </div>
        <!-- row-->
    </div>
    <!-- row-->
</div>
<!-- container-->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!--smooth loading with effects -->
<script src="{{ asset('js/wow.min.js') }}"></script>

<script src="{{ asset('js/angular.min.js') }}"></script>

<script src="{{ asset('js/ui-bootstrap-tpls.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>