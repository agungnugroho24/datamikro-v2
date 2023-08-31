<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\RequestDatas;
use App\Models\RequestDataFile;
use App\Models\Unitkerja;
use App\Models\NotAvailable;
use App\Models\RequestOther;

class ExportController extends Controller
{
    public function ladu($uuid)
    {
        $data = RequestDatas::where('uuid', $uuid)->first();
        $pusdatin = Unitkerja::where('iduke', '1007')->first();
        $datamikro = RequestDataFile::where('request_data_id', $data->id)
                    ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                    ->leftjoin('categories', 'categories.id', 'cf.category_id')
                    ->select('cf.*', DB::raw('categories.name cn'))
                    ->where('categories.id', '!=', '35')
                    ->get();
        $request_date = date('m', strtotime($data->request_date));
        $str_month = $this->_month($request_date);
        $values = array();
        foreach ($datamikro as $mikro) {
            array_push($values, array('DataMikro' => $mikro->cn.' - '.$mikro->name));
        };

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/LaduTemplate.docx');
        $templateProcessor->setValues([
            'Nomor' => $data->ladu_no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
            'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
            'JabatanPusdatin' => $pusdatin->position,
            'NamaPusdatin' => $pusdatin->responsible,
            'NIPPusdatin' => $pusdatin->nip,
            'JabatanPengirim' => $data->responsible_position,
            'NamaPengirim' => $data->responsible_name,
            'NIP' => $data->responsible_nip,
        ]); 
        $templateProcessor->cloneRowAndSetValues('DataMikro', $values);
        $filename = 'Request-Data_#'.$data->ladu_no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        $templateProcessor->saveAs('php://output');
    }

    public function laduIgt($uuid)
    {
        $data = RequestDatas::where('uuid', $uuid)->first();
        $pusdatin = Unitkerja::where('iduke', '1007')->first();
        $datamikro = RequestDataFile::where('request_data_id', $data->id)
                    ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                    ->leftjoin('categories', 'categories.id', 'cf.category_id')
                    ->select('cf.*', DB::raw('categories.name cn'))
                    ->where('categories.id', '35')
                    ->get();
        $request_date = date('m', strtotime($data->request_date));
        $str_month = $this->_month($request_date);
        $values = array();
        foreach ($datamikro as $mikro) {
            array_push($values, array('DataMikro' => $mikro->cn.' - '.$mikro->name));
        };

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/LaduTemplate_igt.docx');
        $templateProcessor->setValues([
            'Nomor' => $data->ladu_no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
            'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
            'JabatanPusdatin' => $pusdatin->position,
            'NamaPusdatin' => $pusdatin->responsible,
            'NIPPusdatin' => $pusdatin->nip,
            'JabatanPengirim' => $data->responsible_position,
            'NamaPengirim' => $data->responsible_name,
            'NIP' => $data->responsible_nip,
        ]); 
        $templateProcessor->cloneRowAndSetValues('DataMikro', $values);
        $filename = 'Request-Data-IGT_#'.$data->ladu_no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        $templateProcessor->saveAs('php://output');
    }

    public function memo($uuid)
    {
        $data = RequestDatas::where('uuid', $uuid)
                ->leftjoin('users', 'users.id', 'request_datas.created_by')
                ->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
                ->select('request_datas.*', DB::raw('users.name user_name'), DB::raw('users.nip nip'), DB::raw('users.email email'), DB::raw('unitkerjas.name uke_name'))
                ->first();
        $pusdatin = Unitkerja::where('iduke', '1007')->first();
        $datamikro = RequestDataFile::where('request_data_id', $data->id)
                    ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                    ->leftjoin('categories', 'categories.id', 'cf.category_id')
                    ->select('cf.*', DB::raw('categories.name cn'))
                    ->get();
        $request_date = date('m', strtotime($data->request_date));
        $str_month = $this->_month($request_date);
        if($data->nd_number!=null){
            $no = $data->nd_number;
        }else{
            $no = '...';
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/MemoPengantar.docx');
        $templateProcessor->setValues([
            'Nomor' => $no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
            'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
            'JabatanPusdatin' => $pusdatin->position,
            'JabatanPengirim' => $data->responsible_position,
            'NamaPengirim' => $data->responsible_name,
            'NamaPemohon' => $data->user_name,
            'NIPPemohon' => $data->nip,
            'UnitKerjaPemohon' => $data->uke_name,
            'EmailPemohon' => $data->email, 
        ]); 
        $filename = 'Memo_#'.$no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        $templateProcessor->saveAs('php://output');
    }

    public function nolrupiah($id)
    {
        $data = RequestOther::where('id', $id)->first();
        $pusdatin = Unitkerja::where('iduke', '1007')->first();
        $request_date = date('m', strtotime($data->request_date));
        $str_month = $this->_month($request_date);
        $other = NotAvailable::where('request_other_id', $id)->get();
        $values = array();
        $no=1;
        foreach ($other as $other) {
            $isi = array(
                'no' => $no,
                'nama' => $other->name,
                'tahun' => $other->tahun,
                'wilayah' => $other->cakupan,
                'latarbelakang' => $other->latarbelakang,
                'tujuan' => $other->tujuan,
                'metode' => $other->metode,
                'jenisdata' => $other->jenis,
                'variabel' => $other->variabel,
                'rentangwaktu' => $other->rentangwaktu,
                'rancanganhasil' => $other->hasil,
                'keterangan' => $other->keterangan,
            );
            array_push($values, $isi);
        };

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/FormNolRupiah.docx');
        $templateProcessor->setValues([
            'Nomor' => '/P02/'.date('m/Y', strtotime($data->request_date)),
            'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
            'NamaPusdatin' => $pusdatin->responsible,
            'JabatanPusdatin' => $pusdatin->position,
            'NIPPusdatin' => $pusdatin->nip,
        ]); 
        $templateProcessor->cloneRowAndSetValues('no', $values);
        $filename = 'Form-Nol-Rupiah_#..._P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        $templateProcessor->saveAs('php://output');
    }

    public function lampiran(Request $request)
    {
        if (isset($request->get)) {
            switch ($request->get('get')) {
                case 'memo':
                    $data = RequestDatas::where('uuid', $request->laduid)
                            ->leftjoin('users', 'users.id', 'request_datas.created_by')
                            ->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
                            ->select('request_datas.*', DB::raw('users.name user_name'), DB::raw('users.nip nip'), DB::raw('users.email email'), DB::raw('unitkerjas.name uke_name'))
                            ->first();
                    $pusdatin = Unitkerja::where('iduke', '1007')->first();
                    $datamikro = RequestDataFile::where('request_data_id', $data->id)
                                ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                                ->leftjoin('categories', 'categories.id', 'cf.category_id')
                                ->select('cf.*', DB::raw('categories.name cn'))
                                ->get();
                    $request_date = date('m', strtotime($data->request_date));
                    $str_month = $this->_month($request_date);
                    if($data->nd_number!=null){
                        $no = $data->nd_number;
                    }else{
                        $no = '...';
                    }

                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/MemoPengantar.docx');
                    $templateProcessor->setValues([
                        'Nomor' => $no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
                        'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
                        'JabatanPusdatin' => $pusdatin->position,
                        'JabatanPengirim' => $data->responsible_position,
                        'NamaPengirim' => $data->responsible_name,
                        'NamaPemohon' => $data->user_name,
                        'NIPPemohon' => $data->nip,
                        'UnitKerjaPemohon' => $data->uke_name,
                        'EmailPemohon' => $data->email, 
                    ]); 
                    $filename = 'Memo_#'.$no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';
                    break;
                case 'form':
                    $data = RequestDatas::where('uuid', $request->laduid)->first();
                    $pusdatin = Unitkerja::where('iduke', '1007')->first();
                    $datamikro = RequestDataFile::where('request_data_id', $data->id)
                                ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                                ->leftjoin('categories', 'categories.id', 'cf.category_id')
                                ->select('cf.*', DB::raw('categories.name cn'))
                                ->where('categories.id', '!=', '35')
                                ->get();
                    $request_date = date('m', strtotime($data->request_date));
                    $str_month = $this->_month($request_date);
                    $values = array();
                    foreach ($datamikro as $mikro) {
                        array_push($values, array('DataMikro' => $mikro->cn.' - '.$mikro->name));
                    };

                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/LaduTemplate_pusdatin.docx');
                    $templateProcessor->setValues([
                        'Nomor' => $data->ladu_no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
                        'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
                        'JabatanPusdatin' => $pusdatin->position,
                        'NamaPusdatin' => $pusdatin->responsible,
                        'NIPPusdatin' => $pusdatin->nip,
                        'JabatanPengirim' => $data->responsible_position,
                        'NamaPengirim' => $data->responsible_name,
                        'NIP' => $data->responsible_nip,
                    ]); 
                    $templateProcessor->cloneRowAndSetValues('DataMikro', $values);
                    $filename = 'Request-Data_#'.$data->ladu_no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';
                    break;
                case 'userreport':
                    $data = RequestDatas::where('uuid', $request->laduid)
                            ->leftjoin('users', 'users.id', 'request_datas.created_by')
                            ->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
                            ->select('request_datas.*', DB::raw('users.name user_name'), DB::raw('users.nip nip'), DB::raw('users.email email'), DB::raw('unitkerjas.name uke_name'))
                            ->first();
                    $pusdatin = Unitkerja::where('iduke', '1007')->first();
                    $datamikro = RequestDataFile::where('request_data_id', $data->id)
                                ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                                ->leftjoin('categories', 'categories.id', 'cf.category_id')
                                ->select('cf.*', DB::raw('categories.name cn'))
                                ->get();
                    $request_date = date('m', strtotime($data->request_date));
                    $str_month = $this->_month($request_date);
                    $values = array();
                    foreach ($datamikro as $mikro) {
                        array_push($values, array('DataMikro' => $mikro->cn.' - '.$mikro->name));
                    };

                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/UserReport.docx');
                    $templateProcessor->setValues([
                        'UnitKerjaPemohon' => $data->uke_name,
                        'NamaPemohon' => $data->user_name,
                        'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
                        'JudulAbstraksi' => $data->abstract_title,
                        'IsiAbstraksi' => $data->abstract_content,
                    ]); 
                    $templateProcessor->cloneRowAndSetValues('DataMikro', $values);
                    $filename = 'Report_User_#'.$data->user_name . '_' . date('m_Y', strtotime($data->request_date)).'.docx';
                    break;        
                case 'igt':
                    $data = RequestDatas::where('uuid', $request->laduid)->first();
                    $pusdatin = Unitkerja::where('iduke', '1007')->first();
                    $datamikro = RequestDataFile::where('request_data_id', $data->id)
                                ->leftjoin(DB::raw('category_files cf'), 'cf.id', 'request_data_files.category_file_id')
                                ->leftjoin('categories', 'categories.id', 'cf.category_id')
                                ->select('cf.*', DB::raw('categories.name cn'))
                                ->where('categories.id', '35')
                                ->get();
                    $request_date = date('m', strtotime($data->request_date));
                    $str_month = $this->_month($request_date);
                    $values = array();
                    foreach ($datamikro as $mikro) {
                        array_push($values, array('DataMikro' => $mikro->cn.' - '.$mikro->name));
                    };

                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(resource_path().'/template/LaduTemplate_igt.docx');
                    $templateProcessor->setValues([
                        'Nomor' => $data->ladu_no . '/P02.SP/' . date('m/Y', strtotime($data->request_date)),
                        'Tanggal' => date('d ', strtotime($data->request_date)).$str_month.date(' Y', strtotime($data->request_date)),
                        'JabatanPusdatin' => $pusdatin->position,
                        'NamaPusdatin' => $pusdatin->responsible,
                        'NIPPusdatin' => $pusdatin->nip,
                        'JabatanPengirim' => $data->responsible_position,
                        'NamaPengirim' => $data->responsible_name,
                        'NIP' => $data->responsible_nip,
                    ]); 
                    $templateProcessor->cloneRowAndSetValues('DataMikro', $values);
                    $filename = 'Request-Data-IGT_#'.$data->ladu_no . '_P02.SP_' . date('m_Y', strtotime($data->request_date)).'.docx';
                    break;        
                default:
                    exit;
            }

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Disposition: attachment; filename=$filename");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            $templateProcessor->saveAs('php://output');
        }
    }

    function _month($number = 0)
    {
        switch ($number) {
            case 1:
            $m = 'Januari';
            break;
            case 2:
            $m = 'Februari';
            break;
            case 3:
            $m = 'Maret';
            break;
            case 4:
            $m = 'April';
            break;
            case 5:
            $m = 'Mei';
            break;
            case 6:
            $m = 'Juni';
            break;
            case 7:
            $m = 'Juli';
            break;
            case 8:
            $m = 'Agustus';
            break;
            case 9:
            $m = 'September';
            break;
            case 10:
            $m = 'Oktober';
            break;
            case 11:
            $m = 'November';
            break;
            case 12:
            $m = 'Desember';
            break;
            default:
            $m = '';
            break;
        }
        return $m;
    }
}
