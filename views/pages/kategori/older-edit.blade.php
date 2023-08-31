<!-- View template master -->
@extends('layouts.index') 

@push('styles')
<style>
  .box1 { border:1px solid #ccc; height: 100px; overflow-y: scroll;}
</style>
@endpush
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left mb-3">
    <h3>Edit Kategori Data Dasar</h3>
    {{-- <hr> --}}
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form role="form" action="{{ route('category.store') }}" method="post" >
        @csrf
        <div class="form-group row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Kategori Data Dasar" value="{{ old('name') }}">
              @error('name')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
          </div>
        </div>        
        <div class="form-group row mb-3">
          <label for="slug" class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="slug" name="slug" value="" required readonly>
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="description">Description</label>
          </div>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="access_level">Level Akses</label>
          </div>
          <div class="col-sm-10">
            <select class="form-control" id="access_level">
              <option value="" selected="selected">Publik</option>
              <option value="00">Men PPN/Kepala Badan Perencanaan Pembangunan Nasional</option>
              <option value="0001">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Pembangunan Manusia, Masyarakat, dan Kebudayaan</option>
              <option value="000101">&nbsp;&nbsp;&nbsp;&nbsp;Kesehatan dan Gizi Masyarakat</option>
              <option value="000102">&nbsp;&nbsp;&nbsp;&nbsp;Agama, Pendidikan, dan Kebudayaan</option>
              <option value="000103">&nbsp;&nbsp;&nbsp;&nbsp;Pendidikan Tinggi dan IPTEK</option>
              <option value="000104">&nbsp;&nbsp;&nbsp;&nbsp;Keluarga, Perempuan, Anak, Pemuda dan Olahraga</option>
              <option value="0002">&nbsp;&nbsp;Deputi Meneg PPN/Kepala Bappenas Bidang Politik, Hukum, Pertahanan dan Keamanan</option>
              <option value="000201">&nbsp;&nbsp;&nbsp;&nbsp;Hukum dan Regulasi</option>
              <option value="000202">&nbsp;&nbsp;&nbsp;&nbsp;Politik Luar Negeri dan Kerjasama Pembangunan Internasional</option>
              <option value="000203">&nbsp;&nbsp;&nbsp;&nbsp;Politik dan Komunikasi</option>
              <option value="000204">&nbsp;&nbsp;&nbsp;&nbsp;Aparatur Negara</option>
              <option value="000205">&nbsp;&nbsp;&nbsp;&nbsp;Pertahanan dan Keamanan</option>
              <option value="0003">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Kependudukan dan Ketenagakerjaan</option>
              <option value="000301">&nbsp;&nbsp;&nbsp;&nbsp;Penanggulangan Kemiskinan dan Pemberdayaan Masyarakat</option>
              <option value="000303">&nbsp;&nbsp;&nbsp;&nbsp;Pengembangan Usaha Kecil, Menengah dan Koperasi</option>
              <option value="000304">&nbsp;&nbsp;&nbsp;&nbsp;Kependudukan dan Jaminan Sosial</option>
              <option value="0004">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Ekonomi</option>
              <option value="000401">&nbsp;&nbsp;&nbsp;&nbsp;Perencanaan Makro dan Analisis Statistik</option>
              <option value="000402">&nbsp;&nbsp;&nbsp;&nbsp;Keuangan Negara dan Analisa Moneter</option>
              <option value="000403">&nbsp;&nbsp;&nbsp;&nbsp;Jasa Keuangan dan BUMN</option>
              <option value="000404">&nbsp;&nbsp;&nbsp;&nbsp;Perdagangan, Investasi, dan Kerjasama Ekonomi Internasional</option>
              <option value="000405">&nbsp;&nbsp;&nbsp;&nbsp;Industri, Pariwisata dan Ekonomi Kreatif</option>
              <option value="0005">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Kemaritiman dan Sumber Daya Alam</option>
              <option value="000501">&nbsp;&nbsp;&nbsp;&nbsp;Pangan dan Pertanian</option>
              <option value="000502">&nbsp;&nbsp;&nbsp;&nbsp;Kehutanan dan Konservasi Sumber Daya Air</option>
              <option value="000503">&nbsp;&nbsp;&nbsp;&nbsp;Kelautan dan Perikanan</option>
              <option value="000504">&nbsp;&nbsp;&nbsp;&nbsp;Sumber Daya Energi, Mineral dan Pertambangan</option>
              <option value="000505">&nbsp;&nbsp;&nbsp;&nbsp;Lingkungan Hidup</option>
              <option value="0006">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Sarana dan Prasarana</option>
              <option value="000601">&nbsp;&nbsp;&nbsp;&nbsp;Pengairan dan Irigasi</option>
              <option value="000602">&nbsp;&nbsp;&nbsp;&nbsp;Transportasi</option>
              <option value="000603">&nbsp;&nbsp;&nbsp;&nbsp;Ketenagalistrikan, Telekomunikasi dan Informatika</option>
              <option value="000604">&nbsp;&nbsp;&nbsp;&nbsp;Perencanaan dan Pengembangan Proyek Infrastruktur Prioritas Nasional</option>
              <option value="000605">&nbsp;&nbsp;&nbsp;&nbsp;Perencanaan dan Pengembangan Proyek Infrastruktur Prioritas Nasional</option>
              <option value="0007">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Pengembangan Regional</option>
              <option value="000701">&nbsp;&nbsp;&nbsp;&nbsp;Pembangunan Daerah</option>
              <option value="000702">&nbsp;&nbsp;&nbsp;&nbsp;Regional I</option>
              <option value="000703">&nbsp;&nbsp;&nbsp;&nbsp;Regional III</option>
              <option value="000704">&nbsp;&nbsp;&nbsp;&nbsp;Regional II</option>
              <option value="000705">&nbsp;&nbsp;&nbsp;&nbsp;Tata Ruang dan Penanganan Bencana</option>
              <option value="0008">&nbsp;&nbsp;Deputi Meneg PPN / Kepala Bappenas Bidang Pendanaan Pembangunan</option>
              <option value="000801">&nbsp;&nbsp;&nbsp;&nbsp;Alokasi Pendanaan Pembangunan</option>
              <option value="000803">&nbsp;&nbsp;&nbsp;&nbsp;Kerja Sama Pendanaan Multilateral</option>
              <option value="000804">&nbsp;&nbsp;&nbsp;&nbsp;Pengembangan Pendanaan Pembangunan</option>
              <option value="000805">&nbsp;&nbsp;&nbsp;&nbsp;Perencanaan Pendanaan Pembangunan</option>
              <option value="0009">&nbsp;&nbsp;Deputi Meneg PPN/Kepala Bappenas Bidang Pemantauan, Evaluasi, dan Pengendalian Pembangunan</option>
              <option value="000901">&nbsp;&nbsp;&nbsp;&nbsp;Pemantauan, Evaluasi dan Pengendalian Pembangunan Daerah</option>
              <option value="000902">&nbsp;&nbsp;&nbsp;&nbsp;Pemantauan, Evaluasi dan Pengendalian Pembangunan Sektoral</option>
              <option value="000903">&nbsp;&nbsp;&nbsp;&nbsp;Sistem dan Pelaporan Pemantauan, Evaluasi dan Pengendalian Pembangunan</option>
              <option value="000904">&nbsp;&nbsp;&nbsp;&nbsp;Evaluasi dan Pengendalian Penyusunan Perencanaan Pembangunan</option>
              <option value="0010">&nbsp;&nbsp;Inspektur Utama</option>
              <option value="001001">&nbsp;&nbsp;&nbsp;&nbsp;Inspektorat Bidang Administrasi Umum</option>
              <option value="001002">&nbsp;&nbsp;&nbsp;&nbsp;Inspektorat Bidang Kinerja Kelembagaan</option>
              <option value="0011">&nbsp;&nbsp;Sesmeneg PPN / Sekertaris Utama</option>
              <option value="001101">&nbsp;&nbsp;&nbsp;&nbsp;Biro Humas dan Tata Usaha Pimpinan</option>
              <option value="001102">&nbsp;&nbsp;&nbsp;&nbsp;Biro Sumber Daya Manusia</option>
              <option value="001103">&nbsp;&nbsp;&nbsp;&nbsp;Biro Hukum</option>
              <option value="001104">&nbsp;&nbsp;&nbsp;&nbsp;Biro Umum</option>
              <option value="001105">&nbsp;&nbsp;&nbsp;&nbsp;Biro Perencanaan, Organisasi dan Tata Laksana</option>
              <option value="001106">&nbsp;&nbsp;&nbsp;&nbsp;Pusat Pembinaan, Pendidikan dan Pelatihan Perencanaan</option>
              <option value="001107">&nbsp;&nbsp;&nbsp;&nbsp;Pusat Data dan Informasi Perencanaan Pembangunan</option>
              <option value="001108">&nbsp;&nbsp;&nbsp;&nbsp;Pusat Analisis Kebijakan dan Kinerja</option>
              <option value="0012">&nbsp;&nbsp;Meneg PPN Bidang Sosial dan Penanggulangan Kemiskinan</option>
              <option value="0013">&nbsp;&nbsp;Meneg PPN Bidang Pembangunan Sektor Unggulan dan Infrastruktur</option>
              <option value="0014">&nbsp;&nbsp;Meneg PPN Bidang Hubungan Kelembagaan</option>
              <option value="0015">&nbsp;&nbsp;Meneg PPN Bidang Sinergi Ekonomi dan Pembiayaan</option>
              <option value="0016">&nbsp;&nbsp;Meneg PPN Bidang Pemerataan dan Kewilayahan</option>
            </select>
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="external_pub">Publikasi API Web</label>
          </div>
          <div class="col-sm-10">
            <select class="form-control" id="external_pub">
              <option value="n" selected="selected">Tidak ditampilkan!</option>
              <option value="ds">Web - Data Statistik</option>
              <option value="dp">Web - Data Publikasi</option>
            </select>
          </div>
        </div>

        <hr>
        <legend>Meta</legend>
        <div class="form-group row mb-3">
          <label for="publication" class="col-sm-2 col-form-label">Publikasi</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="publication" name="publication">
          </div>
        </div> 
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="dataset_id">Dataset</label>
          </div>
          <div class="col-sm-10">
            <select class="form-control" id="dataset_id">
              <option value="53" selected="selected">Consumer and Producer Price Index</option>
              <option value="54">Consumer and Producer Price Index : Quarterly</option>
              <option value="38">Daerah Tertinggal</option>
              <option value="32">Data dan Informasi Spasial</option>
              <option value="9">Daya Beli Masyarakat</option>
              <option value="40">Desentralisasi, Hubungan Pusat Daerah, dan Antardaerah</option>
              <option value="37">Ekonomi Lokal dan Daerah</option>
              <option value="10">Ekspor</option>
              <option value="11">Energi dan Ketenagalistrikan</option>
              <option value="22">Gangguan Keamanan di Wilayah Perbatasan dan Pulau Terdepan</option>
              <option value="67">GDP by Expenditure (1993 Price)</option>
              <option value="66">GDP by Expenditure (2000 Price)</option>
              <option value="70">GDP by Expenditure (2000 Price-Annually)</option>
              <option value="57">GDP by Expenditure (2000 Price-Percentace Changes)</option>
              <option value="65">GDP by Expenditure (Current Price)</option>
              <option value="56">GDP by Expenditure (Current Price-1983 Basis-Annually)</option>
              <option value="69">GDP by Expenditure (Current Price-Annually)</option>
              <option value="71">GDP by Expenditure (Old Constant Price-Annually)</option>
              <option value="61">GDP by Industry (1993 Price)</option>
              <option value="60">GDP by Industry (2000 Price)</option>
              <option value="72">GDP By Industry (2000 Price-Annually)</option>
              <option value="68">GDP by Industry (2000 Price-Percentace Change)</option>
              <option value="62">GDP by Industry (Current Price)</option>
              <option value="58">GDP by Industry (Current Price-1983 Basis-Annually)</option>
              <option value="55">GDP by Industry (Current Price-Annually)</option>
              <option value="59">GDP by Industry (Old Constant Price-Annually)</option>
              <option value="76">GDP by Province (1983 Price)</option>
              <option value="75">GDP by Province (1993 Price)</option>
              <option value="63">GDP by Province (2000 Price)</option>
              <option value="74">GDP by Province (Current Price-1983 base)</option>
              <option value="73">GDP by Province (Current Price-1993 base)</option>
              <option value="64">GDP by Province (Current Price-2000 base)</option>
              <option value="77">GDP Percapita (Current Price)</option>
              <option value="6">Indikator Keuangan</option>
              <option value="2">Industri</option>
              <option value="3">Investasi</option>
              <option value="13">IPTEK</option>
              <option value="39">Kawasan Rawan Bencana</option>
              <option value="27">Keamanan dan Ketertiban Masyarakat </option>
              <option value="23">Kejahatan Trans-Nasional</option>
              <option value="50">Kependudukan</option>
              <option value="19">Kepentingan dan Kebijakan Negara Adidaya</option>
              <option value="52">Kesehatan</option>
              <option value="51">Kesejahteraan</option>
              <option value="4">Ketenagakerjaan</option>
              <option value="7">Keuangan Negara</option>
              <option value="28">Kinerja Lembaga Kepolisian</option>
              <option value="31">Komunikasi dan Informatika</option>
              <option value="1">Konsumsi Masyarakat</option>
              <option value="15">Lainnya</option>
              <option value="78">LAMPID</option>
              <option value="17">Lingkungan Strategis-Kawasan Regional</option>
              <option value="12">Moneter</option>
              <option value="79">MP3EI</option>
              <option value="82">P3B</option>
              <option value="8">Pariwisata</option>
              <option value="33">Penataan Ruang</option>
              <option value="49">Pendidikan</option>
              <option value="42">Peningkatan Ketahanan dan Kemandirian Energi</option>
              <option value="16">Peningkatan Ketahanan Pangan dan Revitalisasi Pertanian, Perikanan, dan Kehutanan</option>
              <option value="45">Peningkatan Konservasi dan Rehabilitasi Sumber Daya Hutan</option>
              <option value="47">Peningkatan Kualitas Informasi Iklim dan Bencana Alam serta Kapasitas Adaptasi dan Mitigasi Perubahan Iklim</option>
              <option value="46">Peningkatan Pengelolaan Sumber Daya Kelautan </option>
              <option value="43">Peningkatan Pengelolaan Sumber Daya Mineral dan Pertambangan</option>
              <option value="24">Penyalahgunaan Narkoba</option>
              <option value="44">Perbaikan Kualitas Lingkungan Hidup</option>
              <option value="21">Perbatasan Negara</option>
              <option value="25">Perdagangan manusia (human trafficking)</option>
              <option value="36">Perdesaan</option>
              <option value="35">Perkotaan</option>
              <option value="18">Perlombaan Senjata di Kawasan Regional</option>
              <option value="34">Pertanahan</option>
              <option value="30">Perumahan dan Permukiman</option>
              <option value="81">PNPM</option>
              <option value="29">Postur Pertahanan</option>
              <option value="80">RPJMN</option>
              <option value="14">Sumber Daya Air</option>
              <option value="83">TARGET MDGs</option>
              <option value="41">Tata Kelola dan Kapasitas Pemerintahan Daerah</option>
              <option value="26">Terorisme</option>
              <option value="48">Transportasi</option>
              <option value="5">Umum</option>
              <option value="20">Wilayah Laut Yurisdiksi Nasional</option>
            </select>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="tags" class="col-sm-2 col-form-label">Sumber</label>
          <div class="col-sm-10">
            <div class="box1 p-2">
              <input type="checkbox" /> BPS <br/>
              <input type="checkbox" /> 92 Pulau-pulau Kecil Terluar di Indonesia <br/>
              <input type="checkbox" /> Aceh Dalam Angka, BPS <br/>
              <input type="checkbox" /> Akses Penduduk terhadap Air Minum dan Sanitasi, 2007-2011 <br/>
              <input type="checkbox" /> Akses Rumah Tangga terhadap Sanitasi Layak di Perkotaan dan Perdesaan <br/>
              <input type="checkbox" /> Akses RumahTangga terhadap Air Minum Layak di Perkotaan dan Perdesaan Menurut Provinsi Tahun 2012 <br/>
              <input type="checkbox" /> Akuisi Alutsista TNI 2004-2013 <br/>
              <input type="checkbox" /> Aliran Investasi Langsung Neo (NET FDI) <br/>
              <input type="checkbox" /> Aliran Investasi Masuk Di Indonesia (FDI Inflows) Berdasarkan Sektor <br/>
              <input type="checkbox" /> Alokasi Pagu Definitif Kementerian Agama, Tahun 2005-2011 <br/>
            </div>
          </div>
        </div> 
        <div class="form-group row mb-3">
          <label for="tags" class="col-sm-2 col-form-label">Kata Kunci</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="tags" name="tags">
          </div>
        </div> 
        
        <hr>
        <legend>Dataset Summary</legend>
        <div class="form-group row mb-3">
          <label for="time_period" class="col-sm-2 col-form-label">Periode</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="time_period" name="time_period">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="frequency" class="col-sm-2 col-form-label">Frekuensi</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="frequency" name="frequency">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="released_at" class="col-sm-2 col-form-label">Tanggal Dirilis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="released_at" name="released_at">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="next_update" class="col-sm-2 col-form-label">Pembaruan Selanjutnya</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="next_update" name="next_update">
          </div>
        </div>
        
        <hr>
        <legend>Data Coverage</legend>
        <div class="form-group row mb-3">
          <label for="unit" class="col-sm-2 col-form-label">Unit Analysis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="unit" name="unit">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="granularity" class="col-sm-2 col-form-label">Granularity</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="granularity" name="granularity">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="geo_coverage" class="col-sm-2 col-form-label">Cakupan Geografis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="geo_coverage" name="geo_coverage">
          </div>
        </div>
                  
        <hr>
        <legend>External Links</legend>
        <div class="form-group row mb-3">
          <label for="ext_link_name" class="col-sm-2 col-form-label">Nama Tautan</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="ext_link_name" name="ext_link_name">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="ext_link_source" class="col-sm-2 col-form-label">Sumber Tautan</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="ext_link_source" name="ext_link_source">
          </div>
        </div>

        <hr>
        <legend>Files</legend>
        <div class="form-group row mb-3">
          <label for="ext_link_source" class="col-sm-2 col-form-label">Upload File</label>
          <div class="col-sm-10">
            <input class="form-control p-1" type="file" id="formFileMultiple" multiple>
          </div>
        </div>
        <table class="table table-bordered fields-table" style="word-break: break-word;">
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Impor 2016.zip
            </td>
            <td class="text-center col-1">
              18,90 MB
            </td>
            <td class="text-center">
              <a href="#">
                <button type="button" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
            </td>
          </tr>
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Exspor 2019.zip
            </td>
            <td class="text-center col-1">
              10,99 MB
            </td>
            <td class="text-center">
              <a href="#">
                <button type="button" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
            </td>
          </tr>
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Exspor 2018.zip
            </td>
            <td class="text-center col-1">
              11,18 MB
            </td>
            <td class="text-center">
              <a href="#">
                <button type="button" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
              </a>
            </td>
          </tr>
        </table>
        <div class="bd-example">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a href="{{ url('datadasar') }}">
            <button type="button" class="btn btn-secondary btn-sm">Batal</button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    
  </script>
@endpush