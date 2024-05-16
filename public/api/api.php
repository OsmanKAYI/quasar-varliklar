<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'degiskenler.php';
require_once 'fonksiyonlarim.php';

// "php://input" diyoruz. Çünkü, gelen veri BODY içerisinde JSON objesi olarak geliyor
// Çünkü çağırırken "Content-Type: application/json" olarak belirtiyoruz
$temp = file_get_contents("php://input");
$data = json_decode($temp, true); // true ile json objesini diziye çevirdik
$METHOD = $data['method'];

if ($METHOD <> 'login') {
  list($isVerified, $message) = verifyJWT($mySecretKeyForJwt);

  if (!$isVerified) {
    dieErrorWithJson($message);
  }
}

require_once 'db.php';

$response = []; // Bu API cevap dönerken bu diziyi dönecek
//$response['GELENDATA'] = $data;
$response['success'] = false; // Varsayılan olarak "başarısız" bilgisi dönelim

if (isset($data['search']) and $data['search'] <> '' and $METHOD == 'get-teklifler-limit') {
  $METHOD = 'get-teklifler-search';
}

if (isset($data['search']) and $data['search'] <> '' and $METHOD == 'get-resimler-limit') {
  $METHOD = 'get-resimler-search';
}

switch ($METHOD) {

  case 'login':
    ################################### login ###################################
    $sql = "SELECT id, adisoyadi, eposta 
            FROM kullanicilar 
            WHERE kullaniciadi = :kullaniciadi AND kullanicisifresi = :kullanicisifresi  ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':kullaniciadi',     $data['user']['username']);
    $SORGU->bindParam(':kullanicisifresi', $data['user']['password']);
    $SORGU->execute();
    $userRow = $SORGU->fetch(PDO::FETCH_ASSOC);
    if ($userRow) {
      $response['success'] = true; // İşlem başarılı
      $userID = $userRow['id'];
      unset($userRow['id']); // ID parametresini cevaptan silelim. Yoksa mükerrer bilgi gidecek
      $myToken = generateJWT($userID, $userRow, $mySecretKeyForJwt);
      $response['token'] = $myToken;
    }
    break;

  case 'get-teklifler':
    ################################### getData ###################################
    $start = intval($data['start']);
    $count = intval($data['count']);
    $sql = "SELECT id, firmaadi FROM teklifler ORDER BY id DESC LIMIT $start, $count";
    if ($start == 0 and $count == 0) {
      $sql = "SELECT id, firmaadi FROM teklifler ORDER BY id DESC LIMIT 10";
    }
    $SORGU = $DB->prepare($sql);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'get-teklifler-search':
    ################################### getData ###################################
    $search = trim($data['search']);
    $sql = "SELECT id, firmaadi as 'name', tekliftarihi as 'date', tekliftutari as 'total' 
            FROM teklifler WHERE firmaadi like '%{$search}%' ORDER BY id DESC $myLimit";
    $SORGU = $DB->prepare($sql);
    //$SORGU->bindParam(':search', $search);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'get-teklifler-limit':
    ################################### getData ###################################
    $count = intval($data['count']);
    $myLimit = $count > 0 ? " LIMIT $count" : "";
    $sql = "SELECT id, firmaadi as 'name', tekliftarihi as 'date', tekliftutari as 'total' 
              FROM teklifler ORDER BY id DESC $myLimit";
    $SORGU = $DB->prepare($sql);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'get-teklif':
    ################################### getData ###################################
    $sql = "SELECT * FROM teklifler WHERE id = :id";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $data['id']);
    $SORGU->execute();
    $row = $SORGU->fetch(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['item'] = $row;
    break;

  case 'get-teklif-kalemleri':
    ################################### getData ###################################
    $sql = "SELECT K.*, R.resimadi FROM kalemler K, resimler R WHERE K.teklifno = :id AND K.resimid = R.id";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $data['id']);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'get-resimler-limit':
    ################################### getData ###################################
    $start = intval($data['start']);
    $count = intval($data['count']);
    $sql = "SELECT id, aciklama, resimadi FROM resimler WHERE silindi = 0 ORDER BY id DESC LIMIT $start, $count";
    if ($start == 0 and $count == 0) {
      $sql = "SELECT id, aciklama, resimadi FROM resimler WHERE silindi = 0 LIMIT 10";
    }
    $SORGU = $DB->prepare($sql);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'get-resimler-search':
    ################################### getData ###################################
    $search = trim($data['search']);
    $count = intval($data['count']);
    $myLimit = $count > 0 ? " LIMIT $count" : "";
    $sql = "SELECT id, aciklama, resimadi FROM resimler 
            WHERE silindi = 0 AND aciklama like '%{$search}%' ORDER BY id DESC LIMIT 15";
    $SORGU = $DB->prepare($sql);
    //$SORGU->bindParam(':search', $search);
    $SORGU->execute();
    $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true; // İşlem başarılı
    $response['items'] = $rows;
    break;

  case 'rotate':
    ################################### rotate ###################################
    $degree = intval($data['degree']);
    $id     = intval($data['id']);
    $SORGU = $DB->prepare("SELECT * FROM resimler WHERE id = :id AND silindi = 0");
    $SORGU->bindParam(":id", $id);
    $SORGU->execute();
    $RESIM = $SORGU->fetch();
    if ($SORGU->rowCount() > 0) {
      require_once(__DIR__ . "/class.simpleimage.php");
      $ResimPath = __DIR__ . "/../resimler/{$RESIM['resimadi']}";
      $image = new SimpleImage();
      $image->load($ResimPath);
      $image->rotate($degree); // Dikkat! Yazma yetkisi var mı? `chmod -R 777 resimler/`
      $image->save($ResimPath);
      $image->resizeToWidth(350);
      $image->save(__DIR__ . "/../resimler/pul_{$RESIM['resimadi']}");
      $response['success'] = true; // İşlem başarılı
      // $response['ResimAdi'] = $ResimPath;
    }
    break;

  case 'delete-image':
    ################################### delete-image ###################################
    $id     = intval($data['id']);
    $SORGU = $DB->prepare("SELECT * FROM resimler WHERE id = :id AND silindi = 0 AND id not in (SELECT resimid FROM kalemler WHERE resimid = :id)");
    $SORGU->bindParam(":id", $id);
    $SORGU->execute();
    $RESIM = $SORGU->fetch();
    if ($SORGU->rowCount() > 0) {
      $SORGU = $DB->prepare("UPDATE resimler SET silindi = 1 WHERE id = :id");
      $SORGU->bindParam(":id", $id);
      $SORGU->execute();
      $response['success'] = true; // İşlem başarılı
    }
    break;

  case 'change-item-image':
    ############################### change-item-image ###############################
    $itemId     = intval($data['itemId']);
    $yeniResimId = intval($data['yeniResimId']);
    $SORGU = $DB->prepare("UPDATE kalemler SET resimid = :yeniResimId WHERE id = :itemId");
    $SORGU->bindParam(":itemId",      $itemId);
    $SORGU->bindParam(":yeniResimId", $yeniResimId);
    $SORGU->execute();
    $response['success'] = true; // İşlem başarılı
    break;

  default:
    ################################### default ###################################
    $response['error'] = "`method` adı geçerli değil";
    if (!isset($data['methode'])) {
      $response['error'] = "`method` parametresi bulunamadı";
    }
} // switch

// http_response_code(200);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
