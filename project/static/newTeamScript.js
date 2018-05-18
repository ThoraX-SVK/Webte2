
var addUserBtn = document.getElementById("addUserToTeam");
var userSelect = document.getElementById("userSelect");

addUserBtn.addEventListener("click", addUserHandler);

function addUserHandler(e) {
    var userID = userSelect.options[userSelect.selectedIndex].value;
    var userText = userSelect.options[userSelect.selectedIndex].innerHTML;
    var addedUsersDiv = document.getElementById("addedUsers");

    if (!userIsAlreadyAdded(userID)) {
        addedUsersDiv.innerHTML +=
            '<input type="hidden" name="userID[]" value="' + userID + '">' +
            userText + '<br/> \n';
    } else {
        alert("User is already selected!");
    }
}

function userIsAlreadyAdded(userID) {
    var users = document.getElementsByName("userID[]");

    for (i in users) {
        if (users[i].value === userID) {
            return true;
        }
    }
    return false;
}