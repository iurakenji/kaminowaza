<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use CodeIgniter\Model;

class OcorrenciaModel extends Model
{
    protected $table            = 'ocorrencias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'tipo',
        'referencia_id',
        'inicio',
        'termino',
        'titulo',
        'observacao',
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

    public function checkAvailable(array $data)
    {
        $db = db_connect();
        $startHour = explode(':', $data['inicio'])[0];
        $startMinute = explode(':', $data['inicio'])[1];
        $startTime = $startHour . ':' . $startMinute . ':00';
        $endHour = explode(':', $data['termino'])[0];
        $endMinute = explode(':', $data['termino'])[1];
        $endTime = $endHour . ':' . $endMinute . ':00';
        $builder = $db->table('ocorrencias');
        if (isset($data['dia'])) {
            $weekDay = $data['dia'];
            $weekDay = $weekDay === 0 ? 7 : $weekDay;
            $builder->select('*')
                ->groupStart()
                    ->where("MOD(DAYOFWEEK(inicio) + 5, 7) + 1", $weekDay)
                    ->orWhere("MOD(DAYOFWEEK(termino) + 5, 7) + 1", $weekDay)
                ->groupEnd()
                ->where("TIME(inicio) BETWEEN '{$startTime}' AND '{$endTime}'");
            if (isset($data['id'])) {
                $builder->groupStart()
                    ->where('referencia_id !=', $data['id'])
                    ->where('tipo', $data['tipo'])
                    ->groupEnd();
            }
        } else {
            $builder->select('*')
                    ->groupStart()
                        ->where('DATE(inicio)', date('Y-m-d', strtotime($data['inicio'])))
                        ->orWhere('DATE(termino)', date('Y-m-d', strtotime($data['termino'])))
                    ->groupEnd()
                    ->groupStart()
                        ->where('inicio >=', date('Y-m-d H:i:s', strtotime($data['inicio'])))
                        ->orWhere('termino <=', date('Y-m-d H:i:s', strtotime($data['termino'])))
                    ->groupEnd();
        }
        if (isset($data['id'])) {
            $builder->groupStart()
                    ->where('referencia_id !=', $data['id'])
                    ->where('tipo', $data['tipo'])
                    ->groupEnd();
        }
        $query = $builder->get();
        $conflitos = $query->getResultArray();
        $result = [];
        foreach ($conflitos as $conflito) {
            if (!isset($data['titulo']) && isset($data['dia'])) {
                $data['titulo'] = 'Treino: ' . WEEKDAYS[$data['dia']] . ' - ' . $data['inicio'] . ' - ' . $data['termino'];
            }
            $result[] = [
                'data' => $conflito['inicio'] . ' - ' . $conflito['termino'],
                'inserida' => $data['titulo'],
                'conflito' => $conflito['titulo']
            ];
        }
        return $result;
    }

    public function upsertTreinos(array $data)
    {
        $weekDay = $data['dia'];
        unset($data['dia']);
        $weekDay = date('l', strtotime("Sunday + $weekDay days"));
        $first = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $first->modify('next ' . $weekDay);

        $startHour = explode(':', $data['inicio'])[0];
        $startMinute = explode(':', $data['inicio'])[1];
        $endHour = explode(':', $data['termino'])[0];
        $endMinute = explode(':', $data['termino'])[1];

        $last = new DateTime('last day of December');

        $errors = [];
        $this->where('referencia_id', $data['referencia_id'])->where('tipo', 'treino_regular')->delete();   

        while ($first <= $last) {
            $first->setTime($startHour, $startMinute);
            $data['inicio'] = $first->format('Y-m-d H:i:s');

            $first->setTime($endHour, $endMinute);
            $data['termino'] = $first->format('Y-m-d H:i:s');
            try {
                $this->insert($data);
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
            $first->modify('+1 week');
        }
        return $errors;
    }

    public function getOcorrencias($mes = null, $ano = null)
    {
        $db = db_connect();

        $builder = $db->table('ocorrencias');

        if (isset($mes) && isset($ano)) {
            $builder->select('*')
                    ->where('MONTH(inicio)', $mes)
                    ->where('YEAR(inicio)', $ano);
        } elseif (isset($mes)) {
            $builder->select('*')
                    ->where('MONTH(inicio)', $mes);
        } elseif (isset($ano)) {
            $builder->select('*')
                    ->where('YEAR(inicio)', $ano);
        } else {
            $builder->select('*');
        }

        $query = $builder->get();

        return $query->getResultArray();
    }

}
