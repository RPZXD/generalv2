<?php
namespace Models;

require_once __DIR__ . '/../classes/DatabaseGeneral.php';

use App\DatabaseGeneral;
use PDO;

class Booking
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseGeneral();
    }

    public function insert($data)
    {
        // Handle custom room layout
        $roomLayout = $data['room_layout'] ?? 'none';
        if ($roomLayout === 'other' && !empty($data['room_layout_custom'])) {
            $roomLayout = 'custom:' . $data['room_layout_custom'];
        }
        
        // ใช้ room_id ถ้ามี หรือใช้ location เดิม
        $hasRoomId = !empty($data['room_id']);
        
        if ($hasRoomId) {
            $sql = "INSERT INTO bookings (
                teach_id, term, pee, date, time_start, time_end, purpose, room_id, location, media, phone, room_layout, status, created_at
            ) VALUES (
                :teach_id, :term, :pee, :date, :time_start, :time_end, :purpose, :room_id, :location, :media, :phone, :room_layout, :status, NOW()
            )";
            $params = [
                'teach_id' => $data['teach_id'],
                'term' => $data['term'],
                'pee' => $data['pee'],
                'date' => $data['date'],
                'time_start' => $data['time_start'],
                'time_end' => $data['time_end'],
                'purpose' => $data['purpose'],
                'room_id' => $data['room_id'],
                'location' => $data['location'], // เก็บชื่อห้องไว้ด้วยเพื่อความเข้ากันได้
                'media' => $data['media'] ?? '',
                'phone' => $data['phone'] ?? '',
                'room_layout' => $roomLayout,
                'status' => $data['status'] ?? 0
            ];
        } else {
            $sql = "INSERT INTO bookings (
                teach_id, term, pee, date, time_start, time_end, purpose, location, media, phone, room_layout, status, created_at
            ) VALUES (
                :teach_id, :term, :pee, :date, :time_start, :time_end, :purpose, :location, :media, :phone, :room_layout, :status, NOW()
            )";
            $params = [
                'teach_id' => $data['teach_id'],
                'term' => $data['term'],
                'pee' => $data['pee'],
                'date' => $data['date'],
                'time_start' => $data['time_start'],
                'time_end' => $data['time_end'],
                'purpose' => $data['purpose'],
                'location' => $data['location'],
                'media' => $data['media'] ?? '',
                'phone' => $data['phone'] ?? '',
                'room_layout' => $roomLayout,
                'status' => $data['status'] ?? 0
            ];
        }
        // DEBUG
        // error_log("SQL: " . $sql);
        // error_log("Params: " . json_encode($params));
        
        try {
            $stmt = $this->db->query($sql, $params);
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            $params_str = json_encode($params, JSON_UNESCAPED_UNICODE);
            throw new \Exception($e->getMessage() . " | SQL: " . $sql . " | Params: " . $params_str);
        }
    }

    public function getByTeacher($teach_id, $term = null, $pee = null)
    {
        $params = ['teach_id' => $teach_id];
        $where = "b.teach_id = :teach_id";
        if ($term !== null && $pee !== null) {
            $where .= " AND b.term = :term AND b.pee = :pee";
            $params['term'] = $term;
            $params['pee'] = $pee;
        }
        $sql = "SELECT b.*, 
                       m.room_name as room_name_from_db,
                       m.emoji as room_emoji,
                       m.color as room_color,
                       m.capacity as room_capacity,
                       m.building as room_building
                FROM bookings b
                LEFT JOIN meeting_rooms m ON b.room_id = m.id
                WHERE $where 
                ORDER BY b.date DESC, b.time_start DESC";
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT b.*, 
                       m.room_name as room_name_from_db,
                       m.emoji as room_emoji,
                       m.color as room_color,
                       m.capacity as room_capacity,
                       m.building as room_building
                FROM bookings b
                LEFT JOIN meeting_rooms m ON b.room_id = m.id
                WHERE b.id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data, $teacher_id = null)
    {
        $whereClause = "id = :id";
        $params = ['id' => $data['id']];
        
        if ($teacher_id) {
            $whereClause .= " AND teach_id = :teach_id";
            $params['teach_id'] = $teacher_id;
        }

        // Handle custom room layout
        $roomLayout = $data['room_layout'] ?? 'none';
        if ($roomLayout === 'other' && !empty($data['room_layout_custom'])) {
            $roomLayout = 'custom:' . $data['room_layout_custom'];
        }

        // ใช้ room_id ถ้ามี
        $hasRoomId = !empty($data['room_id']);
        
        if ($hasRoomId) {
            $sql = "UPDATE bookings SET 
                date = :date, time_start = :time_start, time_end = :time_end,
                purpose = :purpose, room_id = :room_id, location = :location, media = :media, phone = :phone, room_layout = :room_layout
                WHERE $whereClause";

            $updateParams = array_merge($params, [
                'date' => $data['date'],
                'time_start' => $data['time_start'],
                'time_end' => $data['time_end'],
                'purpose' => $data['purpose'],
                'room_id' => $data['room_id'],
                'location' => $data['location'],
                'media' => $data['media'] ?? '',
                'phone' => $data['phone'] ?? '',
                'room_layout' => $roomLayout
            ]);
        } else {
            $sql = "UPDATE bookings SET 
                date = :date, time_start = :time_start, time_end = :time_end,
                purpose = :purpose, location = :location, media = :media, phone = :phone, room_layout = :room_layout
                WHERE $whereClause";

            $updateParams = array_merge($params, [
                'date' => $data['date'],
                'time_start' => $data['time_start'],
                'time_end' => $data['time_end'],
                'purpose' => $data['purpose'],
                'location' => $data['location'],
                'media' => $data['media'] ?? '',
                'phone' => $data['phone'] ?? '',
                'room_layout' => $roomLayout
            ]);
        }

        $stmt = $this->db->query($sql, $updateParams);
        return $stmt->rowCount() > 0;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function checkAvailability($date, $time_start, $time_end, $location, $exclude_id = null, $room_id = null)
    {
        // ถ้ามี room_id ให้ใช้ room_id ในการตรวจสอบ (แม่นยำกว่า)
        if ($room_id) {
            $sql = "SELECT COUNT(*) as count FROM bookings 
                    WHERE date = :date AND room_id = :room_id AND status != 2
                    AND (
                        (time_start < :time_end AND time_end > :time_start)
                    )";
            $params = [
                'date' => $date,
                'time_start' => $time_start,
                'time_end' => $time_end,
                'room_id' => $room_id
            ];
        } else {
            $sql = "SELECT COUNT(*) as count FROM bookings 
                    WHERE date = :date AND location = :location AND status != 2
                    AND (
                        (time_start < :time_end AND time_end > :time_start)
                    )";
            $params = [
                'date' => $date,
                'time_start' => $time_start,
                'time_end' => $time_end,
                'location' => $location
            ];
        }

        if ($exclude_id) {
            $sql .= " AND id != :exclude_id";
            $params['exclude_id'] = $exclude_id;
        }

        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE bookings SET status = :status WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id, 'status' => $status]);
        return $stmt->rowCount() > 0;
    }
}
