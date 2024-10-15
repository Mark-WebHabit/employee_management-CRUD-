<div class="add-user-modal">

    <form  method="POST" action="./Controllers/add_user.php">
        <h4>Add User</h4>

    <div class="user-input-container">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" id="username" placeholder="Username" maxlength="50">
    </div>

    <div class="user-input-container">
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" id="password" placeholder="Password" >
    </div>

     <div class="user-input-container">
        <label for="confirm_password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Password" >
    </div>

    <div class="button-container">
        <button type="reset" id="add-user-cancel">CANCEL</button><button type="submit">SUBMIT</button>
    </div>

    </form>

</div>