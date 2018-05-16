modeSelect = document.getElementsByName("mode")[0];

toggleTeamSelect();

// mode select change listener
modeSelect.addEventListener("change", toggleTeamSelect);


function toggleTeamSelect() {

    if (modeSelect.options[modeSelect.selectedIndex].value == 3) {
        document.getElementsByName("team")[0].style.visibility = "visible";
    } else {
        document.getElementsByName("team")[0].style.visibility = "hidden";
    }

}