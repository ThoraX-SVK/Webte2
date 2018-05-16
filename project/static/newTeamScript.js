
var addUserBtn = document.getElementById("addUserToTeam");
var userSelect = document.getElementById("userSelect");

addUserBtn.addEventListener("click", addUserHandler);

function addUserHandler(e) {
    var userID = userSelect.options[userSelect.selectedIndex].value;
    var userText = userSelect.options[userSelect.selectedIndex].innerHTML;

    document.getElementById("addedUsers").innerHTML +=
        '<input type="hidden" name="userID[]" value="' + userID + '">' +
        userText + '<br/> \n';
}