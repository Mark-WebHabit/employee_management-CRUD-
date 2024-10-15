<?php
require "./Controllers/get_all_users.php";
 $username = $_SESSION['username'];
?>

<section class="users-container">
    <div class="users-wrapper">
        <div class="user-list-header">
            <div class="add-user">
                <i class="fas fa-plus"></i>
                <span>ADD</span>
            </div>

            <!-- <input type="text" id="search-user" placeholder="Search via username"> -->
        </div>

         <?php
        if (isset($_SESSION['add-user-error'])) {
            echo '<p class="add-user-error">' . $_SESSION['add-user-error'] . '</p>';
            unset($_SESSION['add-user-error']);
        }
    ?>
        

        <div class="user-list">

           <?php foreach($users as $user): ?>
                <div class="user" >
                    <p class="username"><?= $user['username'] ?></p>

                    <div class="button-list-container" data-id='<?= $user['id'] ?>'>
                        <button class="user-list-trash">
                            <i class="fas fa-trash user-list-trash"></i>
                        </button>
                        <button class="user-list-edit">
                            <i class="fas fa-pencil user-list-edit"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach ?>

        <p id="end-of-list">----End Of List----</p>
        </div>
    </div>
</section>  


<div class="edit-user-modal">
    <div class="wrapper-edit">

        <input type="text" id="edit-username" placeholder="Edit Username">
        <div class="edit-button-container">
            <button type="reset" id="cancel-edit">Cancel</button><button id="confirm-edit-user">Submit</button>
        </div>
    </div>
</div>

<?php include './Views/add_user_modal.php' ?>