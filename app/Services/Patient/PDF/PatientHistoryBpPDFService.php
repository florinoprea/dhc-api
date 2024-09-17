<?php

namespace App\Services\Patient\PDF;

use App\Models\User;
use App\Repositories\PatientBloodPressureRepository;
use App\Repositories\PatientWeightRepository;
use App\Services\PatientWeightService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PatientHistoryBpPDFService extends PatientHistoryPDFService{

    protected $repository;

    public function __construct( User $patient = null, $filters = null, $title = 'PATIENT BP HISTORY ', $name = null)
    {
        parent::__construct($patient);
        $this->setTitle($title);
        $this->filters = $filters;

        if (! is_null($name)) $this->setName($name);

        $this->repository = (new PatientBloodPressureRepository())->forPatient($patient->id);

    }

    private function getPatientWeightHistory(){
        return $this->repository->orderedDescending()->search($this->filters)->fetch();
    }

    public function setDataPDF(){
        $data = $this->getPatientWeightHistory();

        $graphUrl = $this->generateImageUrl($data->toArray(), $this->filters, 'blood_pressure');
        $imagePath = $this->generateImageName();

        $imageContent = null;
        if ($data->count() > 0) {

            $imageDataGeneration = $this->generateImage($graphUrl, $imagePath);

            if (Storage::disk('local')->exists($imagePath)) {
                $imageContent = base64_encode(Storage::disk('local')->get($imagePath));
            }
        }

        $pdfData =  array_merge($this->getGeneralPDFData(),
            [
                'imageContent' => $imageContent,
                'data' => $data,
                'subtitle' => $this->filters['period']['from'] . ' - ' . $this->filters['period']['to']
            ]
        );
        if ( Storage::disk('local')->exists($imagePath)){
            //Storage::disk('local')->delete($imagePath);
        }

        $this->pdf->loadView('pdf.patient.reports.bp', $pdfData);
    }
}
