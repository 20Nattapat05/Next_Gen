<?php

require_once __DIR__ . '/../../config/dbconfig.php';


function CheckEvent($event_name)
{

  try {
    $pdo = db();
    $sql = "SELECT COUNT(*) FROM event_tb WHERE event_name = :event_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      'event_name' => $event_name
    ]);
    return $stmt->fetchColumn() > 0;
  } catch (PDOException $e) {
    return false;
  }
}


function GetAllEvents()
{

  try {
    $pdo = db();
    $sql = "SELECT event_tb.*, COUNT(product_tb.product_id) AS total_products 
                FROM event_tb
                LEFT JOIN product_tb ON event_tb.event_id = product_tb.event_id
                GROUP BY event_tb.event_id
                ORDER BY event_tb.event_id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    return [];
  }
}


function AddEvent($event_name, $event_discount)
{

  try {
    $pdo = db();
    $sql = "INSERT INTO event_tb (event_id, event_name, event_discount, created_at, updated_at) 
            VALUES (:event_id, :event_name, :event_discount, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
      ':event_id' => null,
      ':event_name' => $event_name,
      ':event_discount' => $event_discount
    ]);
  } catch (PDOException $e) {
    return false;
  }
}


function DeleteEvent($event_id)
{

  try {
    $pdo = db();
    $sql = "DELETE FROM event_tb WHERE event_id = :event_id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':event_id' => $event_id]);
  } catch (PDOException $e) {
    return false;
  }
}
