$(() => {

  const userAddModal = $(".add-user-modal");
  const addUserForm = $(userAddModal).find("form")
  const addUserButton = $(".add-user")
  const cancelAddUser = $("#add-user-cancel");
  const buttonListContainerAction = $(".button-list-container")
  const authId = $("#currentUser").val()
  const cancelEditUser = $("#cancel-edit")
  const confirmEditUser = $("#confirm-edit-user");

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