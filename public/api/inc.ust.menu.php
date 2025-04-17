<?php
require_once 'degiskenler.php';
require_once 'fonksiyonlarim.php';
require_once 'db.php';

function fetchSubMenu($DB, $parent_id)
{
  $sql_sub = "SELECT id, page_name, page_slug FROM web_pages WHERE parent_id = :parent_id ORDER BY sort_order";
  $SORGU_sub = $DB->prepare($sql_sub);
  $SORGU_sub->bindParam(':parent_id', $parent_id);
  $SORGU_sub->execute();
  return $SORGU_sub->fetchAll(PDO::FETCH_ASSOC);
}

// Üst menüleri sorgula
$sql = "SELECT id, page_name, page_slug, parent_id FROM web_pages WHERE parent_id = 0 ORDER BY sort_order";
$SORGU = $DB->prepare($sql);
$SORGU->execute();
$topRows = $SORGU->fetchAll(PDO::FETCH_ASSOC);

$topMenuItems = array();

foreach ($topRows as $topMenuRow) {
  $topMenu = array(
    "page_name" => $topMenuRow["page_name"],
    "page_slug" => $topMenuRow["page_slug"],
    "sub_menu" => fetchSubMenu($DB, $topMenuRow["id"])
  );

  array_push($topMenuItems, $topMenu);
}

// Bu noktaya geldiğimizde,
// $topMenuItems değişkeni istediğimiz cevabı içeriyordur.
