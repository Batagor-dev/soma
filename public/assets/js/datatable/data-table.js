$(function () {
    $(".table-responsive").each(function () {
        const $t = $(this);
        const ajax = $t.data("link");

        if (!ajax) {
            console.warn("Skip table karena ajax kosong");
            return;
        }
        const $loadingBtn = $(`
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary dt-loading" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </button>
            </div>
        `).hide();
        $t.before($loadingBtn);
        $loadingBtn.show();

        // ambil metadata kolom dulu
        $.ajax({
            url: ajax,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { draw: 1, start: 0, length: 1 },
            success: function (json) {
                console.log(json);

                $loadingBtn.remove();
                json.columns.push({
                    data: null,
                    defaultContent: '<i data-feather="eye"></i>',
                    title: "Detail",
                });
                if (!$.fn.DataTable.isDataTable($t)) {
                    let table = $t.DataTable({
                        autoWidth: false,
                        processing: true,
                        serverSide: true,
                        responsive: {
                            details: {
                                target: -1,
                                type: "column",
                                display: DataTable.Responsive.display.modal({
                                    header: function (row) {
                                        var data = row.data();
                                        return "Details";
                                    },
                                }),
                                renderer:
                                    DataTable.Responsive.renderer.tableAll(),
                            },
                        },
                        language: {
                            processing: `
                                <div class="d-flex">
                                    <button class="btn btn-primary w-100" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                        <span role="status">Loading...</span>
                                    </button>
                                </div>
                            `,
                        },
                        ajax: {
                            url: ajax,
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                        },
                        columnDefs: [
                            {
                                className: "dtr-control",
                                orderable: false,
                                searchable: false,
                                targets: -1,
                            },
                        ],
                        columns: json.columns,
                        order: [[1, "asc"]],
                        fnDrawCallback: function (settings) {
                            feather.replace();
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        },
                    });

                    $(document).on(
                        "shown.bs.modal",
                        ".dtr-bs-modal",
                        function () {
                            feather.replace();
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        }
                    );
                }
            },
            error: function (xhr, error, thrown) {
                $loadingBtn.remove();
                let msg = "Gagal memuat data";
                console.error(xhr);
            },
        });
    });
});
