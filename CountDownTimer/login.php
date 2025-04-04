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
    transition: 0.4s ease-in-out;
}

.inner-box:hover {
    transform: translateY(-50%) scale(1.05); 
    box-shadow:4px 10px 10px rgba(46, 49, 53, 0.634);
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
    border-radius: 8px;
    font-size: 1rem;
    margin-top: 4px;
}

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
    color: #555;
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
    color: #3498db;
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
    animation: float 6s ease-in-out infinite;
}

.c1 {
    top: 50px;
    left: 40px;
    animation-delay: 0s;
}

.c2 {
    bottom: 50px;
    right: 50px;
    animation-delay: 0s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

</style>
</head>
<body>
    
<div class="outer-box">
       <div class="inner-box">
          <header class="signup-header">
            <h1>Login</h1>
            <p>It just takes 30 seconds</p>
          </header>
        <div >
        <main class="signup-body">
            <form action="login_process.php" method="POST">
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </p>
                <p>
    <label for="password">Your password</label>
    <div class="input-container" style="position: relative;">
        <input type="password" name="password" id="password" placeholder="Enter Your Password" required 
        style="width: 100%; padding: 15px; border: 2px solid #ccc; border-radius: 8px; font-size: 1rem; margin-top: -2px; padding-right: 40px;">
        <span class="toggle-password" onclick="togglePasswordVisibility()" 
        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁</span>
    </div>
</p>
                <p>
                    <input type="submit" id="submit" value="Login">
                </p>
                
             <p style="margin-left:25px;">  Don't have an account? <a style="text-decoration:none;" href="index.php"> Create Account</a></p>
            </form>
        </main>
    </div>
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
</body>
</html>