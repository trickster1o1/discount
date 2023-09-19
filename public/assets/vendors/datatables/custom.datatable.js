var record_datatable = null;
$(document).ready(function () {
    var aTargets = [];
    var dcolumn = [];
    var filter = [];

    $(".list-data tr th").each(function (index, element) {
        if (!$(this).attr("data-filter")) {
            aTargets.push(index);
        }
        if ($(this).attr("data-column")) {
            var column_name = $(this).attr("data-column");
            dcolumn.push({ data: index, name: column_name });
        }
    });

    function generate_filter() {
        if ($(".filter").length > 0) {
            $(".filter").each(function (index, element) {
                var name = $(this).attr("name");
                var value = $(this).val();
                filter[name] = value;
            });
        }
        return filter;
    }

    var dataURL = $(".list-data").attr("data-url");
    /*datatable();
    function datatable(){*/
    record_datatable = $(".list-data").DataTable({
        columns: dcolumn,
        bLengthChange: false,
        bFilter: false,
        order: [],
        pageLength: "100",
        aoColumnDefs: [{ bSortable: false, aTargets: aTargets }],
        processing: true,
        serverSide: true,
        ajax: {
            url: dataURL,
            //data    : generate_filter(),
            data: function (d) {
                return $.extend({}, d, generate_filter());
            },
        },
    });
    //}

    $("#btn-search").on("click", function () {
        //$('#list-data').DataTable().clear().destroy();//clears and destroy datatable in order to generate new dataset
        record_datatable.ajax.reload();
        //datatable();
    });

    $(".filter").on("keypress", function (e) {
        if (e.which == 13) {
            // on enter keypress
            record_datatable.ajax.reload();
        }
    });

    $("#list-data").on("click", ".btn-submit", function (e) {
        e.preventDefault();
        var url = $(this).parent().attr("action");
        var method = $(this).parent().find('input[name="_method"]').val();
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to Delete?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: "_method=" + method,
                    type: "POST",
                    success: function (response) {
                        if (response.type == "success") {
                            record_datatable.ajax.reload();
                        }
                        toastr[response.type](response.message);
                    },
                });
            }
        });
    });

    $("table").on("change", ".update_order", function () {
        var url = $(this).attr("data-url");
        var order_number = $(this).val();
        var datatable = $(this).attr("data-table");
        $.ajax({
            url: url,
            data: "order_number=" + order_number + "&datatable=" + datatable,
            type: "POST",
            success: function (response) {
                record_datatable.ajax.reload();
                //toastr[response.type](response.message);
            },
        });
    });
});
