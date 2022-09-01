<?php view('admin/includes/head', ['title' => 'RESET PASSWORD']) ?>
<body>
    <div id="pageContent" class="dashApp position-relative container-fluid w-100 h-100" style="padding-top: 15%">
        <div class="logo position-absolute"><h4>C</h4></div>
        <div class="login d-lg-flex mx-auto bg-white" style="width : 50%; min-height : 100px">
            <div class="login-image bg-white text-center">
                <img src="/public/admin/static/img/dreamer.svg" alt="Dreamer" class="w-75 h-75">
            </div>
            <div class="login-form h-100 p-3 text-dark">
                <form action="/admin/connect" method="POST">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" placeholder="elfriedv16@gmail.com" class="form-control outline-disabled">
                    </div>
                    <div>
                        <div class="d-flex my-4">
                            <input type="submit" value="Reset Password" class="form-control w-50">
                            <div class="mx-4 lh-35"><span>or</span></div>
                            <a href="/admin/login" class="lh-35">Sign In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/public/admin/static/js/dash.js"></script>
</body>
</html>