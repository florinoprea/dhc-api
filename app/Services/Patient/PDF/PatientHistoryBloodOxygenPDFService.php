<?php

namespace App\Services\Patient\PDF;

use App\Models\User;
use App\Repositories\PatientBloodGlucoseRepository;
use App\Repositories\PatientBloodOxygenRepository;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PatientHistoryBloodOxygenPDFService extends PatientHistoryPDFService{

    protected $repository;

    public function __construct( User $patient = null, $filters = null, $title = 'PATIENT BLOOD OXYGEN HISTORY ', $name = null)
    {
        parent::__construct($patient);
        $this->setTitle($title);
        $this->filters = $filters;

        if (! is_null($name)) $this->setName($name);

        $this->repository = (new PatientBloodOxygenRepository())->forPatient($patient->id);

    }

    private function getPatientHistory(){
        return $this->repository->orderedDescending()->search($this->filters)->fetch();
    }

    public function setDataPDF(){
        $data = $this->getPatientHistory();

        $graphUrl = $this->generateImageUrl($data->toArray(), $this->filters, 'blood_oxygen');
        $imagePath = $this->generateImageName();

        $imageContent = null;
        if ($data->count() > 0) {
            try {
                $this->generateImage($graphUrl, $imagePath);
            } catch (Exception $e) {

            }
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

        $this->pdf->loadView('pdf.patient.reports.bloodOxygen', $pdfData);
    }
}
