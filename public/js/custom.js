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
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
        },
        columnDefs: [{ width: "5%", targets: 0 }],
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
    const cekLabelModal = $("#label-modal");
    if (cekLabelModal) {
        $("#id").val("");
        cekLabelModal.text("Tambah");
    }

    if (url) {
        cekLabelModal.text("Edit");
        const successCallback = function (response) {
            fields.forEach((field) => {
                if (response.data[field]) {
                    if (field == "tugas") {
                        const selectElem = $(`#${targetId} #${field}`);
                        selectElem.val([]).trigger("change");
                        let string = response.data[field];
                        let array = string
                            .split(",")
                            .map((item) => item.trim());

                        selectElem.prop("multiple", true);
                        selectElem.val(array).trigger("change");
                    } else {
                        $(`#${targetId} #${field}`)
                            .val(response.data[field])
                            .trigger("change");
                    }
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
            text: error.responseJSON.message || error,
            timer: 2000,
            buttons: false,
        });
    }
};

const handleSimpleError = (error) => {
    swal({
        title: "Gagal",
        icon: "error",
        text: error,
        timer: 2000,
        buttons: false,
    });
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

const select2ToJson = (selector, url, modal = null, jenis = "null") => {
    const selectElem = $(selector);

    if (selectElem.children().length > 0) {
        return;
    }

    const successCallback = function (response) {
        const emptyOption = $("<option></option>");
        emptyOption.attr("value", "");
        emptyOption.text("-- Pilih Data --");
        selectElem.append(emptyOption);

        const responseList = response.data;
        responseList.forEach(function (row) {
            const option = $("<option></option>");
            if (jenis == "null") {
                option.attr("value", row.id);
                if (row.qty >= 0) {
                    option.text(
                        row.unit.nama !== "Kosong"
                            ? row.nama +
                                  " ( Jumlah Stok : " +
                                  row.qty +
                                  " " +
                                  row.unit.nama +
                                  " )"
                            : row.nama + " ( Jumlah Stok : " + row.qty + " )"
                    );
                } else {
                    option.text(row.nama);
                }
            } else if (jenis == "barang-bawah") {
                option.attr("value", row.barang_id);
                option.text(
                    row.barang.unit.nama !== "Kosong"
                        ? row.barang.nama +
                              " ( Jumlah Stok : " +
                              row.qty +
                              " " +
                              row.barang.unit.nama +
                              " )"
                        : row.barang.nama + " ( Jumlah Stok : " + row.qty + " )"
                );
            }
            selectElem.append(option);
        });

        selectElem.select2({});
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

const confirmStok = (id, status, cek = false) => {
    swal({
        title: "Apakah Kamu Yakin?",
        text:
            status == "1"
                ? "Akan menyetujui stok ini"
                : "Data ini masih draft, Anda yakin akan menyerahkan ini",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            const data = new FormData();
            data.append("_method", "PUT");
            data.append("status", status);
            const url = cek == false ? `/admin/stok/${id}` : `/stok/${id}`;

            const successCallback = function (response) {
                handleSuccess(response, null, null, url);
            };

            const errorCallback = function (error) {
                handleValidationErrors(error, null, null, null);
            };

            ajaxCall(url, "POST", data, successCallback, errorCallback);
        }
    });
};

const createChart = (
    labels,
    stokMasukGudangAtas,
    stokMasukGudangBawah,
    stokMasukUnit
) => {
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
                    label: "Stok Masuk Gudang Atas",
                    data: stokMasukGudangAtas,
                    borderWidth: 5,
                    borderColor: "#47c363",
                    backgroundColor: "rgba(71, 195, 99, 0.3)",
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#47c363",
                    pointRadius: 4,
                },
                {
                    label: "Stok Masuk Gudang Bawah",
                    data: stokMasukGudangBawah,
                    borderWidth: 5,
                    borderColor: "#ffa426",
                    backgroundColor: "rgba(255, 164, 38, 0.3)",
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#ffa426",
                    pointRadius: 4,
                },
                {
                    label: "Stok Masuk Unit",
                    data: stokMasukUnit,
                    borderWidth: 5,
                    borderColor: "#fc544b",
                    backgroundColor: "rgba(252, 84, 75, 0.3)",
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#fc544b",
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
                            beginAtZero: true,
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
        theadRow.append(`<th class="text-center">${label}</th>`);
    });

    const thead = $('<thead class="text-center">').append(theadRow);
    $("#presensiTable").append(thead);

    const tbody = $("<tbody>");

    data.presensi_data.forEach((item, index) => {
        const row = $("<tr>");
        row.append($("<td>").text(index + 1));
        row.append($("<td>").text(item.nama));

        for (const day in item.presensi) {
            if (item.presensi.hasOwnProperty(day)) {
                const count = item.presensi[day];
                row.append(`
                    <td class="text-center">
                        <div class="d-flex gap-2">
                            <span class="badge ${
                                count.masuk === 0
                                    ? "badge-danger"
                                    : "badge-success"
                            } mr-2">${count.masuk}</span>
                            <span class="badge ${
                                count.keluar === 0
                                    ? "badge-danger"
                                    : "badge-success"
                            }">${count.keluar}</span>
                        </div>
                    </td>
                `);
            }
        }
        tbody.append(row);
    });

    $("#presensiTable").append(tbody);
};

const clearMap = () => {
    if (map) {
        map.remove();
    }
};

const showPositionPengaturan = () => {
    const latitude = $("#latitude").val();
    const longitude = $("#longitude").val();
    const radius = $("#radius").val();

    map = L.map("map").setView([latitude, longitude], 20);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    const pengaturan = $("#nama").val();
    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(pengaturan)
        .openPopup();

    const circle = L.circle([latitude, longitude], {
        color: "green",
        fillColor: "green",
        fillOpacity: 0.5,
        radius: radius,
    }).addTo(map);
};

const setViewNotifikasi = () => {
    $.ajax({
        method: "GET",
        url: "/notifikasi",
    })
        .done(function (data) {
            $("#list-notifikasi").html(data);
        })
        .fail(function (data) {
            if (data.responseJSON && data.responseJSON.message) {
                handleSimpleError(data.responseJSON.message);
            } else {
                handleSimpleError("Terjadi kesalahan pada server.");
            }
        });
};

const updateStatusNotifikasi = (url, kode) => {
    const successCallback = function (response) {
        window.location.href = url;
    };

    const errorCallback = function (error) {
        console.log(error);
    };

    ajaxCall(
        `/notifikasi/${kode}`,
        "PUT",
        null,
        successCallback,
        errorCallback
    );
};

const togglePasswordVisibility = (inputSelector, iconSelector) => {
    let passwordInput = $(inputSelector);
    let toggleIcon = $(iconSelector);

    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
        toggleIcon.removeClass("fas fa-eye").addClass("fas fa-eye-slash");
    } else {
        passwordInput.attr("type", "password");
        toggleIcon.removeClass("fas fa-eye-slash").addClass("fas fa-eye");
    }
};
