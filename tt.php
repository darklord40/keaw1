<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$tracking_no = isset($_GET['tracking_no']) ? $_GET['tracking_no'] : '';
$complaint = null;
$error = '';

if($tracking_no) {
    try {
        // Query ง่ายๆ ก่อน
        $sql = "SELECT * FROM complaints WHERE tracking_no = :tracking_no";
        $stmt = $db->prepare($sql);
        $stmt->execute([':tracking_no' => $tracking_no]);
        
        if($stmt->rowCount() > 0) {
            $complaint = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error = "ไม่พบข้อมูล";
        }
    } catch(Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ติดตามสถานะ</title>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Prompt', sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .error { color: red; background: #ffeeee; padding: 10px; border-radius: 5px; }
        .info { background: #f5f5f5; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ติดตามสถานะการแจ้งซ่อม</h1>
        
        <form method="GET">
            <input type="text" name="tracking_no" value="<?php echo htmlspecialchars($tracking_no); ?>" 
                   placeholder="กรอกหมายเลขติดตาม" style="width: 70%; padding: 10px;">
            <button type="submit" style="padding: 10px 20px;">ค้นหา</button>
        </form>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($complaint): ?>
            <div class="card">
                <h2>รายละเอียดการแจ้งซ่อม</h2>
                <div class="info">
                    <p><strong>หมายเลขติดตาม:</strong> <?php echo $complaint['tracking_no']; ?></p>
                    <p><strong>หัวข้อ:</strong> <?php echo $complaint['title']; ?></p>
                    <p><strong>รายละเอียด:</strong> <?php echo nl2br($complaint['description']); ?></p>
                    <p><strong>สถานะ:</strong> 
                        <span style="background: <?php 
                            echo $complaint['status'] == 'เสร็จสิ้น' ? 'green' : 
                                ($complaint['status'] == 'กำลังดำเนินการ' ? 'orange' : 'gray'); 
                        ?>; color: white; padding: 5px 10px; border-radius: 5px;">
                            <?php echo $complaint['status']; ?>
                        </span>
                    </p>
                    <p><strong>วันที่แจ้ง:</strong> <?php echo $complaint['created_at']; ?></p>
                </div>
            </div>
        <?php elseif($tracking_no): ?>
            <p>ไม่พบข้อมูลหมายเลข: <?php echo htmlspecialchars($tracking_no); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>