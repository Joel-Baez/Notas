<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\ConexionBD;
use PDO;

abstract class RepositorioBase
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = ConexionBD::obtener();
    }
}
