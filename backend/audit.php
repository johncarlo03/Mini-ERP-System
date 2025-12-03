<?php

include "../../db.php";

// $audit_logs = "SELECT id, user_id, action, date_time FROM audit_logs ORDER BY date_time ASC";
$audit_logs = "SELECT a.id, a.action, u.name, a.date_time FROM 
                audit_logs a 
                JOIN USERS u ON a.user_id = u.id
                ORDER BY a.date_time DESC";
$logs = $conn->query($audit_logs)->fetchAll();


?>
