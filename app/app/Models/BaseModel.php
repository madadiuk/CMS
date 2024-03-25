<?php

namespace App\Models;

use App\Config; // Assuming your database configuration is under this namespace

abstract class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Config\getDatabaseConnection();
    }
}

