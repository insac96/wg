<?php
class EventPDO {
  static $PDO_GetAllEvent = "SELECT * FROM ny_event WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetEvent = "SELECT * FROM ny_event WHERE display='1' AND id=:id";

  static $PDO_GetAllMilestone = "SELECT * FROM ny_event_milestone WHERE event_id=:event_id ORDER BY need ASC";
  static $PDO_GetMilestone = "SELECT * FROM ny_event_milestone WHERE id=:id";
  
  static $PDO_GetLogEvent = "SELECT 
    id, create_time 
    FROM ny_log_event 
    WHERE account=:account 
    AND event_id=:event_id 
    AND milestone_id=:milestone_id 
    ORDER BY create_time DESC 
    LIMIT 1
  ";
}