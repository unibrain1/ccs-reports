<?php

require_once '../users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';

include_once $abs_us_root . $us_url_root . 'points/include/functions.php';

$current_season = $db->query("SELECT current FROM points_currentseason")->results()[0]->current;
$matches = $db->query("SELECT * FROM points_matches WHERE season = ? ORDER BY date ASC", [$current_season])->results();

?>
<div id='page-wrapper'>
    <!-- Page Content -->
    <div class='container-fluid'>
        <div class='row'>
            <div class='col'>
                <div class='card-block'>
                    <div class='card-header'>
                        <h2 align="center">Matches in Current Season</h2>
                    </div>
                    <div class='card-body'>

                        <table id="schedule" class="table table-hover table-striped table-bordered table-responsive-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope=column style="white-space-trim: nowrap; width: 1%;">id</th>
                                    <th scope=column style="white-space-trim: nowrap; width: 1%;">Quarter</th>
                                    <th scope=column style="white-space-trim: nowrap; width: 1%;">Match</th>
                                    <th scope=column>Location</th>
                                    <th scope=column>Date</th>

                                    <th scope=column>Pistol</th>
                                    <th scope=column>PCC</th>
                                    <th scope=column>Count</th>
                                    <th scope=column>Upload</th>
                                    <th scope=column>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($matches as $match) {

                                    $matchurl = guidturl($match->guid);

                                ?>
                                    <form method="post" id="editMatch" name="editMatch" action="actions/_matches.php" enctype="multipart/form-data" novalidate>
                                        <input type="hidden" name="csrf" id="csrf" value="<?= Token::generate(); ?>" />
                                        <input type="hidden" name="id" id="id" value="<?= $match->id ?>" />
                                        <input type="hidden" name="pistol" id="pistol" value="<?= $match->pistol ?>" />
                                        <input type="hidden" name="pcc" id="pcc" value="<?= $match->pcc ?>" />

                                        <tr>
                                            <td><?= $match->id  ?></td>
                                            <td><?= $match->quarter  ?></td>
                                            <td><?= $match->matchid  ?></td>
                                            <td><?= $match->location  ?></td>
                                            <td><?= date_format(date_create($match->date), 'D: M, d Y')  ?></td>
                                            <?php
                                            if ($match->pistol) {
                                            ?>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="pistol" checked>
                                                        <label class="form-check-label" for="pistol">
                                                            Pistol
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="pistol">
                                                        <label class="form-check-label" for="pistol">
                                                            Pistol
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php
                                            }
                                            if ($match->pcc) {
                                            ?>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="pcc" checked>
                                                        <label class="form-check-label" for="pcc">
                                                            PCC
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="pcc">
                                                        <label class="form-check-label" for="pcc">
                                                            PCC
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php
                                            }

                                            $q = "SELECT count(*) as count FROM points_results WHERE guid = ?";
                                            $count = $db->query($q, [$match->guid]);

                                            if ($count->count()) {
                                                echo '<td>' . $count->results()[0]->count . '</td>';
                                            } else {
                                                echo '<td></td>';
                                            }
                                            ?>
                                            <td>
                                                <button type="submit" name="action" value="upload" class="btn btn-warning">Upload</button>
                                                <input type="text" class="form-control" name="matchurl" id="matchurl" placeholder="<?= $matchurl ?>" value="<?= $matchurl ?>">
                                            </td>
                                            <td>
                                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm ">Delete</button>
                                            </td>
                                        </tr>
                                    </form>

                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>