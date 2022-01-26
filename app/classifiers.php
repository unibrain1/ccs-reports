<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$classifiers  = $db->query("SELECT * from ccs_classifiers WHERE status = 1")->results(); // Get all active classifiers

?>
<div class='col-12'>
    <div class="row">

        <div class="card card-default">
            <div class="card-header">
                <h2><strong>USPSA Classifiers</strong></h2>
                <h6 class="card-subtitle text-muted">Interesting information about classifiers and setup</h6>

            </div>
            <div class="card-body">

                <table id="classifiers" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th class='searchable'>Classifier</th>
                            <th class='searchable'>Name</th>
                            <th class='searchable'>Scoring</th>
                            <th class='searchable'>Rounds</th>
                            <th class='searchable'>Depth (feet)</th>
                            <th class='searchable'>Width (feet)</th>
                            <th class='searchable'>Strings</th>

                            <th class='searchable'>Reload</th>
                            <th class='searchable'>Barricade</th>
                            <th class='searchable'>Table</th>
                            <th class='searchable'>Special Prop</th>
                            <th class='searchable'>SHO/WHO</th>
                            <th class='searchable'>Movement</th>
                            <th class='searchable'>Last Shot (Years ago)</th>
                            <th class='searchable'>Club</th>
                            <th>Diagram (new window)</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($classifiers as $classifier) {
                            $lastshot = $db->query("SELECT * from ccs_section_classifier WHERE classifier = ? ORDER by date DESC LIMIT 1", [$classifier->classifier])->first();

                            echo "<tr>";
                            echo "<td>$classifier->classifier</td>";
                            echo "<td>$classifier->name</td>";
                            echo "<td>$classifier->scoring</td>";
                            echo "<td>$classifier->rounds</td>";
                            echo "<td>$classifier->distance</td>";
                            echo "<td></td>";
                            echo "<td>$classifier->strings</td>";

                            echo '<td>' . ($classifier->reload  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            echo '<td>' . ($classifier->barricade  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            echo '<td>' . ($classifier->table  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            echo '<td>' . ($classifier->prop  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            echo '<td>' . ($classifier->shoWho  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            echo '<td>' . ($classifier->movement  ? '<strong>Yes</strong>' : '<small>No</small>') . '</td>';
                            if ($lastshot) {
                                echo '<td>' . ($lastshot->date) . '</td>';
                                echo '<td>' . ($lastshot->clubname) . '</td>';
                            } else {
                                // The classifier has never been shot
                                echo '<td></td>';
                                echo '<td></td>';
                            }

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

<!-- End of main content section -->

<!-- Place any per-page javascript here -->
<script type="text/javascript" src="../users/js/pagination/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#classifiers').DataTable({
            'pageLength': 25,
            "order": [
                [13, "asc"]
            ],

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