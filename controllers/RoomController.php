<?php
require_once __DIR__ . '/../models/Room.php';

class RoomController
{
    private $roomModel;

    public function __construct()
    {
        $this->roomModel = new Room();
    }

    public function getAllRooms()
    {
        try {
            $rooms = $this->roomModel->getAll();
            return [
                'success' => true,
                'rooms' => $rooms
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลห้องประชุม: ' . $e->getMessage()
            ];
        }
    }

    public function getActiveRooms()
    {
        try {
            $rooms = $this->roomModel->getActive();
            return [
                'success' => true,
                'rooms' => $rooms
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลห้องประชุม: ' . $e->getMessage()
            ];
        }
    }

    public function saveRoom($data)
    {
        try {
            // Validate required fields
            if (empty($data['room_name']) || empty($data['capacity'])) {
                return [
                    'success' => false,
                    'message' => 'กรุณากรอกข้อมูลที่จำเป็น'
                ];
            }

            // Validate capacity
            if (!is_numeric($data['capacity']) || $data['capacity'] < 1 || $data['capacity'] > 500) {
                return [
                    'success' => false,
                    'message' => 'ความจุต้องเป็นตัวเลขระหว่าง 1-500 คน'
                ];
            }

            if (!empty($data['room_id'])) {
                // Update existing room
                $result = $this->roomModel->update($data['room_id'], $data);
                if ($result > 0) {
                    return [
                        'success' => true,
                        'message' => 'อัปเดตข้อมูลห้องประชุมเรียบร้อยแล้ว'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'ไม่พบห้องประชุมที่ต้องการแก้ไข'
                    ];
                }
            } else {
                // Create new room
                $roomId = $this->roomModel->create($data);
                if ($roomId) {
                    return [
                        'success' => true,
                        'message' => 'เพิ่มห้องประชุมเรียบร้อยแล้ว',
                        'room_id' => $roomId
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'เกิดข้อผิดพลาดในการเพิ่มห้องประชุม'
                    ];
                }
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ];
        }
    }

    public function deleteRoom($id)
    {
        try {
            if (empty($id)) {
                return [
                    'success' => false,
                    'message' => 'ไม่พบรหัสห้องประชุม'
                ];
            }

            $result = $this->roomModel->delete($id);
            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบห้องประชุม: ' . $e->getMessage()
            ];
        }
    }
}
?>
