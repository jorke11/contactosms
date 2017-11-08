function Responses() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnSearch").click(this.table);
        console.log("ad");
    }


    this.table = function () {
        var param = {};
        param.inicio = $("#form-responses #inicio").val();
        param.final = $("#form-responses #final").val();
        param.idcanal = $("#form-responses #idcanal").val();

        return $('#tblResponses').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "getResponses",
                method: "POST",
                data: param
            },
            columns: [
                {data: "canal"},
                {data: "source"},
                {data: "numero"},
                {data: "mensaje"},
                {data: "fecha", searchable: false},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.show(' + full.id + ')">' + data + '</a>';
                    }
                }
            ],
        });
    }
}

var obj = new Responses();
obj.init();