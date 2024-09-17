<?php

namespace App\Services\Patient\PDF;

use App\Models\User;
use App\Services\Patient\PDF\PatientPDFService;
use Carbon\Carbon;

class PatientHistoryPDFService extends PatientPDFService{

    protected $showSummary = true;
    protected $filters = null;
    protected $recordingType = 'weight';
    protected $period = null;

    public function __construct(User $patient = null, $filters = null , $title = 'PATIENT HISTORY', $name = null)
    {
        parent::__construct($patient);
        $this->setTitle($title);
        $this->filters = $filters;

        if (!is_null($this->filters) && isset($this->filters['type'])){
            $this->recordingType = $this->filters['type'];
        }
        if (!is_null($this->filters) && isset($this->filters['period'])){
            $this->period = $this->filters['period'];
        }

        if (! is_null($name)) $this->setName($name);
    }

}
