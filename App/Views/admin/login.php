<?php view('admin/includes/head', ['title' => 'LOGIN']) ?>
<body>
    <div id="pageContent" class="dashApp position-relative container-fluid w-100 h-100" style="padding-top: 10%">
        <div class="logo position-absolute"><h4>C</h4></div>
        <div class="login d-lg-flex mx-auto bg-white">
            <div class="login-image bg-white text-center">
                <img src="/public/admin/static/img/dreamer.svg" alt="Dreamer" class="w-75 h-75">
            </div>
            <div class="login-form h-100 p-3 text-dark">
                <form action="/admin/login" method="POST">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" placeholder="elfriedv16@gmail.com" class="form-control outline-disabled">
                    </div>
                    <div class="my-3">
                        <fieldset>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" placeholder="********" class="form-control">
                        </fieldset>
                    </div>
                    <div>
                        <div>
                            <input type="checkbox" id="condition">
                            <label for="condition" class="form-label">I have read and agree to the terms service.</label>
                        </div>
                        <div class="d-flex my-4">
                            <div class="position-relative send-ctn" style="width: 20%; height: 40px">
                                <input type="submit" value="Login" class="form-control w-100 h-100 send">
                                <img src="/public/admin/static/img/loader.gif" alt="loading" class="send-wait d-none position-absolute top-0 start-0 w-100 h-100">
                            </div>
                            <div class="mx-4 lh-35"><span>or</span></div>
                            <a href="/admin/signup" class="lh-35">Sign Up</a>
                        </div>
                        <div>
                            <a href="/admin/resetpassword" class="forgot-pass">Forgot Password ?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php view('admin/includes/footer') ?>
</body>
</html>
