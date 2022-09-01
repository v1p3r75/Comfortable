<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/public/admin/static/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/admin/static/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/public/admin/static/vendors/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="/public/admin/static/vendors/toastr/toastr.min.css">
    <script src="/public/admin/static/vendors/jquery/jquery.min.js"></script>
    <script src="/public/admin/static/vendors/sweetalert/sweetalert2.min.js"></script>
    <script src="/public/admin/static/vendors/toastr/toastr.min.js"></script>
    <title>ADMIN PANEL</title>
    <style>
        ::-webkit-scrollbar {width: 8px;}
        ::-webkit-scrollbar-track {border-radius: 10px;}
        ::-webkit-scrollbar-thumb {background: #1a2038; border-radius: 10px;}
        html, body {width: 100%; height: 100vh; overflow: hidden;}
        #page-container .side-menu {background-color: #1a2038; width: 20%;}
        .side-menu a{color: white;} .main a{color: #757575;} a {text-decoration: none;}
        header {height: 50px; box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1);}
        .cl-link {color: #7467ef!important;} .loading i {color: #1a2038} 
        .btn-add {background-color: #7467ef; padding: 10px; color: white!important; border-radius: 5px;}
        .popup-add-up {width: 50%; height: 450px; top: 12%; left: 25%; z-index: 100;}
        .popup-add-up input {border: 0; border-bottom: 1px solid silver!important; outline: none; padding: 6px 0;}
        input[type=submit] {background-color: #7467ef; padding: 6px 15px; border: none; border-radius: 5px; color: white}
        .popup-confirm {width: 30%; min-height: 100px; top: 35%; left: 35%; z-index: 100;}
        .no {background-color: #ff9e43; padding: 6px 15px; color: white; border-radius: 5px;}
        .drop {background-color: rgba(0, 0, 0, 0.3);}
        .table-i {display:block; background-color: #1a2038; width: 200px; height: 100px; padding: 20px; color: white!important; text-align: center; border-radius: 10px;}
        .table-name {line-height: 50px;}
    </style>
</head>
<body>
    <div id="page-container" class="container-fluid p-0 w-100 h-100 d-flex text-white">
        <div class="preview position-fixed w-100 h-100 bg-white text-black top-0 bottom-0" style="z-index : 10; padding: 15% 0px 30px 0px">
            <div class="w-25 text-center mx-auto">
                <h1 class="fa fa-light"><?= env('APP_NAME') ?></h1>
                <img src="/public/admin/static/img/loader.gif" alt="loading" class="w-75 h-75">
            </div>
            <div class="w-100 text-end position-absolute" style="bottom: 50px; right: 50px"><span class="fw-light"><i class="fa fa-moon me-1"></i> Powered By Comfortable</span></div>
        </div>
        <div class="side-menu h-100 p-3">
            <h4 class="w-100 fa fa-light"><span><?= env('APP_NAME') ?></span> <span class="float-end"><i class="fab fa-phoenix-framework"></i></span></h4>
            <div class="user-section w-50 text-center mx-auto">
                <div class="user-image mt-5 mb-2">
                    <i class='fa fa-user fa-2x'></i>
                    <div class="user-name mt-2"><i><?= $_SESSION['username'] ?></i></div>
                </div>
                <div class="user-action d-flex gap-3 justify-content-center">
                    <div><a href="javascript:void(0)" class='loadView' data-cf-page='profile'><i class="fa fa-tools"></i></a></div>
                    <div><a href="javascript:void(0)" class='loadView' data-cf-page='profile'><i class="fa fa-user"></i></a></div>
                    <div><a href="/admin/logout" title="Logout"><i class="fa fa-sign-out"></i></a></div>
                </div>
            </div>
            <div class="nav d-flex flex-column my-5 gap-4">
                <a href="javascript:void(0)" class="loadView" data-cf-page='dash'><span>Dashboard</span><i class="fa fa-dashboard float-end"></i></a>
                <a href="javascript:void(0)" class="loadView" data-cf-page='tables'><span>Tables</span><i class="fa fa-project-diagram float-end"></i></a>
                <a href="javascript:void(0)" class='loadView' data-cf-page='profile'><span>Profile</span><i class="fa fa-users float-end"></i></a>
                <a href="javascript:void(0)"><span>Settings</span><i class="fa fa-toolbox float-end"></i></a>
            </div>
            <div class="text-center"><i>Comfortable Dashboard - &copy; <?= date('Y') ?></i></div> 
        </div>
        <div class="main h-100" style="width : 80%">
            <header class="d-flex justify-content-between py-3 px-3">
                <div class="top-left d-flex gap-4">
                    <div><a href="javascript:void(0)" class="ui-action" data-toggle-target='side-menu'><i class="fa fa-bars"></i></a></div>
                    <div><a href="javascript:void(0)"><i class="fa fa-envelope"></i></a></div>
                    <!-- <div><i class="fa fa-star-half-o"></i></div>
                    <div><i class="fa fa-bars"></i></div> -->
                </div>
                <div class="top-left d-flex gap-4">
                    <div><a href="javascript:void(0)"><i class="fa fa-search"></i></a></div>
                    <div><a href="javascript:void(0)"><i class="fa fa-shop"></i></a></div>
                    <div><a href="javascript:void(0)" title='<?= $_SESSION['username'] ?>'><i class="fa fa-user-circle"></i></a></div>
                </div>
            </header>
            <section id="pageViewer" class="text-dark mt-4 px-3 overflow-auto h-100" style="padding-bottom: 120px; height: 100%;">
            </section>
        </div>
        <div class="drop position-absolute w-100 h-100 d-none"></div>
    </div>
    <script src="/public/admin/static/js/dash.js"></script>
</body>
</html>