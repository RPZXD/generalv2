<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';

use App\DatabaseGeneral;

class Car
{
    private $db;
    private $table = 'cars';

    public function __construct()
    {
        $this->db = new DatabaseGeneral();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 1 ORDER BY car_model";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        // Check if license plate already exists
        if ($this->licensePlateExists($data['license_plate'])) {
            return ['success' => false, 'message' => 'ทะเบียนรถนี้มีอยู่ในระบบแล้ว'];
        }

        $sql = "INSERT INTO {$this->table} (car_model, license_plate, car_type, capacity, status, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $params = [
            $data['car_model'],
            $data['license_plate'],
            $data['car_type'],
            $data['capacity'],
            $data['status'] ?? 1
        ];

        $stmt = $this->db->query($sql, $params);
        return ['success' => true, 'id' => $this->db->getPDO()->lastInsertId()];
    }

    public function update($id, $data)
    {
        // Check if license plate already exists (excluding current car)
        if ($this->licensePlateExists($data['license_plate'], $id)) {
            return ['success' => false, 'message' => 'ทะเบียนรถนี้มีอยู่ในระบบแล้ว'];
        }

        $sql = "UPDATE {$this->table} 
                SET car_model = ?, license_plate = ?, car_type = ?, capacity = ?, status = ?, updated_at = NOW() 
                WHERE id = ?";
        
        $params = [
            $data['car_model'],
            $data['license_plate'],
            $data['car_type'],
            $data['capacity'],
            $data['status'] ?? 1,
            $id
        ];

        $stmt = $this->db->query($sql, $params);
        return ['success' => $stmt->rowCount() > 0];
    }

    public function delete($id)
    {
        // Check if car has any bookings first
        $checkSql = "SELECT COUNT(*) FROM car_bookings WHERE car_id = ?";
        $checkStmt = $this->db->query($checkSql, [$id]);
        $bookingCount = $checkStmt->fetchColumn();

        if ($bookingCount > 0) {
            return ['success' => false, 'message' => 'ไม่สามารถลบรถที่มีการจองแล้ว'];
        }

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return ['success' => $stmt->rowCount() > 0];
    }

    public function isAvailable($carId, $startTime, $endTime, $excludeBookingId = null)
    {
        $sql = "SELECT COUNT(*) FROM car_bookings 
                WHERE car_id = ? 
                AND status IN ('pending', 'approved')
                AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?))";
        
        $params = [$carId, $startTime, $startTime, $endTime, $endTime];
        
        if ($excludeBookingId) {
            $sql .= " AND id != ?";
            $params[] = $excludeBookingId;
        }

        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchColumn() == 0;
    }

    private function licensePlateExists($licensePlate, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE license_plate = ?";
        $params = [$licensePlate];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchColumn() > 0;
    }
}
?>
