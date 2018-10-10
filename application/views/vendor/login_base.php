<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title><?php if (isset($title) and $title != '') echo $title;
else 'Profile Page - Material Kit by Creative Tim' ?></title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

        <!--     Fonts and icons     -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- CSS Files -->
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?= base_url() ?>assets/css/material-kit.css" rel="stylesheet"/>
        <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet"/>
        <script src="<?= base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
        <script>
            var base_url = "<?php echo base_url() ?>";
            function alertForDelete() {
                if (confirm("Are you sure want to delete this?") == true) {
                    return true;
                } else {
                    return false;
                }
            }
            function alertForChangeStatus() {
                if (confirm("Are you sure want to change Status of this!") == true) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
    </head>

    <body class="profile-page">
        <nav class="navbar navbar-info navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">Brand Logo</a>
                </div>

                <div class="collapse navbar-collapse" id="navigation-example">
                    
                </div>
            </div>
        </nav>
        <div style="height:135px"></div>
        <div class="wrapper" id="page_content">
			<?= $contents; ?>
        </div>
        <footer class="footer">
            <div class="container">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="">
                                Softgators
                            </a>
                        </li>
                        <li>
                            <a href="">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; 2017, made with <i class="fa fa-heart heart"></i> by Softgators
                </div>
            </div>
        </footer>

        <div class="modal fade" id="sys_modal" role="dialog" aria-labelledby="sys_modal_label" aria-hidden="true"></div>
    </body>
    <!--   Core JS Files   -->
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/js/material.min.js"></script>

    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?= base_url() ?>assets/js/nouislider.min.js" type="text/javascript"></script>

    <!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- for dropdown -->
    <script src="<?= base_url() ?>assets/js/jquery.dropdown.js" type="text/javascript"></script>

    <!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
    <script src="<?= base_url() ?>assets/js/material-kit.js" type="text/javascript"></script>

    <script src="<?= base_url('assets/js/jquery.form.js') ?>"></script>
    <script src="<?= base_url('assets/js/datepicker.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
    <script src="<?php echo base_url();?>ckeditor/ckeditor.js"></script>

</html>
