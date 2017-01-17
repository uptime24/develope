<?php

require_once("./global.php");

$row = $db->queryf_result("SELECT COUNT(*) AS count FROM user;");
$smarty->assign('users_count', $row['count']);

$row = $db->queryf_result("SELECT COUNT(*) AS count FROM user
                           WHERE lastupload >= UNIX_TIMESTAMP() - %u",
                           INACTIVE_TIME);
$smarty->assign('users_active', $row['count']);

$row = $db->queryf_result("SELECT AVG(uptime) AS avg_uptime, SUM(uptime) AS sum_uptime
                           FROM current_uptime
                           WHERE lastupload >= UNIX_TIMESTAMP() - %u;", INACTIVE_TIME);
$smarty->assign('avg_uptime', seconds2uptime($row['avg_uptime'], true));
$smarty->assign('sum_uptime', seconds2uptime($row['sum_uptime'], true));

// edit by jens
$res = $db->queryf("SELECT os, COUNT(*) AS count
                    FROM current_uptime
                    WHERE os IS NOT NULL
                    AND lastupload >= UNIX_TIMESTAMP() - %u
                    GROUP BY os
                    ORDER BY count DESC;",  INACTIVE_TIME);

//  Backup, Prozent-Graphen nicht auf aktive beschränken
//
//  $res = $db->queryf("SELECT os, COUNT(*) AS count
// 			FROM current_uptime
// 			WHERE os IS NOT NULL
// 			GROUP BY os
// 			ORDER BY count DESC;");


$os = array();
$max_count = 0;
$sum_count = 0;
while($row = $db->fetch_array($res))
{
  $os[] = $row;
  
  $sum_count += $row['count'];
  if($row['count'] > $max_count)
    $max_count = $row['count'];
}
$db->free_result($res);

foreach($os as $key => $value)
{
  $os[$key]['width'] = round($os[$key]['count'] / $max_count * OS_CHART_MAX_WIDTH);
  $os[$key]['percent'] = round($os[$key]['count'] / $sum_count * 100, 1)."%";
}

$smarty->assign('os', $os);


output_content('stats.tpl');
exit;

?>
