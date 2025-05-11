<?php
include "./partials/header.php";
include "./partials/navbar.php";
include "./partials/hero.php";

if (isPostRequest()) {
    $username = getPostData('username');
    $email = getPostData('email');
    $password = getPostData('password');
    $confirm_password = getPostData('confirm_password');

    $user =  new User;
    if ($user->register($username, $email, $password)) {
        redirect('login.php');
    } else {
        echo "Registration Failed";
    }
}
?>

<!-- Main Content -->
<main class="container my-5">
    <h2 class="text-center mb-4">Register</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username *</label>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address *</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password *</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password *</label>
                    <input
                        type="password"
                        class="form-control"
                        id="confirm-password"
                        name="confirm_password"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="mt-3 text-center">
                Already have an account? <a href="login.php">Login here</a>.
            </p>
        </div>
    </div>
</main>

<?php
include "./partials/footer.php"
?>