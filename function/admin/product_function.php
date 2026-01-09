<?php

require_once __DIR__ . '/../../config/dbconfig.php';

function GetAllProduct()
{
  try {
    $pdo = db();
    $sql = "SELECT product_tb.*, product_type_tb.product_type_name, event_tb.event_name, event_tb.event_discount
              FROM product_tb
              LEFT JOIN product_type_tb ON product_tb.product_type_id = product_type_tb.product_type_id
              LEFT JOIN event_tb ON product_tb.event_id = event_tb.event_id
              ORDER BY product_tb.product_id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    return [];
  }
}


function AddProduct($product_name, $product_type_id, $product_price, $product_detail, $product_picture, $event_id, $product_qty)
{
  try {
    $pdo = db();

    $sql_ceck = "SELECT COUNT(*) FROM product_tb WHERE product_name = :product_name";
    $stmt_check = $pdo->prepare($sql_ceck);
    $stmt_check->execute(['product_name' => $product_name]);
    if ($stmt_check->fetchColumn() > 0) {
      return false;
    }

    $sql = "INSERT INTO product_tb (product_id, product_name, product_type_id, product_price,product_detail, product_picture, event_id, product_qty, created_at, updated_at) 
            VALUES (:product_id, :product_name, :product_type_id, :product_price, :product_detail, :product_picture, :event_id, :product_qty, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
      ':product_id' => null,
      ':product_name' => $product_name,
      ':product_type_id' => $product_type_id,
      ':product_price' => $product_price,
      ':product_detail' => $product_detail,
      ':product_picture' => $product_picture,
      ':event_id' => $event_id,
      ':product_qty' => $product_qty,
    ]);
  } catch (PDOException $e) {
    // return false;

    die($e->getMessage());
  }
}


function DeleteProduct($id)
{
  $pdo = db();
  try {
    // ดึงชื่อรูปออกมาก่อนลบ Record
    $stmt = $pdo->prepare("SELECT product_picture FROM product_tb WHERE product_id = :id");
    $stmt->execute(['id' => $id]);
    $img = $stmt->fetchColumn();

    $sql = "DELETE FROM product_tb WHERE product_id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(['id' => $id]);

    if ($result && $img) {
      $filePath = __DIR__ . "/../../assets/images/product/" . $img;
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }
    return true;
  } catch (PDOException $e) {
    return false;
    // die($e->getMessage());

  }
}


function EditProduct($product_id, $product_name, $product_type_id, $product_price, $product_detail, $product_picture, $event_id, $product_qty) {
    $pdo = db();
    
    try {
        if ($product_picture) {
            $sql = "UPDATE product_tb 
                    SET product_name = :product_name, 
                        product_type_id = :product_type_id, 
                        product_price = :product_price, 
                        product_detail = :product_detail, 
                        product_picture = :product_picture, 
                        event_id = :event_id,
                        product_qty = :product_qty,
                        updated_at = NOW() 
                    WHERE product_id = :product_id";
        } else {
            $sql = "UPDATE product_tb 
                    SET product_name = :product_name, 
                        product_type_id = :product_type_id, 
                        product_price = :product_price, 
                        product_detail = :product_detail, 
                        event_id = :event_id,
                        product_qty = :product_qty,
                        updated_at = NOW() 
                    WHERE product_id = :product_id";
        }


        $stmt = $pdo->prepare($sql);


        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_type_id', $product_type_id);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_detail', $product_detail);
        $stmt->bindParam(':product_qty', $product_qty);
        

        if ($event_id === "" || $event_id === null) {
            $stmt->bindValue(':event_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':event_id', $event_id);
        }


        if ($product_picture) {
            $stmt->bindParam(':product_picture', $product_picture);
        }


        return $stmt->execute();

    } catch (PDOException $e) {
        // ในขั้นตอนพัฒนา สามารถเปิด die เพื่อดู error ได้
        // die($e->getMessage()); 
        return false;
    }
}