jQuery(document).ready(function($) {

    //Initialize data table for the stp citizens table
    $("#citizens-table").DataTable({
        dom: 'Bfrtip',
        buttons: [ 'print' ]
	});
});
