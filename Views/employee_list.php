<?php
    require "./Controllers/get_all_employees.php";

    $length = count($employees);
?>

<div class="action-header">
    <div class="add-employee" id="add-employee">
        <i class="fas fa-plus"></i>
        <span>ADD</span>
    </div>
    <input type="text" name="search-employee" id="search-employee" placeholder="Search...">
</div>

<div class="employee-list-container" id="employee-list-container">
    <?php if($length > 0): ?>
        <?php foreach($employees as $emp): ?>
            <div class="employee" data-id="<?= $emp['id'] ?>" data-name="<?= $emp['first_name'] . ' ' . $emp['last_name'] ?>" data-email="<?= $emp['email'] ?>">
                <div class="info">
                    <img src="./asset/default.png" alt="Profile" class="profile">
                    <div class="info-text">
                        <p class="full-name"><?= $emp['first_name'] . " " . $emp['last_name'] ?></p>
                        <small class="email"><?= $emp['email'] ?></small>
                    </div>
                </div>
                <p class="gender">
                    <?php
                        if($emp['gender'] != "male" && $emp['gender'] != "female" )
                        {
                            echo "Not Specified";
                        }else{
                            echo $emp['gender'];
                        }
                    ?>
                </p>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <h3 id="no-emp">No Employee To Show</h3>
    <?php endif ?>
</div>

<div class="add-employee-modal">
    <form class="add-employee-modal-wrapper">
        <h3>ADD EMPLOYEE</h3>

        <div class="name">
            <input type="text" name="first_name" maxlength="50" placeholder="First Name" id="">
            <input type="text" name="last_name" maxlength="50" placeholder="Last Name" id="">
        </div>
        <input type="email" name="email" maxlength="100" id="" placeholder="Email address">
        <input type="text" name="address" maxlength="255" id="" placeholder="Address">
        <div class="gender">
            <label for="gender">Gender</label>
          <select name="gender" id="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="na">Prefer not to say</option>
          </select>
        </div>

        <input type="number" name="salary" id="" placeholder="Salary" min="0">

        <div class="add-employee-buttons">
            <button type="reset" id="cancel-add-employee">
                CANCEL
            </button>
            <button>
                SUBMIT
            </button>
        </div>
    </form>
</div>

<div class="edit-employee-modal">
    <form class="edit-employee-modal-wrapper">
        <h3>EDIT EMPLOYEE</h3>

        <div class="name">
            <input type="text" name="first_name" maxlength="50" placeholder="First Name" id="">
            <input type="text" name="last_name" maxlength="50" placeholder="Last Name" id="">
        </div>
        <input type="email" name="email" maxlength="100" id="" placeholder="Email address">
        <input type="text" name="address" maxlength="255" id="" placeholder="Address">
        <div class="gender">
            <label for="gender">Gender</label>
          <select name="gender" id="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="na">Prefer not to say</option>
          </select>
        </div>

        <input type="number" name="salary" id="" placeholder="Salary" min="0">

        <div class="add-employee-buttons">
            <button type="reset" id="cancel-edit-employee">
                CANCEL
            </button>
            <button>
                SAVE
            </button>
        </div>
    </form>
</div>