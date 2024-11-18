<?php

namespace src\core;

use mysqli;
use Exception;

class DB
{
    private $dbType = null;
    private $db = null;
    private $stmt = null;

    public function __construct($dbType = 'master') {
        $this->dbType = $dbType;
    }

    public function getDb() {
        if($this->db === null) {
            $this->db = $this->connect();
        }

        return $this->db;
    }

    public function prepare($sql) {
        if($this->db === null) {
            $this->db = $this->connect();
        }

        if(empty($this->db)) {
            throw new Exception('DB connection failed');
        }

        $this->stmt = $this->db->prepare($sql);
        return $this->stmt;
    }

    public function stmt_bind_param($valType, $val) {
        if($this->stmt === null) {
            throw new Exception('stmt is null');
        }

        $val = is_array($val) ? $val : [$val];

        // 파라미터를 참조 형태로 배열에 추가
        $bindNames[] = $valType; // 첫 번째 요소는 타입 문자열
        foreach ($val as $key => $value) {
            $bindNames[] = $value; // 파라미터를 참조로 추가
        }
        
		return $this->stmt->bind_param(...$bindNames);
    }

    public function stmt_execute($returnType) {
        if($this->stmt === null) {
            throw new Exception('stmt is null');
        }

	    $success = $this->stmt->execute();
		if (!$success) {
			$this->stmt->close();
			return false;
		}

	    switch ($returnType) {
			case 'insert':
			case 'update':
			case 'delete':
				$affectedRows = $this->stmt->affected_rows;
				$insertId = ($returnType === 'insert') ? $this->stmt->insert_id : null;
				return [
					'success' => $success,
					'affectedRows' => $affectedRows,
					'insertId' => $insertId
				];
				break;

            case 'all':
				$result = $this->stmt->get_result();
                $result = $result->fetch_all(MYSQLI_ASSOC);
                break;

            case 'row':
				$result = $this->stmt->get_result();
                $result = $result->fetch_assoc();
                break;

            default:
                throw new Exception("Invalid return type: $returnType");
        }

	    $this->stmt->close();
	    return $result;
    }

    private function connect() {
        $databaseConfig = include CONFIG_PATH . '/database.php';

        $host = $databaseConfig[$this->dbType]['host'];
        $user = $databaseConfig[$this->dbType]['user'];
        $password = $databaseConfig[$this->dbType]['password'];
        $database = $databaseConfig[$this->dbType]['database'];
        $port = $databaseConfig[$this->dbType]['port'];

		return new mysqli($host, $user, $password, $database, $port);
	}
}