<?php
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=awardData.csv');
header('Pragma: no-cache');
readfile("/nfs/stak/students/l/lozadas/public_html/CS-419-Project/419-online/tmp-export.csv");
?>
