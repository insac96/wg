<?php
class EventPDO {
  static $PDO_GetAllEvent = "SELECT * FROM ny_event";
  static $PDO_GetEvent = "SELECT * FROM ny_event WHERE id=:id";
  static $PDO_GetEventByType = "SELECT * FROM ny_event WHERE type=:type";
  static $PDO_DeleteEvent = "DELETE FROM ny_event WHERE id=:id";
  static $PDO_DeleteMilestoneOfEvent = "DELETE FROM ny_event_milestone WHERE event_id=:event_id";

  static $PDO_GetAllEventMilestone = "SELECT * FROM ny_event_milestone WHERE event_id=:event_id";
  static $PDO_GetEventMilestone = "SELECT * FROM ny_event_milestone WHERE id=:id";
  static $PDO_GetEventMilestoneByNeed = "SELECT * FROM ny_event_milestone WHERE need=:need AND event_id=:event_id";
  static $PDO_DeleteEventMilestone = "DELETE FROM ny_event_milestone WHERE id=:id";
}