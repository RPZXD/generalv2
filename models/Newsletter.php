<?php
namespace Models;

use App\DatabaseGeneral;

class Newsletter
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseGeneral();
    }

    public function create($data)
    {
        $sql = "INSERT INTO newsletters (title, news_date, detail, images, create_by, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $params = [
            $data['title'],
            $data['news_date'],
            $data['detail'],
            $data['images'],
            $data['create_by']
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    public function getAll($limit = 100)
    {
        // LIMIT ต้องใส่ใน SQL โดยตรง ไม่ใช้ parameter
        $limit = intval($limit);
        $sql = "SELECT * FROM newsletters ORDER BY news_date DESC, id DESC LIMIT $limit";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM newsletters WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function getByCreateBy($create_by)
    {
        $sql = "SELECT * FROM newsletters WHERE create_by = ? ORDER BY news_date DESC, id DESC";
        $stmt = $this->db->query($sql, [$create_by]);
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM newsletters WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE newsletters SET status = ? WHERE id = ?";
        $stmt = $this->db->query($sql, [$status, $id]);
        return $stmt->rowCount() > 0;
    }

    public function updateStatusAndIssue($id, $status, $issue_no)
    {
        $sql = "UPDATE newsletters SET status = ?, issue_no = ? WHERE id = ?";
        $stmt = $this->db->query($sql, [$status, $issue_no, $id]);
        return $stmt->rowCount() > 0;
    }

    public function update($data)
    {
        $sql = "UPDATE newsletters SET title = ?, news_date = ?, detail = ? WHERE id = ?";
        $params = [
            $data['title'],
            $data['news_date'],
            $data['detail'],
            $data['id']
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }
}
