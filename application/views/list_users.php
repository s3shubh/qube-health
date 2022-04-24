<div class="col-9">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Users</h3>
        </div>
        <div class="card-body">

            <table id="fileData" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Last Login</th>
                        <th>User type</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>
var dataTable;
$(document).ready(function() {

    fetch_data('no');

    function fetch_data(is_date_search, start_date = '', end_date = '') {

        dataTable = $('#fileData').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url(); ?>admin/fetchData",
                type: "POST",
                data: {
                    is_date_search: is_date_search,
                    start_date: start_date,
                    end_date: end_date,
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'
                }
            }
        });
    }

});

function reload_table() {
    dataTable.ajax.reload(); //reload datatable ajax 
}

function exportexcel() {
    var utc = new Date().toJSON().slice(0, 10).replace(/-/g, '/');
    $("#fileData").table2excel({
        name: "Table2Excel",
        filename: "Compliance_list_" + utc,
        fileext: ".xls"
    });
}

function changeStatus(id, active) {
    $.ajax({
        url: "<?php echo base_url(); ?>admin/activeInactive/" + id,
        data: {
            active: active
        },
        type: "POST",
        success: function(result) {
            if (result) {
                toastr.success('Status updated Successfull.');
            } else {
                toastr.error('Failed to add status');
            }
            reload_table();
        },
        error: function() {
            Toast.fire({
                icon: 'error',
                title: 'Something wents wrong! try again'
            });
            reload_table();
        }
    });
}
</script>