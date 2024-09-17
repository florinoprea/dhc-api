<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Response;

trait CanGenerateImagesTrait
{
    public function generateImage($urlToGenerate, $storeToPath, $graphToImageGeneratorPath = '/generators/graphToImage.js'){

        $command = $this->getNodePath() . ' ' . base_path() . $graphToImageGeneratorPath . ' '. $urlToGenerate . ' ' . storage_path('app') . $storeToPath;
        Log::info('Try to run command:  '. $command );
        $output = array();
        exec($command . ' 2>&1', $output);
        Log::info('Response: '. json_encode($output));
    }

    protected function getNodePath(){
        return env('NODE_PATH', 'node');
    }

    public function generateImageUrl( $history, $filters, $type, $token = '85aefea8a623b68cbda61bfd4d1a0b5780463840443aa2c42e16915fdb1e8682'){
        $graphUrl = URL::to(env('APP_URL') . env('APP_BASE_URL') . 'graph?process=' . urlencode(json_encode([
                'filters' => $filters,
                'history' => $history,
                'token' => $token,
                'type' => $type

            ])));

        Log::info($graphUrl);
        return $graphUrl;
    }
    public function generateImageName(){
        return '/generated/' . md5( time() . Str::random(32)) .'.jpg';
    }

}
