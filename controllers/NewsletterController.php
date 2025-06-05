<?php
namespace Controllers;

require_once __DIR__ . '/../models/Newsletter.php';

use Models\Newsletter;

class NewsletterController
{
    private $model;

    public function __construct()
    {
        $this->model = new Newsletter();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getAll($limit = 20)
    {
        return $this->model->getAll($limit);
    }

    public function getById($id)
    {
        return $this->model->getById($id);
    }

    public function getByCreateBy($create_by)
    {
        return $this->model->getByCreateBy($create_by);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function updateStatus($id, $status)
    {
        return $this->model->updateStatus($id, $status);
    }

    public function updateStatusAndIssue($id, $status, $issue_no)
    {
        return $this->model->updateStatusAndIssue($id, $status, $issue_no);
    }

    public function update($data)
    {
        return $this->model->update($data);
    }
}
