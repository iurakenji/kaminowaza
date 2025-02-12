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
        'hora_checkin',
        'validado',
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

    const TRAJETORIA_ICONS = [
        'treinos' => 'training',
        'exame' => 'belt',
        'evento' => 'ponto',
        'seminario' => 'seminar',
        'outro' => 'belt'
    ];

    public function getTrajetoria($userId) 
    {
        $userModel = model(UserModel::class);
        $user = $userModel->where('id', $userId)->first();
        $user['idade'] = date_diff(date_create($user['dn']), date_create('now'))->y;

        $this->select('*');
        $this->where('user_id', $userId);
        $this->orderBy('hora_checkin', 'asc');
        $checkins = $this->findAll();

        if (!empty($checkins)) {

            $ocorrenciaModel = model(OcorrenciaModel::class);
            $ocorrencias = $ocorrenciaModel
                ->whereIn('id', array_column($checkins, 'ocorrencia_id'))
                ->findAll();


            $eventoModel = model(EventoModel::class);
            $eventos = $eventoModel
                ->whereIn('id', array_column($ocorrencias, 'referencia_id'))
                ->findAll();

            $trajetoria = [];
            $aulasEntreEventos = 0;

            foreach ($checkins as $checkin) {
                $ocorrencia = array_filter($ocorrencias, function ($o) use ($checkin) {
                    return $o['id'] === $checkin['ocorrencia_id'];
                });
                $ocorrencia = reset($ocorrencia);

                if ($ocorrencia && $ocorrencia['tipo'] === 'treino_regular') {
                    $aulasEntreEventos++;
                    continue;
                }

                if ($ocorrencia && $ocorrencia['tipo'] === 'evento') {

                    if ($aulasEntreEventos > 0) {
                        $trajetoria[] = [
                            'title' => 'Treinos Regulares',
                            'event' => "{$aulasEntreEventos} Aulas",
                            'icon' => self::TRAJETORIA_ICONS['treinos'],
                        ];
                        $aulasEntreEventos = 0;
                    }

                    if ($ocorrencia) {
                        $trajetoria[] = [
                            'title' => $ocorrencia['titulo'],
                            'event' => date('d/m/Y', strtotime($ocorrencia['inicio'])),
                            'icon' => self::TRAJETORIA_ICONS[$ocorrencia['tipo']],
                        ];
                    }

                }
            }
        } else {
            $trajetoria = [];
        }

        $result = [
            'aluno' => $user,
            'trajetoria' => $trajetoria
        ];
        return $result;
    }



}

