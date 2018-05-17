

$('form').on('submit', uploadFiles);

function uploadFiles(event) {
    event.stopPropagation();
    event.preventDefault();

    var file = document.getElementById('file').files[0];
    var data = new FormData();
    data.append('file', file);
    data["file"] = file;

    ajaxCall(data, '../controller/massRegistrationController.php', "POST", ajaxSuccess, ajaxError, 'multipart/form-data');
}

function ajaxSuccess(data) {

    data = JSON.parse(data);


    if (data.table) {
        $('#results-table')[0].innerHTML = "Results: \n <br/>"  + data.table;
    } else if (data.error) {
        $('#results-table')[0].innerHTML = "Error: \n <br/>"  + data.error;
    } else {
        $('#results-table')[0].innerHTML = "Non-standard output: \n <br/>" + data;
    }

}

function ajaxError(xhr, desc, err) {
    $('#results-table')[0].innerHTML = "ERROR UPLOADING";
    console.log(data);
    console.log(desc);
    console.log(err);
}

function ajaxCall(data, url, method, success, error) {
    $.ajax({
        url: url,
        data: data,
        type: method,
        processData: false,
        success: success,
        contentType: false,
        error: error
    });
}
