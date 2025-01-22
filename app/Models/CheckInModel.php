<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckInModel extends Model
{
    protected $table            = 'check_ins';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'ocorrencia_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getTrajetoria($userId) 
    {
        $userModel = model(UserModel::class);
        $user = $userModel->where('id', $userId)->first();
        $user['idade'] = date_diff(date_create($user['dn']), date_create('now'))->y;
        $this->select('*');
        $this->where('user_id', $userId);
        $this->orderBy('hora_checkin', 'asc');
        $result = $this->findAll();
        $result = [
            'aluno' => $user,
            'trajetoria' => [
                ['title' => 'Treinos Regulares',
                'event' => '20 aulas',
                'icon' => 'training'],
                ['title' => 'Exame de Faixa Laranja',
                'event' => '20/03/2025',
                'icon' => 'training'],
                ['title' => 'Treinos Regulares',
                'event' => '5 Aulas',
                'icon' => 'training'],
                ['title' => 'Seminário',
                'event' => '16/04/2025',
                'icon' => 'training'],
                ['title' => 'Treinos Regulares',
                'event' => '18 Aulas',
                'icon' => 'training'],
                ['title' => 'Exame de Faixa Amarela',
                'event' => '20/07/2025',
                'icon' => 'training'],
                ['title' => 'Treinos Regulares',
                'event' => '60 Aulas',
                'icon' => 'training'],
                ['title' => 'Exame de Faixa: Faixa Roxa',
                'event' => '20/02/2026',
                'icon' => 'training'],
                ['title' => 'Treinos Regulares',
                'event' => '50 Aulas',
                'icon' => 'training'],
            ]
        ];
        return $result;
    }

}
