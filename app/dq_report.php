<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

$dqsLog = $db->query("SELECT * from ccs_dq_log where date > now() - INTERVAL 12 month")->results();

$dqsPerson = $db->query('SELECT lname,fname, count(id) as count from ccs_dq_log where date > now() - INTERVAL 12 month  group by lname, fname HAVING count > 1 order by count desc')->results();
// $dqsPerson = $db->query('SELECT lname,fname, count(id) as count from ccs_dq_log where date > now() - INTERVAL 36 month  group by lname, fname  order by count desc')->results();
$dqsType = $db->query('SELECT rule,reason, count(id) as count from ccs_dq_log where date > now() - INTERVAL 12 month group by rule, reason order by count desc')->results();
$dqsChart = $db->query('SELECT rule, count(id) as count from ccs_dq_log where date > now() - INTERVAL 12 month group by rule order by count desc LIMIT 10')->results();
$dqsClub = $db->query('SELECT club, count(id) as count from ccs_dq_log where date > now() - INTERVAL 12 month group by club order by count desc')->results();

?>
<br>
<div class='row'>
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <h2><strong>DQ by Type</strong></h2>
                <br>
                <h6 class="card-subtitle text-muted">Previous 12 months</h6>
            </div>
            <div class="card-body">
                <table id="dqType" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th class='searchable'>Rule</th>
                            <th class='searchable'>Reason</th>
                            <th class='searchable'>count</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($dqsType as $dq) {
                            echo "<tr>";
                            echo "<td>$dq->rule</td>";
                            echo "<td>$dq->reason</td>";
                            echo "<td>$dq->count</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
    <div class="col-6">

        <div class="card card-default">
            <div class="card-header">
                <h2><strong>DQ by Person</strong></h2>
                <br>
                <h6 class="card-subtitle text-muted">Previous 12 months and more than 1 DQ</h6>
            </div>
            <div class="card-body">

                <table id="dqPerson" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th class='searchable'>First</th>
                            <th class='searchable'>Last</th>
                            <th class='searchable'>count</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($dqsPerson as $dq) {
                            echo "<tr>";
                            echo "<td>$dq->fname</td>";
                            echo "<td>$dq->lname</td>";
                            echo "<td>$dq->count</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
</div>
<div class='row'>
    <div class="col-6">

        <div class="card card-default">
            <div class="card-header">
                <h2><strong>Top 10 DQ by Type</strong></h2>
                <br>
                <h6 class="card-subtitle text-muted">Previous 12 months</h6>

            </div>
            <div class="card-body">
                <?php
                createChart($dqsChart, ['type' => 'bar', 'height' => '500']);
                ?>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
    <div class="col-6">

        <div class="card card-default">
            <div class="card-header">
                <h2><strong>DQ by Club</strong></h2>
                <br>
                <h6 class="card-subtitle text-muted">Previous 12 months</h6>

            </div>
            <div class="card-body">
                <?php
                createChart($dqsClub, ['type' => 'bar', 'height' => '500']);
                ?>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
</div>
<div class="row">
    <div class='col-12'>
        <div class="card card-default">
            <div class="card-header">
                <h2><strong>Section DQ Report</strong></h2>
                <br>
                <h6 class="card-subtitle text-muted">Previous 12 months</h6>
            </div>
            <div class="card-body">

                <table id="dqLog" class="table table-striped table-bordered table-sm display dataTable" style=" width:100%">
                    <thead>
                        <tr>
                            <th class='searchable'>Date</th>
                            <th class='searchable'>Club</th>
                            <th class='searchable'>First Name</th>
                            <th class='searchable'>Last Name</th>
                            <th class='searchable'>USPSA Number</th>

                            <th class='searchable'>Stage</th>
                            <th class='searchable'>Rule</th>
                            <th class='searchable'>Reason</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($dqsLog as $dq) {
                            echo "<tr>";
                            echo "<td>$dq->date</td>";
                            echo "<td>$dq->club</td>";
                            echo "<td>$dq->fname</td>";
                            echo "<td>$dq->lname</td>";
                            echo "<td>$dq->number</td>";

                            echo "<td>$dq->stage</td>";
                            echo "<td>$dq->rule</td>";
                            echo "<td>$dq->reason</td>";
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
        $('#dqLog').DataTable({
            'pageLength': 25,
            "order": [
                [0, "desc"]
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