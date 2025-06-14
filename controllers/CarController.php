<?php
require_once __DIR__ . '/../models/Car.php';

class CarController
{
    private $carModel;

    public function __construct()
    {
        $this->carModel = new Car();
    }

    public function getAllCars()
    {
        try {
            $cars = $this->carModel->getAll();
            return [
                'success' => true,
                'cars' => $cars
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลรถยนต์: ' . $e->getMessage()
            ];
        }
    }

    public function getActiveCars()
    {
        try {
            $cars = $this->carModel->getActive();
            return [
                'success' => true,
                'cars' => $cars
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลรถยนต์: ' . $e->getMessage()
            ];
        }
    }

    public function saveCar($data)
    {
        try {
            // Validate required fields
            $requiredFields = ['car_model', 'license_plate', 'car_type', 'capacity'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return [
                        'success' => false,
                        'message' => 'กรุณากรอกข้อมูลที่จำเป็น'
                    ];
                }
            }

            // Validate capacity
            if (!is_numeric($data['capacity']) || $data['capacity'] < 1 || $data['capacity'] > 50) {
                return [
                    'success' => false,
                    'message' => 'ความจุต้องเป็นตัวเลขระหว่าง 1-50 คน'
                ];
            }

            // Validate car type
            $validTypes = ['รถเก๋ง', 'รถตู้', 'รถกระบะ', 'รถบัส'];
            if (!in_array($data['car_type'], $validTypes)) {
                return [
                    'success' => false,
                    'message' => 'ประเภทรถไม่ถูกต้อง'
                ];
            }

            if (!empty($data['car_id'])) {
                // Update existing car
                $result = $this->carModel->update($data['car_id'], $data);
                return $result;
            } else {
                // Create new car
                $result = $this->carModel->create($data);
                return $result;
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ];
        }
    }

    public function deleteCar($id)
    {
        try {
            if (empty($id)) {
                return [
                    'success' => false,
                    'message' => 'ไม่พบรหัสรถยนต์'
                ];
            }

            $result = $this->carModel->delete($id);
            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบรถยนต์: ' . $e->getMessage()
            ];
        }
    }
}
?>
