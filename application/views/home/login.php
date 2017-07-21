<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRM LAKITA </title>
        <script src="<?php echo base_url(); ?>style/js/common/jquery.min.js"></script>
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>style/css/common/bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>style/js/common/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <h3 class="text-center"> Đăng nhập vào hệ thống CRM Lakita</h3>
                            <div class="col-md-offset-1 col-md-8">
                                <form id="target" action="<?php echo base_url(); ?>home/action_login" method="POST">
                                    <div class="form-group">
                                        <label for="Username">Username</label>
                                        <input type="text" required class="form-control" id="username" name= "username" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="password" required class="form-control" id="password" name= "password" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" id="login">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <button type="button" data-toggle="modal" data-target="#myModal3" id="myModal1" style="display:none">Large modal</button>
        <div class="modal" tabindex="-1" role="dialog" id="myModal3">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img style="height:250px" src="<?php echo base_url(); ?>style/img/loading.gif" />
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script>
            $('#myModal').modal({show: true});
            $("#login").click(function () {
                $("#myModal1").click();
                setTimeout(function () {
                    $("#target").submit();
                }, 1000);
                return false;
            });
        </script>
    </body>
</html>