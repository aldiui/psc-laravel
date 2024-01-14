const datatableCall = (targetId, url, columns) => {
    $(`#${targetId}`).DataTable({
        serverSide: true,
        ajax: {
            url: url,
            type: "GET",
        },
        columns: columns,
    });
};

const ajaxCall = (url, method, data, successCallback, errorCallback) => {
    $.ajax({
        type: method,
        url,
        cache: false,
        data,
        contentType: false,
        processData: false,
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
        dataType: "json",
        success: function (response) {
            successCallback(response);
        },
        error: function (error) {
            errorCallback(error);
        },
    });
};

const getModal = (targetId, url = null, fields = null) => {
    $(`#${targetId}`).modal("show");
    $(`#${targetId} .form-control`).removeClass("is-invalid");
    $(`#${targetId} .invalid-feedback`).html("");
    if (url) {
        console.log(fields);
        const successCallback = function (response) {
            fields.forEach((field) => {
                if (response.data[field]) {
                    $(`#${targetId} #${field}`).val(response.data[field]);
                }
            });
        };

        const errorCallback = function (error) {
            console.log(error);
        };
        ajaxCall(url, "GET", null, successCallback, errorCallback);
    }
    $(`#${targetId} .form-control`).val("");
};

const handleSuccess = (response, dataTableId, modalId = null) => {
    swal({
        title: "Berhasil",
        icon: "success",
        text: response.message,
        timer: 1500,
        buttons: false,
    });

    $(`#${dataTableId}`).DataTable().ajax.reload();
    if (modalId !== null) {
        $(`#${modalId}`).modal("hide");
    }
};

const handleValidationErrors = (error, formId, fields) => {
    fields.forEach((field) => {
        if (error.responseJSON.data[field]) {
            $(`#${formId} #${field}`).addClass("is-invalid");
            $(`#${formId} #error${field}`).html(
                error.responseJSON.data[field][0]
            );
        }
    });
};

const confirmDelete = (url, tableId) => {
    console.log("url", url);
    swal({
        title: "Apakah Kamu Yakin?",
        text: "ingin menghapus data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const data = {
                _token: $("meta[name='csrf-token']").attr("content"),
            };

            const successCallback = function (response) {
                handleSuccess(response, tableId, null);
            };

            const errorCallback = function (error) {
                console.log(error);
            };

            ajaxCall(url, "DELETE", data, successCallback, errorCallback);
        }
    });
};
