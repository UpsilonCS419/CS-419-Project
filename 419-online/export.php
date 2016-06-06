<?php
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=awardData.csv');
header('Pragma: no-cache');
readfile("/nfs/stak/students/h/hengs/public_html/wiki/docs/CS419FinalProject/tmp-export.csv");
?>
