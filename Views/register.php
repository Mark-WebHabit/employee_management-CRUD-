<form class="container" method="POST" action="./Controllers/register.php">
    <h2>Register</h2>

      <!-- check if the login.php from the controllers folder returned an error message and display it -->
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="wrapper">
        <i class="fas fa-user icon"></i>
        <div class="input-container">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" maxlength="50">
        </div>
    </div>

    <div class="wrapper">
        <i class="fas fa-lock icon"></i>
        <div class="input-container">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
    </div>

     <div class="wrapper">
        <i class="fas fa-lock icon"></i>
        <div class="input-container">
            <label for="password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
        </div>
    </div>

    <button>
        REGISTER
    </button>

    <a href="./?page=login">I have account</a>

</form>