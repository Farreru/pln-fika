<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="/pln/"><b>PLN</b> Dashboard</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new user</p>

                <form action="/pln/function.php?action=register" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name='name' placeholder="Full name" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name='email' placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name='password' id="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Retype password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div id="passwordMessage"></div>

                    <div class="form-group mt-1 mb-3">
                        <label for="role-data">Role</label>
                        <select class="custom-select rounded-0" name="role" id="role-data">
                            <option selected>Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="visitor">Visitor</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-0 mt-2 text-center">
                    <a href="/pln/" class="">Sign in to dashboard</a>
                </p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>

    <script>
        document.getElementById("myForm").addEventListener("submit", function(event) {
            const agreeTermsCheckbox = document.getElementById("agreeTerms");

            if (!agreeTermsCheckbox.checked) {
                alert("Please agree to the terms before submitting.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>

    <script>
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");
        const passwordMessage = document.getElementById("passwordMessage");

        confirmPassword.addEventListener("keyup", function() {
            if (password.value === confirmPassword.value) {
                passwordMessage.innerHTML = '<span style="color:green;">Passwords match</span>';
            } else {
                passwordMessage.innerHTML = '<span style="color:red;">Passwords do not match</span>';
            }
        });
    </script>

</body>

</html>