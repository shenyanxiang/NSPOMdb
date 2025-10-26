<?php

require 'db-connect.php';

$query = "SELECT * FROM public.recall_event WHERE micro = $1";
$result = pg_query_params($conn, $query, array($_POST['microbe']));
$rows_res = pg_fetch_all($result);
if ($rows_res === false) {
    echo '<h4>There is no recall event related to <em>' . $_POST['microbe'] . '</em></h4>';
    return;
}
$event_count = pg_num_rows($result);
$length = count($rows_res);
$table_data_list = '\'{"valueNames":["product", "dosage_form", "administration_route", "target_population", "date", "link"],"page":10,"pagination":true}\'';
echo '<h5>Total number of related recall events: &nbsp;&nbsp;<span class="badge badge-phoenix badge-phoenix-primary">'.$event_count.'</span></h5>';
echo '<div id="recallTable" data-list='.$table_data_list.'>';
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-hover table-sm fs--1 mb-0" style="table-layout:fixed;">';
echo '<thead>';
echo '<tr>';
echo '<th class="sort align-middle ps-3" data-sort="product" width="30%">Product description</th>';
echo '<th class="sort align-middle" data-sort="dosage_form" width="20%">Dosage form</th>';
echo '<th class="sort" data-sort="country" width="10%">Country</th>';
echo '<th class="sort" data-sort="product_category" width="20%">Product category</th>';                             
echo '<th class="sort align-middle" data-sort="date" width="10%">Date</th>';
echo '<th class="sort align-middle" width="10%">Link</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody class="list">';
for ($x = 0; $x < $length; $x++) {
    echo '<tr>';
    echo '<td class="align-middle ps-3 product" title="'.$row['product_description'].'" style="overflow:hidden; text-overflow:ellipsis; white-space: nowrap;">' . $rows_res[$x]['product_description'] . '</td>';
    echo '<td class="align-middle dosage_form">' . $rows_res[$x]['dosage_form'] . '</td>';
    echo '<td class="align-middle country">' . $rows_res[$x]['country'] . '</td>';
    echo '<td class="align-middle product_category">' . $rows_res[$x]['product_category'] . '</td>';
    echo '<td class="align-middle date">' . $rows_res[$x]['date'] . '</td>';
    echo '<td class="align-middle link"><a href="' . $rows_res[$x]['link'] . '" target="_blank">Link</a></td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '<div class="d-flex justify-content-center mt-3">';
echo '<button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>';
echo '<ul class="mb-0 pagination"></ul>';
echo '<button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>';
echo '</div>';
echo '</div>';

?>