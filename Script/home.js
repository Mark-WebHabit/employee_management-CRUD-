$(() => {

  const userAddModal = $(".add-user-modal");
  const addUserForm = $(userAddModal).find("form")
  const addUserButton = $(".add-user")
  const cancelAddUser = $("#add-user-cancel");
  const buttonListContainerAction = $(".button-list-container")
  const authId = $("#currentUser").val()
  const cancelEditUser = $("#cancel-edit")
  const confirmEditUser = $("#confirm-edit-user");
  const addEmployeeButtonModal = $("#add-employee")
  const addEmployeeModal = $(".add-employee-modal")
  const addEmployeeModalForm = $(".add-employee-modal-wrapper");
  const cancelAddEmployee = $("#cancel-add-employee")

  const editEmployeeModal = $(".edit-employee-modal")
  const editEmployeeModalForm = $(".edit-employee-modal-wrapper");
  const cancelEditEmployee = $("#cancel-edit-employee")
  const editEmployeeButtonModal = $("#edit-employee")
  let employeeInfoId = null;
  let returnedUser = null;
  
  

  addUserButton.on('click', () => {
    console.log("hello");
    toggleAddModal(addUserForm, userAddModal, true);
  })
   cancelAddUser.on('click', () => {
    console.log("hello");
    toggleAddModal(addUserForm, userAddModal, false);
  })

  buttonListContainerAction.on('click', (e) => {
    const id = e.currentTarget.dataset.id;

    
    if($(e.target).hasClass("user-list-trash"))
    {
        if(authId == id)
        {
            return alert("Cannot delete self");
        }

        $.ajax({
            url: './Controllers/delete_users.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                alert('Record deleted successfully!');
                $(e.currentTarget).parent().remove()
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        })
    }

    if($(e.target).hasClass("user-list-edit"))
    {
        toggleAddModal($(".wrapper-edit"), $(".edit-user-modal"), true)
        $.ajax({
            url: './Controllers/get_user.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                $("#edit-username").val(response)
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        })
    }

    cancelEditUser.on('click', () => {
         $("#edit-username").val("")
            toggleAddModal($(".wrapper-edit"), $(".edit-user-modal"), false)
    })

    confirmEditUser.on('click', () => {
        if($("#edit-username").val() == "")
        {
            return alert("Cannot Save Empty Value")
        }

         $.ajax({
            url: './Controllers/edit_user.php',
            type: 'POST',
            data: {id: id, username: $("#edit-username").val()},
            success: function(response) {
                $(cancelEditUser).trigger('click')
                location.reload()
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        })

    })

})


    addEmployeeButtonModal.on('click', () => {
        toggleAddModal(addEmployeeModalForm, addEmployeeModal, true)
    })
    cancelAddEmployee.on('click', () => {
        toggleAddModal(addEmployeeModalForm, addEmployeeModal, false)
    })
    addEmployeeModalForm.on('submit', (e) => {
        e.preventDefault();
        // console.log("hi");
        const firstName = $(e.target).find("input[name=first_name]")
        const lastName = $(e.target).find("input[name=last_name]")
        const email = $(e.target).find("input[name=email]")
        const address = $(e.target).find("input[name=address]")
        const gender = $(e.target).find("select")
        const salary = $(e.target).find("input[name=salary]")

        if(!firstName.val() || !lastName.val() || !email.val() || !address.val() || !gender.val() || !salary.val()) {
        // Handle the case when any required field is empty
             return alert("All fields are required.");
         }

         if(salary <= 0)
         {
             return alert("Salary too low.");
         }

         const form = new FormData(e.target);

        $.ajax({
            url: "./Controllers/add_employee.php",
            type: "POST",
            data: form,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Prevent jQuery from setting the content type
            success: (response) => {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: (xhr, status, error) => {
                console.error('Error:', error);
                alert("An error occurred: " + error);
            }
        });
        
    } )

     $("#search-employee").on("keyup", function() {
    
        var value = $(this).val().toLowerCase();
        
        $("#employee-list-container .employee").filter(function() {
            $(this).toggle($(this).data('name').toLowerCase().indexOf(value) > -1 || $(this).data('email').toLowerCase().indexOf(value) > -1)
        });
    });

    $(".employee").on('click', (e) => {
        const id = $(e.currentTarget).data('id')

        if(id)
        {
            employeeInfoId = id;

            $.ajax({
                url:`./Controllers/get_employee.php?id=${employeeInfoId}`,
                type: "GET",
                success: (response) => {
                returnedUser = JSON.parse(response);
                
                if(returnedUser)
                {
                    $('.employee-info').css("display", "flex")
                    $("#no-selected").css("display", "none");

                    $("#fullname-info").text(`${returnedUser.first_name} ${returnedUser.last_name}`)
                    $("#email-info").text(returnedUser.email)
                    $("#address-info").text(returnedUser.address)
                    $("#gender-info").text(`${ returnedUser.gender =="na" ? "Prefer not to say" : returnedUser.gender }`)
                    $("#salary-info").text(returnedUser.salary)
                    
                }else{
                    $('.employee-info').css("display", "none");
                     $("#no-selected").css("display", "block");
                }
                
                    
                },
                error: (xhr, status, error) => {
                    console.error('Error:', error);
                    alert("An error occurred: " + error);
                }
            })
        }
    })

     $('.employee-info').on('click',  (e) => {
        const targetId = $(e.target).attr("id")

        if(targetId === "edit-employee" && returnedUser)
        {
                toggleAddModal(editEmployeeModalForm, editEmployeeModal, true)
                const firstName = $(".edit-employee-modal-wrapper").find("input[name=first_name]")
                const lastName = $(".edit-employee-modal-wrapper").find("input[name=last_name]")
                const email = $(".edit-employee-modal-wrapper").find("input[name=email]")
                const address = $(".edit-employee-modal-wrapper").find("input[name=address]")
                const gender = $(".edit-employee-modal-wrapper").find("select")
                const salary = $(".edit-employee-modal-wrapper").find("input[name=salary]")

                firstName.val(returnedUser.first_name)
                lastName.val(returnedUser.last_name)
                email.val(returnedUser.email)
                address.val(returnedUser.address)
                gender.val(returnedUser.gender)
                salary.val(returnedUser.salary)
        }

        if(targetId === "delete-employee" && employeeInfoId)
        {
              $.ajax({
                url: './Controllers/delete_employee.php',
                type: 'POST',
                data: { id: employeeInfoId },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        // Optionally remove the deleted item from the DOM
                        location.reload()
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("An error occurred: " + error);
                }
        });
        }

        console.log(targetId);
        
        
    })

    cancelEditEmployee.on('click', () => {
        toggleAddModal(editEmployeeModalForm, editEmployeeModal, false)
    })

    editEmployeeModalForm.on('submit', (e) => {
        e.preventDefault()
        
        const firstName = $(e.target).find("input[name=first_name]")
        const lastName = $(e.target).find("input[name=last_name]")
        const email = $(e.target).find("input[name=email]")
        const address = $(e.target).find("input[name=address]")
        const gender = $(e.target).find("select")
        const salary = $(e.target).find("input[name=salary]")

        if(!firstName.val() || !lastName.val() || !email.val() || !address.val() || !gender.val() || !salary.val()) {
        // Handle the case when any required field is empty
             return alert("All fields are required.");
         }

         if(salary <= 0)
         {
             return alert("Salary too low.");
         }

         const form = new FormData(e.target);
         form.append("id", employeeInfoId)

         $.ajax({
            url: "./Controllers/edit_employee.php",
            type: "POST",
            data: form,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Prevent jQuery from setting the content type
            success: (response) => {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: (xhr, status, error) => {
                console.error('Error:', error);
                alert("An error occurred: " + error);
            }
        });

    })


})

function toggleAddModal(node1, node2, flag)
{
    if(!flag){
        $(node1).animate({
            "top": "-150%"
        }, 200, () => {
            $(node2).css("display", "none")
            isShowAddModal = true
        })
    }else{
        $(node2).css("display", "grid")
        $(node1).animate({
            "top": "0"
        }, 200, () => {
            isShowAddModal = false
        })
    }
}