const datatableCall = (targetId, url, columns) => {
    $(`#${targetId}`).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "GET",
            data: function (d) {
                d.mode = "datatable";
                d.bulan = $("#bulan_filter").val() ?? null;
                d.tahun = $("#tahun_filter").val() ?? null;
                d.tanggal = $("#tanggal_filter").val() ?? null;
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
                    $(`#${targetId} #${field}`)
                        .val(response.data[field])
                        .trigger("change");
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

const getDetailIzin = (targetId, url = null, fields = null) => {
    $(`#${targetId}`).modal("show");
    $(`#${targetId} .form-control`).removeClass("is-invalid");
    $(`#${targetId} .invalid-feedback`).html("");

    if (url) {
        const successCallback = function (response) {
            fields.forEach((field) => {
                if (response.data[field]) {
                    if (field == "file") {
                        $(`#${field}`).attr(
                            "src",
                            "/storage/img/izin/" + response.data[field]
                        );
                    }

                    if (field == "id") {
                        $(`#${targetId} #${field}`).val(response.data[field]);
                    }
                    $(`#${field}`).html(response.data[field]);
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
    swal({
        title: "Apakah Kamu Yakin?",
        text: "ingin menghapus data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const data = null;

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

const select2ToJson = (selector, url, modal = null) => {
    const selectElem = $(selector).empty();

    const successCallback = function (response) {
        selectElem.empty();

        const emptyOption = $("<option></option>");
        emptyOption.attr("value", "");
        emptyOption.text("-- Pilih Data --");
        selectElem.append(emptyOption);

        const responseList = response.data;
        responseList.forEach(function (row) {
            const option = $("<option></option>");
            option.attr("value", row.id);
            if (row.qty >= 0) {
                option.text(
                    row.unit.nama !== "Kosong"
                        ? row.nama +
                              " - Jumlah Stok : " +
                              row.qty +
                              " " +
                              row.unit.nama
                        : row.nama + " - " + row.qty
                );
            } else {
                option.text(row.nama);
            }
            selectElem.append(option);
        });

        selectElem.select2({
            dropdownParent: $(modal),
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

const confirmStok = (id) => {
    swal({
        title: "Apakah Kamu Yakin?",
        text: "Akan menyelesaikan proses!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const data = new FormData();
            data.append("_method", "PUT");
            data.append("status", "1");

            const successCallback = function (response) {
                handleSuccess(response, null, null, `/admin/stok/${id}`);
            };

            const errorCallback = function (error) {
                console.log(error);
            };

            ajaxCall(
                `/admin/stok/${id}`,
                "POST",
                data,
                successCallback,
                errorCallback
            );
        }
    });
};

const createChart = (labels, stokMasuk, stokKeluar) => {
    const statistics_chart = $("#myChart");

    if (statistics_chart.data("chart")) {
        statistics_chart.data("chart").destroy();
    }

    const ctx = statistics_chart[0].getContext("2d");

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Stok Masuk",
                    data: stokMasuk,
                    borderWidth: 5,
                    borderColor: "#6777ef",
                    backgroundColor: "rgba(103, 119, 239, 0.3)",
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#6777ef",
                    pointRadius: 4,
                },
                {
                    label: "Stok Keluar",
                    data: stokKeluar,
                    borderWidth: 5,
                    borderColor: "#ff5733",
                    backgroundColor: "rgba(255, 87, 51, 0.3)",
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#ff5733",
                    pointRadius: 4,
                },
            ],
        },
        options: {
            legend: {
                display: true,
            },
            scales: {
                yAxes: [
                    {
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 50,
                        },
                    },
                ],
                xAxes: [
                    {
                        gridLines: {
                            color: "#fbfbfb",
                            lineWidth: 2,
                        },
                    },
                ],
            },
        },
    });

    statistics_chart.data("chart", myChart);
};

const updateTable = (data) => {
    $("#presensiTable").empty();

    const theadRow = $("<tr>");
    theadRow.append("<th>#</th>");
    theadRow.append('<th class="text-center" style="width: 500px;">Nama</th>');

    data.labels.forEach((label) => {
        theadRow.append(`<th colspan="2" class="text-center">${label}</th>`);
    });

    const thead = $('<thead class="text-center">').append(theadRow);
    $("#presensiTable").append(thead);

    const tbody = $("<tbody>");

    data.presensi_data.forEach((item, index) => {
        const row = $("<tr>");
        row.append($("<td>").text(index + 1));
        row.append($("<td>").text(item.nama));

        item.presensi.forEach((count) => {
            row.append(`
                <td class="text-center"><span class="badge ${
                    count.masuk === 0 ? "badge-danger" : "badge-success"
                }">${count.masuk}</span></td>
                <td class="text-center"><span class="badge ${
                    count.keluar === 0 ? "badge-danger" : "badge-success"
                }">${count.keluar}</span></td>
            `);
        });
        tbody.append(row);
    });

    $("#presensiTable").append(tbody);
};
