<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';


$classifiers  = $db->query("SELECT * from classifiers WHERE status = 1")->results(); // Get all active classifiers

?>
<table id="classifiers" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
    <thead>
        <tr>
            <th>Classifier</th>
            <th>Name</th>
            <th class='searchable'>Scoring</th>
            <th class='searchable'>Rounds</th>
            <th class='searchable'>Distance (feet)</th>
            <th class='searchable'>Strings</th>

            <th class='searchable'>Reload</th>
            <th class='searchable'>Barricade</th>
            <th class='searchable'>Table</th>
            <th class='searchable'>Special Prop</th>
            <th class='searchable'>SHO/WHO</th>
            <th class='searchable'>Movement</th>
            <th>Diagram (new window)</th>

        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($classifiers as $classifier) {
            echo "<tr>";
            echo "<td>$classifier->classifier</td>";
            echo "<td>$classifier->name</td>";
            echo "<td>$classifier->scoring</td>";
            echo "<td>$classifier->rounds</td>";
            echo "<td>$classifier->distance</td>";
            echo "<td>$classifier->strings</td>";

            echo '<td>' . ($classifier->reload  ? 'Yes' : '') . '</td>';
            echo '<td>' . ($classifier->barricade  ? 'Yes' : '') . '</td>';
            echo '<td>' . ($classifier->table  ? 'Yes' : '') . '</td>';
            echo '<td>' . ($classifier->prop  ? 'Yes' : '') . '</td>';
            echo '<td>' . ($classifier->shoWho  ? 'Yes' : '') . '</td>';
            echo '<td>' . ($classifier->movement  ? 'Yes' : '') . '</td>';
            echo '<td>' . '<a href="https://uspsa.org/viewer/' . $classifier->classifier . '.pdf" target="_blank"</a>Diagram</td>';
            echo "</tr>";
        }
        ?>
    </tbody>
    <!-- <tfoot>
        <tr>
            <th>Classifier</th>
            <th>Name</th>
            <th>Scoring</th>
            <th>Rounds</th>
            <th>Distance</th>
            <th>Strings</th>

            <th>Reload</th>
            <th>Barricade</th>
            <th>Table</th>
            <th>Special Prop</th>
            <th>SHO/WHO</th>
            <th>Movement</th>
            <th>Diagram (new window)</th>

        </tr>
    </tfoot> -->
</table>


<!-- Place any per-page javascript here -->
<script type="text/javascript" src="../users/js/pagination/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#classifiers').DataTable({

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
    });
</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>