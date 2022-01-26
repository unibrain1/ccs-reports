<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
<?php
$classifiers = $db->query("SELECT * from ccs_section_classifier")->results(); // Get all active classifiers

?>
<div class='col-12'>
    <div class="row">

        <div class="card card-default">
            <div class="card-header">
                <h2><strong>USPSA Classifiers</strong></h2>
                <h6 class="card-subtitle text-muted">Interesting information about classifiers and setup</h6>

            </div>
            <div class="card-body">


                <tr>
                    <td>Minimum date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>Maximum date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>


                <table id="section" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th class='searchable'>Club</th>
                            <th class='searchable'>Classifier</th>
                            <th class='searchable'>Date</th>
                            <th>Diagram (new window)</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($classifiers as $classifier) {
                            echo "<tr>";
                            echo "<td>$classifier->club</td>";
                            echo "<td>$classifier->classifier</td>";
                            echo "<td>$classifier->date</td>";

                            echo '<td>' . '<a href="https://uspsa.org/viewer/' . $classifier->classifier . '.pdf" target="_blank"</a>Diagram</td>';
                            echo "</tr>";
                        }
                        ?>
                    </tbody>

                </table>

            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
</div>


<!-- Place any per-page javascript here -->
<script type="text/javascript" src="../users/js/pagination/datatables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    var minDate, maxDate;

    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[4]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );


    $(document).ready(function() {
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });



        var table = $('#section').DataTable({
            'pageLength': 25,
            // https: //www.datatables.net/examples/api/multi_filter_select.html
            initComplete: function() {
                this.api().columns('.searchable').every(function() {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.header()))
                        // .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });

        // Refilter the table
        $('#min, #max').on('change', function() {
            table.draw();
        });

    });
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>