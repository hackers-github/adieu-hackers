<?php

class DB
{
    private $dbType = null;
    private $db = null;
    private $stmt = null;

    private $host = [
        'master' => [
            'host' => 'adieu2024.cluster-c26rhbuz6osw.ap-northeast-2.rds.amazonaws.com',
            'user' => 'web_adieuhackers',
            'password' => 'hacdkeb2024!!',
            'database' => 'adieu2024',
            'port' => '3306',
        ],
        'slave' => [
            'host' => 'adieu2024.cluster-ro-c26rhbuz6osw.ap-northeast-2.rds.amazonaws.com',
            'user' => 'web_adieuhackers',
            'password' => 'hacdkeb2024!!',
            'database' => 'adieu2024',
            'port' => '3306',
        ],
        'hacademia' => [
            'host' => '10.100.15.45',
            'user' => 'hacademia15',
            'password' => 'djgkrdnjs2015',
            'database' => 'hacademia',
            'port' => '3338',
        ],
    ];

    public function __construct($dbType = 'master') {
        $this->dbType = $dbType;
    }

    public function getDb() {
        return $this->db;
    }

    public function prepare($sql) {
        if($this->db === null) {
            $this->connect($this->dbType);
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

    public function connect(){
        $host = $this->host[$this->dbType]['host'];
        $user = $this->host[$this->dbType]['user'];
        $password = $this->host[$this->dbType]['password'];
        $database = $this->host[$this->dbType]['database'];
        $port = $this->host[$this->dbType]['port'];

		$this->db = new mysqli($host, $user, $password, $database, $port);
	}
}