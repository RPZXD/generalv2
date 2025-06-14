<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';

use App\DatabaseGeneral;

class Room
{
    private $db;
    private $table = 'meeting_rooms';

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
        $sql = "SELECT * FROM {$this->table} WHERE status = 1 ORDER BY room_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (room_name, capacity, equipment, status, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $params = [
            $data['room_name'],
            $data['capacity'],
            $data['equipment'] ?? null,
            $data['status'] ?? 1
        ];

        $stmt = $this->db->query($sql, $params);
        return $this->db->getPDO()->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET room_name = ?, capacity = ?, equipment = ?, status = ?, updated_at = NOW() 
                WHERE id = ?";
        
        $params = [
            $data['room_name'],
            $data['capacity'],
            $data['equipment'] ?? null,
            $data['status'] ?? 1,
            $id
        ];

        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        // Check if room has any active bookings first
        $checkSql = "SELECT COUNT(*) FROM bookings WHERE location = ? AND status IN (0,1)";
        $checkStmt = $this->db->query($checkSql, [$id]);
        $bookingCount = $checkStmt->fetchColumn();

        if ($bookingCount > 0) {
            return ['success' => false, 'message' => 'ไม่สามารถลบห้องประชุมที่มีการจองอยู่'];
        }

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return ['success' => $stmt->rowCount() > 0];
    }

    public function isAvailable($roomId, $startTime, $endTime, $excludeBookingId = null)
    {
        $sql = "SELECT COUNT(*) FROM bookings
                WHERE room_id = ?
                AND status IN ('pending', 'approved')
                AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?))";
        
        $params = [$roomId, $startTime, $startTime, $endTime, $endTime];
        
        if ($excludeBookingId) {
            $sql .= " AND id != ?";
            $params[] = $excludeBookingId;
        }

        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchColumn() == 0;
    }
}
?>
