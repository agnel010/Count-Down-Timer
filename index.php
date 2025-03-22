<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Lato", sans-serif;
}

.outer-box {
    width: 100vw;
    height: 100vh;
    background: linear-gradient(to top left, #be7cc8, #4b0295);
}

.inner-box {
    margin-left:550px;
    width: 400px;
    padding: 20px 40px;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(to top left, #ffffffea, #ffffff33);
    backdrop-filter: blur(5px);
    border-radius: 8px;
    box-shadow: 4px 4px 5px rgba(46, 49, 53, 0.634);
    z-index: 2;
}

.signup-header h1 {
    font-size: 2.5rem;
    color: #212121;
}

.signup-header p {
    font-size: 0.9rem;
    color: #555;
}

.signup-body {
    margin: 20px 0;
}

.signup-body p {
    margin: 10px 0;
}

.signup-body p label {
    display: block;
    font-weight: bold;
}

.signup-body p input {
    width: 100%;
    padding: 15px;
    border: 2px solid #ccc;
    border-radius: 25px;
    font-size: 1rem;
    margin-top: 4px;
}

/* Styling the submit button */
.signup-body p input[type="submit"] {
    border: none;
    color: white;
    cursor: pointer;
    transition: 0.2s ease-in-out;
    background-size: 200%;
    background-image: linear-gradient(to right, #be7cc8,#4b0295 );
}

.signup-body p input[type="submit"]:hover {
    background-position: -100% 0;
}

.signup-footer p {
    
    text-align: center;
}

.signup-footer p a {
    display: block;
    color: #3498db;
    text-decoration: none;
}

.signup-footer p a:link {
    color: blue;
}

.signup-footer p a:visited {
    color: #6b00b8;
}

.signup-footer p a:hover {
    color: #6b00b8;
}

.signup-footer p a:active {
    color: red;
}

.circle {
    width: 200px;
    height: 200px;
    border-radius: 10px;
    background: linear-gradient(to top right, #ffffff22, #ffffffff);
    position: fixed;
}

.c1 {
    top: 50px;
    left: 40px;
}

.c2 {
    bottom: 50px;
    right: 50px;
}
</style>
</head>
<body>
    
<div class="outer-box">
    <div class="inner-box">
        <header class="signup-header">
            <h1>Sign Up</h1>
            <p>It just takes 30 seconds</p>
        </header>
        <main class="signup-body">
            <form action="index_process.php" method="POST">
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </p>
                <p>
    <label for="password">Your password</label>
    <div class="input-container" style="position: relative;">
        <input type="password" name="password" id="password" placeholder="At least 8 characters" required 
        style="width: 100%; padding: 15px; border: 2px solid #ccc; border-radius: 25px; font-size: 1rem; margin-top: 4px; padding-right: 40px;">
        <span class="toggle-password" onclick="togglePasswordVisibility()" 
        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁</span>
    </div>
</p>

                <p>
                    <input type="submit" id="submit" value="Create Account">
                </p>
            </form>
        </main>
        <footer class="signup-footer">
            <p>Already have an account?
                <a href="login.php">Login</a>
            </p>
        </footer>
    </div>
    <div class="circle c1"></div>
    <div class="circle c2"></div>
</div>
<script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>
</form>
</body>
</html>