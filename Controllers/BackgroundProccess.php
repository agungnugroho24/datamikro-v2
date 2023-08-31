<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Unitkerja;
use App\Models\Datarenbang;

class BackgroundProccess extends Controller
{
    public function unitkerja()
    {
        $response = Http::withHeaders([
            'Authorization' => '4b03e5a4e55bdd7a791e9c874b20dfc0ee376164e12553e004e824b4f2e2af216e082d503292b609602b6baebd20bbbd1fcf4be269831b3d05f6d5c37a8e719e'
        ])->get('https://api.bappenas.go.id/bus/api/domain/bsdm/unitkerja', [
            'id' => 'all',
        ]);

        if($response->getStatusCode() == '200'){
            $data = $response->json();
            if($data['status'] == true){
                // dd($data['data']);
                foreach($data['data'] as $uke){
                    $unitkerja = Unitkerja::firstOrNew(['id' => $uke['id']]);
                    $unitkerja->id = $uke['id'];
                    $unitkerja->iduke = $uke['iduke'];
                    $unitkerja->parent = $uke['parent'];
                    $unitkerja->name = $uke['nama'];
                    $unitkerja->save();
                };
                echo 'success';
            }else{
                echo 'Data not found';
            }
        }else{
            echo 'Error';
        }
    }

    public function jabatan()
    {
        $response = Http::withHeaders([
            'Authorization' => '4b03e5a4e55bdd7a791e9c874b20dfc0ee376164e12553e004e824b4f2e2af216e082d503292b609602b6baebd20bbbd1fcf4be269831b3d05f6d5c37a8e719e'
        ])->get('https://api.bappenas.go.id/bus/api/domain/bsdm/nominatiflain');

        if($response->getStatusCode() == '200'){
            $data = $response->json();
            if($data['status'] == true){
                // dd($data['data']);
                foreach($data['data'] as $uke){
                    $unitkerja = Unitkerja::where('iduke', $uke['iduke'])->first();
                    $unitkerja->position = $uke['jabatan'];
                    $unitkerja->responsible = $uke['nama'];
                    $unitkerja->nip = $uke['nip'];
                    $unitkerja->save();
                };
                echo 'success';
            }else{
                echo 'Data not found';
            }
        }else{
            echo 'Error';
        }
    }

    public function datarenbang()
    {
        $response = Http::withHeaders([
            'Authorization' => '4b03e5a4e55bdd7a791e9c874b20dfc0ee376164e12553e004e824b4f2e2af216e082d503292b609602b6baebd20bbbd1fcf4be269831b3d05f6d5c37a8e719e'
        ])->get('https://api.bappenas.go.id/bus/api/domain/datarenbang/getvariabel-bps');

        if($response->getStatusCode() == '200'){
            $data = $response->json();
            if($data['status'] == true){
                // dd($data['data']);
                foreach($data['data'] as $data){
                    $datarenbang = Datarenbang::firstOrNew(['datarenbang_id' => $data['id']]);
                    $datarenbang->datarenbang_id = $data['id'];
                    $datarenbang->title = $data['title'];
                    $datarenbang->unit = $data['unit'];
                    $datarenbang->sub_name = $data['sub_name'];
                    $datarenbang->def = $data['def'];
                    $datarenbang->notes = $data['notes'];
                    $datarenbang->url = $data['url'];
                    $datarenbang->save();
                };
                echo 'success';
            }else{
                echo 'Data not found';
            }
        }else{
            echo 'Error';
        }
    }
}
