const datatableCall = (targetId, url, columns) => {
    $(`#${targetId}`).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "GET",
            data: function (d) {
                d.mode = "datatable";
                d.bulan = $("#bulan").val() ?? null;
                d.tahun = $("#tahun").val() ?? null;
            },
        },
        columns: columns,
        lengthMenu: [
            [25, 50, 100, 250, -1],
            [25, 50, 100, 250, "All"],
        ],
    });
};

const ajaxCall = (url, method, data, successCallback, errorCallback) => {
    $.ajax({
        type: method,
        enctype: "multipart/form-data",
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

const handleSuccess = (
    response,
    dataTableId = null,
    modalId = null,
    redirect = null
) => {
    if (dataTableId !== null) {
        swal({
            title: "Berhasil",
            icon: "success",
            text: response.message,
            timer: 2000,
            buttons: false,
        });
        $(`#${dataTableId}`).DataTable().ajax.reload();
    }

    if (modalId !== null) {
        $(`#${modalId}`).modal("hide");
    }

    if (redirect) {
        swal({
            title: "Berhasil",
            icon: "success",
            text: response.message,
            timer: 2000,
            buttons: false,
        }).then(function () {
            window.location.href = redirect;
        });
    }

    if (redirect == "no") {
        swal({
            title: "Berhasil",
            icon: "success",
            text: response.message,
            timer: 2000,
            buttons: false,
        });
    }
};

const handleValidationErrors = (error, formId = null, fields = null) => {
    if (error.responseJSON.data && fields) {
        fields.forEach((field) => {
            if (error.responseJSON.data[field]) {
                $(`#${formId} #${field}`).addClass("is-invalid");
                $(`#${formId} #error${field}`).html(
                    error.responseJSON.data[field][0]
                );
            } else {
                $(`#${formId} #${field}`).removeClass("is-invalid");
                $(`#${formId} #error${field}`).html("");
            }
        });
    } else {
        swal({
            title: "Gagal",
            icon: "error",
            text: error.responseJSON.message,
            timer: 2000,
            buttons: false,
        });
    }
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

const setButtonLoadingState = (buttonSelector, isLoading, title = "Simpan") => {
    const buttonText = isLoading
        ? `<i class="fas fa-spinner fa-spin mr-1"></i> ${title}`
        : title;
    $(buttonSelector).prop("disabled", isLoading).html(buttonText);
};

const select2ToJson = (selector, url, title) => {
    $(`${selector}`).empty();
    const successCallback = function (response) {
        selectElem = $(selector).empty();

        const defaultOption = $("<option></option>");
        defaultOption.attr("value", "");
        defaultOption.text(`-- ${title} --`);
        selectElem.append(defaultOption);

        const responseList = response.data;
        responseList.forEach(function (row) {
            const option = $("<option></option>");
            option.attr("value", row.id);
            option.text(row.nama);
            selectElem.append(option);
        });
    };

    const errorCallback = function (error) {
        console.log(error);
    };
    ajaxCall(url, "GET", null, successCallback, errorCallback);
};

const updateJam = () => {
    let jam = new Date();
    $("#jam").html(
        "Jam " +
            setUpJam(jam.getHours()) +
            ":" +
            setUpJam(jam.getMinutes()) +
            ":" +
            setUpJam(jam.getSeconds())
    );
};

const setUpJam = (jam) => {
    return jam < 10 ? "0" + jam : jam;
};

const cleanInput = (selector) => {
    $(selector).val("");
};
