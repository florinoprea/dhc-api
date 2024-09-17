<?php

namespace App\Services\Patient\PDF;

use App\Models\User;
use App\Traits\CanGenerateImagesTrait;
use Carbon\Carbon;
use App\Traits\TimezoneAwareTrait;

class PatientPDFService{

    use TimezoneAwareTrait;
    use CanGenerateImagesTrait;

    protected $patient = null;
    protected $pdf;
    protected $contentPDF;
    protected $usePageNumber = TRUE;
    protected $title = 'Patient PDF';
    protected $name = 'Patient.pdf';
    protected $timezone = null;


    public function __construct(User $patient = null)
    {
        $this->patient = $patient;
        $this->pdf = app('dompdf.wrapper');
        $this->timezone = $this->timezone_user();
    }

    public function setStudent(User $patient)
    {
        $this->patient = $patient;
        return $this;
    }

    public function setPageNumber($usePageNumber = true)
    {
        $this->usePageNumber = $usePageNumber;
        return $this;
    }
    public function usePageNumber()
    {
        return $this->usePageNumber;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setTimezone($timezone)
    {
        if ($timezone) $this->timezone = $timezone;
        return $this;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function hasPatient()
    {
        return $this->patient !== null;
    }

    public function canBeGenerated(){
        return $this->hasPatient();
    }

    public function getPdfName(){
        return $this->name;
    }

    public function getGeneralPDFData(){
        return [
            'patient' => $this->patient,
            'title' => $this->title,
            'name' => $this->name,
            'timezone_user' => $this->getTimezone(),
            'current_time' => Carbon::now()->timezone($this->getTimezone()),
        ];
    }



    public function addPageNumber(){
        $dom_pdf = $this->pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        //$canvas->page_text(270, 130, "PAGE {PAGE_NUM} OF {PAGE_COUNT}", null, 8, array(0, 0, 0));
    }


    public function checkPDF(){
        if (!$this->canBeGenerated()) throw new \Exception($this->title . ' can not be generated. Missing patient.');
        return;
    }

    public function generatePDF(){
        $this->checkPDF();

        $this->setDataPDF();

        if ($this->usePageNumber()) $this->addPageNumber();
    }

    public function getPDF(){
        $this->generatePDF();
        return $this->pdf->stream($this->getPdfName());
    }

    public function download(){
        return $this->getPDF();
    }

    public function getAsString(){

        $this->generatePDF();
        return $this->pdf->output();
    }

    public function minutesToString($minutes){
        if ($minutes ==  null ) return '';
        $minutes = (int)$minutes;
        $d = $minutes;
        $h = floor($d / 60);
        $m = $minutes - ($h * 60);

        return ($h > 0 ? $h . 'h,' : '') . ' '. $m . 'm' ;
    }



}
