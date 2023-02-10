<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Work Order Report </title>
</head>
<body>
	<style type="text/css">
    @page { margin: 50px 50px 50px 50px; }
    #header { 
      position: fixed; 
      left: 0px; 
      top: -70px; 
      right: 0px;  
      text-align: center; 
    }
    #detail { 
      position: fixed; 
      left: 0px; 
      top: -60px; 
      right: 0px;  
      text-align: center; 
    }
    .pindah{
      display: block;
      page-break-before: always;
    }
    table.minimalistBlack td, table.minimalistBlack th {
      border: 0.5px solid #000000;
      vertical-align: center;
      padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px;
    }
    table.minimalistBlack tbody td {
      font-size: 14px;
      word-wrap:break-word;
    }
    table.minimalistBlack {
      width: 816.4px;
      border-spacing: 0px;
      
    }
    table.borderless td, table.borderless th {
      /* border-top: 0.5px solid #000000; */
      
      /* border-right: 0.5px solid #000000; */
      vertical-align: center;
      padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px;
    }
    table.borderless tbody td {
      font-size: 13px;
      word-wrap:break-word;
      border:1px solid;
      height: 50px;
      
    }
    table.borderless {
      width: 816.4px;
      border-spacing: 0px;
      border-collapse: collapse;
      
    }
    .noborder tr td{
      border:none;
      vertical-align: center;
    }
    th {
      font-weight: bold;
      font-size: 14px;
      text-align: center; 
    }
	</style>
	

	<!--------------- INI UNTUK PRINT TEMPLATE --------------->
  <!-- table1 -->
  @php($itrnow = 0)  
@if($data->wo_repair_type == 'manual')
  @php($counter = 0)
  @php($counter2 = 0)
  @php($currenttype = '')
  @php($batasakhir = 6)
  @php($counternow=0)
  @php($counterheader = 1)
  @php($countercheck = 0)
  @php($loopnow = 0)
  @include('workorder.pdfprint2-header')
    <table style="width:710px; height:690px; margin-left:-0.5cm;margin-bottom:0px;"class="borderless">
      <tr>
        <td style="width: 100px;height:20px">
          <p style="margin:0;"><b>Nama Mesin</b></p>
          <p style="margin:0;"><b>Lokasi</b></p>
        </td>
        <td style="width: 15px;height:20px" >
          <p style="margin:0;"><b>: </b></p>
          <p style="margin:0;"><b>: </b></p>
        </td>
        <td style="width: 400px;height:20px" colspan="6">
          <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
          <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
        </td>

        <td style="width: 65.3px;text-align:center" rowspan="12" >
          <p ><b>Kondisi Abnormal</b></p>
        </td>
      </tr>
      <tr>
        <td style="width: 100px;height:30px">
          <p style="margin-bottom:0;"><b>Frekuensi</b></p>
        </td>
        <td style="width: 15px;height:30px" >
          <p style="margin-bottom:0;"><b>: </b></p>
        </td>
        <td style="width: 400px;height:30px" colspan="6">
          <p style="margin-bottom:0;"><b> </b></p>
        </td>
      </tr>
      <tr>
        <td style="width: 100px;height:30px">
          <p style="margin:0;"><b>Tipe/Model</b></p>
          <p style="margin:0;"><b>No. Serial</b></p>
        </td>
        <td style="width: 15px;height:30px"  >
          <p style="margin:0;"><b>: </b></p>
          <p style="margin:0;"><b>: </b></p>
        </td>
        <td style="width: 260px;height:30px" colspan="2" >
          <p style="margin:0;"><b>{{$data->asset_type}} </b></p>
          <p style="margin:0;"><b>{{$data->asset_sn}} </b></p>
        </td>
        <td style="width: 70px;height:30px" >
          <p style="margin:0;"><b>Tahun </b></p>
          <p style="margin:0;"><b>Daya </b></p>
        </td>
        <td style="width: 100px;height:30px" colspan="3" >
          <p style="margin:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
          <p style="margin:0;"><b> </b></p>
        </td>
      </tr>
      <tr>
        <td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
      <tr>
        <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
        <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
        <td rowspan="2" style="text-align: center;">Standard</td>
        <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
        
        <td rowspan="8" colspan="2" style="text-align: center;">Tindakan Lanjutan</td>
      </tr>
      <tr>
        <td style="text-align:center;height:20px;margin:0px">Baik</td>
        <td style="text-align:center;height:20px;margin:0px">Tidak</td>
      </tr>
  @foreach($datamanual as $dm)
    @php(++$loopnow)
    @if($counter != $batasakhir)
      <tr>
        <td colspan="2" style="margin-top:0;height:55px">
        @if($dm->wo_manual_part == null)
          <p style="margin:0px;font-size: 12px"><b></b></p>
        @else
          <p style="margin:0px;font-size: 12px"><b>{{$dm->wo_manual_part}}</b></p>
        @endif
        </td>
        <td style="margin-top:0;height:55px">
          <p style="margin:0px;font-size: 12px"><b>{{$dm->wo_manual_desc}}</b></p>
        </td>
        <td style="margin-top:0;height:55px">
          <p style="margin:0px;font-size: 12px"><b>-</b></p>
        </td>
        <td style="text-align:center;margin-top:0;height:55px">
        @if(substr($dm->wo_manual_flag,0,1) == 'y')
          <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)" checked>
        @else
          <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
        @endif
        </td>
        <td style="text-align:center;margin-top:0;height:55px">
        @if(substr($dm->wo_manual_flag,0,1) == 'n')
          <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)" checked>
        @else
          <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
        @endif
        </td>
          @php($countercheck += 1)
          
      </tr>
      @php($counter += 1)
      @php($counternow +=1)
      @if($loopnow == $countdb))
          @if(($counter) != $batasakhir)
                
            @php($selisihcount = $batasakhir - $counter)
            @for($i = 0; $i < $selisihcount;$i++)
              <tr>
                <td colspan="2" style="margin-top:0;height:55px;">
                </td>
                <td style="margin-top:0;height:55px;">
                </td>
                <td style="margin-top:0; height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
              </tr>
              @php($counter += 1)    
            @endfor
            <tr>
              <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
              Safety Note:
              </td>
            </tr>
              <tr>
                <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
                Gunakan "LOTTO" demi keamanan dalam bekerja
                </td>
              </tr>
            </table>
            @if($loopnow == $countdb)
            <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm"class="borderless">
            @else
            <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm;page-break-after:always"class="borderless">
            @endif
            
            @include('workorder.pdfprint2-footer') 
          
          @endif
        @endif
        @else if($counter == $batasakhir && $loopnow != $countdb)
      <tr>
        <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
        Safety Note:
        </td>
        </tr>
        <tr>
        <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
        Gunakan "LOTTO" demi keamanan dalam bekerja
        </td>
        </tr>
        </table>
        <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm;page-break-after:always"class="borderless">
        @include('workorder.pdfprint2-footer')
        @php($counter = 0)
        @include('workorder.pdfprint2-header')
      <table style="width:710px; height:690px; margin-left:-0.5cm;margin-bottom:0px;"class="borderless">
        <tr>
          <td style="width: 100px;height:20px">
            <p style="margin:0;"><b>Nama Mesin</b></p>
            <p style="margin:0;"><b>Lokasi</b></p>
          </td>
          <td style="width: 15px;height:20px" >
            <p style="margin:0;"><b>: </b></p>
            <p style="margin:0;"><b>: </b></p>
          </td>
          <td style="width: 400px;height:20px" colspan="6">
            <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
            <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
          </td>

          <td style="width: 65.3px;text-align:center" rowspan="12" >
            <p ><b>Kondisi Abnormal</b></p>
          </td>
        </tr>
        <tr>
          <td style="width: 100px;height:30px">
            <p style="margin-bottom:0;"><b>Frekuensi</b></p>
          </td>
          <td style="width: 15px;height:30px" >
            <p style="margin-bottom:0;"><b>: </b></p>
          </td>
          <td style="width: 400px;height:30px" colspan="6">
            <p style="margin-bottom:0;"><b> </b></p>
          </td>
        </tr>
        <tr>
          <td style="width: 100px;height:30px">
            <p style="margin:0;"><b>Tipe/Model</b></p>
            <p style="margin:0;"><b>No. Serial</b></p>
          </td>
          <td style="width: 15px;height:30px"  >
            <p style="margin:0;"><b>: </b></p>
            <p style="margin:0;"><b>: </b></p>
          </td>
          <td style="width: 260px;height:30px" colspan="2" >
            <p style="margin:0;"><b>{{$data->asset_type}} </b></p>
            <p style="margin:0;"><b>{{$data->asset_sn}} </b></p>
          </td>
          <td style="width: 70px;height:30px" >
            <p style="margin:0;"><b>Tahun </b></p>
            <p style="margin:0;"><b>Daya </b></p>
          </td>
          <td style="width: 100px;height:30px" colspan="3" >
            <p style="margin:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
            <p style="margin:0;"><b> </b></p>
          </td>
        </tr>
        <tr>
          <td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
        <tr>
          <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
          <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
          <td rowspan="2" style="text-align: center;">Standard</td>
          <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
          
          <td rowspan="8" colspan="2" style="text-align: center;">Tindakan Lanjutan</td>
        </tr>
        <tr>
          <td style="text-align:center;height:20px;margin:0px">Baik</td>
          <td style="text-align:center;height:20px;margin:0px">Tidak</td>
        </tr>
        <tr>
          <td colspan="2" style="margin-top:0;height:55px">
          @if($dm->wo_manual_part == null)
            <p style="margin:0px;font-size: 12px"><b></b></p>
          @else
            <p style="margin:0px;font-size: 12px"><b>{{$dm->wo_manual_part}}</b></p>
          @endif
          </td>
          <td style="margin-top:0;height:55px">
            <p style="margin:0px;font-size: 12px"><b>{{$dm->wo_manual_desc}}</b></p>
          </td>
          <td style="margin-top:0;height:55px">
            <p style="margin:0px;font-size: 12px"><b>-</b></p>
          </td>
          <td style="text-align:center;margin-top:0;height:55px">
          @if(substr($dm->wo_manual_flag,0,1) == 'y')
            <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)" checked>
          @else
            <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
          @endif
          </td>
          <td style="text-align:center;margin-top:0;height:55px">
          @if(substr($dm->wo_manual_flag,0,1) == 'n')
            <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)" checked>
          @else
            <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
          @endif
            
          </td>
          @php($countercheck += 1)
        </tr>
        @if($loopnow == $countdb))
          @if(($counter) != $batasakhir)
                
            @php($selisihcount = $batasakhir - $counter)
            @for($i = 0; $i < $selisihcount;$i++)
              <tr>
                <td colspan="2" style="margin-top:0;height:55px;">
                </td>
                <td style="margin-top:0;height:55px;"> 
                </td>
                <td style="margin-top:0; height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
                
                <td style="margin-top:0; height:55px;">
                </td>
              </tr>
              @php($counter += 1)    
            @endfor
            <tr>
              <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
              Safety Note:
              </td>
            </tr>
              <tr>
                <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
                Gunakan "LOTTO" demi keamanan dalam bekerja
                </td>
              </tr>
            </table>
            
              <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm"class="borderless">
            @include('workorder.pdfprint2-footer') 
          
          @endif
        @endif
        @php($counter += 1)
    @endif
    
  @endforeach
    
@else
  @foreach($repair as $repair)
  @php($counter = 0)
  @php($counter2 = 0)
  @php($currenttype = '')
  @php($batasakhir = 6)
  @php($counternow=0)
  @php($counterheader = 1)
  @php($countercheck = 0)
  @php($loopnow = 0)
  
  @include('workorder.pdfprint2-header')
  <table style="width:710px; height:690px; margin-left:-0.5cm;margin-bottom:0px;"class="borderless">
    <tr>
      <td style="width: 100px;height:20px">
        <p style="margin:0;"><b>Nama Mesin</b></p>
        <p style="margin:0;"><b>Lokasi</b></p>
      </td>
      <td style="width: 15px;height:20px" >
        <p style="margin:0;"><b>: </b></p>
        <p style="margin:0;"><b>: </b></p>
      </td>
      <td style="width: 400px;height:20px" colspan="6">
        <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
        <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
      </td>

      <td style="width: 65.3px;text-align:center" rowspan="12" >
        <p ><b>Kondisi Abnormal</b></p>
      </td>
    </tr>
    <tr>
      <td style="width: 100px;height:30px">
        <p style="margin-bottom:0;"><b>Frekuensi</b></p>
      </td>
      <td style="width: 15px;height:30px" >
        <p style="margin-bottom:0;"><b>: </b></p>
      </td>
      <td style="width: 400px;height:30px" colspan="6">
        <p style="margin-bottom:0;"><b> </b></p>
      </td>
    </tr>
    <tr>
      <td style="width: 100px;height:30px">
        <p style="margin:0;"><b>Tipe/Model</b></p>
        <p style="margin:0;"><b>No. Serial</b></p>
      </td>
      <td style="width: 15px;height:30px"  >
        <p style="margin:0;"><b>: </b></p>
        <p style="margin:0;"><b>: </b></p>
      </td>
      <td style="width: 260px;height:30px" colspan="2" >
        <p style="margin:0;"><b>{{$data->asset_type}} </b></p>
        <p style="margin:0;"><b>{{$data->asset_sn}} </b></p>
      </td>
      <td style="width: 70px;height:30px" >
        <p style="margin:0;"><b>Tahun </b></p>
        <p style="margin:0;"><b>Daya </b></p>
      </td>
      <td style="width: 100px;height:30px" colspan="3" >
        <p style="margin:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
        <p style="margin:0;"><b> </b></p>
      </td>
    </tr>
    <tr>
      <td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
    <tr>
      <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
      <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
      <td rowspan="2" style="text-align: center;">Standard</td>
      <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
      
      <td rowspan="8" colspan="2" style="text-align: center;">Tindakan Lanjutan</td>
    </tr>
    <tr>
      <td style="text-align:center;height:20px;margin:0px">Baik</td>
      <td style="text-align:center;height:20px;margin:0px">Tidak</td>
    </tr>

    @foreach ($repair as $repair1)
      @php(++$loopnow)
      @if($currenttype !== $repair1->repm_code)
        @if(($counter + $counter2) != $batasakhir)
            @if($repair1->repm_desc == null)
              @php($counter2 +=1)
              <tr>
                <td colspan="2" style="height:55px"><p style="margin:0px"><b>{{$counterheader}}. Lain-lain</b></p></td>
                <td style="height:55px"></td>
                <td style="height:55px"></td>
                <td style="height:55px"></td>    
                <td style="height:55px"></td>
              </tr>
              @php($currenttype = $repair1->repm_code)
              @php($counterheader += 1)
            @else
                @php($counter2 +=1)
                <tr>  
                  <td colspan="2" style="height:55px"><p style="margin:0px"><b>{{$counterheader}}. {{$repair1->repm_code}} - {{$repair1->repm_desc}}</b></p></td>
                  <td style="height:55px" ></td>
                  <td style="height:55px"></td>
                  <td style="height:55px"></td>
                  
                  <td style="height:55px"></td>
                </tr>
              @php($currenttype = $repair1->repm_code)
              @php($counterheader += 1)
            @endif
          @endif
        @endif
        @if($repair1 == '' || $repair1 == null)
        @endif
        @if(($counter + $counter2) != $batasakhir)
          <tr>
            <td colspan="2" style="margin-top:0;height:55px">
            @if($repair1->spm_desc == null || $repair1->spm_desc == '')
              <p style="margin:0px;font-size: 12px"><b>-</b></p>
            @else
              <p style="margin:0px;font-size: 12px"><b>{{$repair1->spm_desc}}</b></p>
            @endif
            </td>
            <td style="margin-top:0;height:55px">
            @if($repair1->ins_desc == null || $repair1->ins_desc = '')
            <p style="margin:0px;font-size: 12px"><b>-</b></p>
            @else
              <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_desc}}</b></p>
              @endif
            </td>
            <td style="margin-top:0;height:55px">
            @if($repair1->ins_check == null || $repair1->ins_check == '')
            <p style="margin:0px;font-size: 12px"><b>-</b></p>
            @else
            <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_check}}</b></p>
            @endif
              
            </td>
            
            <td style="text-align:center;margin-top:0;height:55px">
            @if(isset($check[$itrnow])==true)
            @php($test = 'y'.$countercheck)
            @if(strpos((string)$check[$itrnow],$test)!== false)
              <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)" checked>
            
            @else
              <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
            @endif
            @else
              <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
            @endif
            </td>
            <td style="text-align:center;margin-top:0;height:55px">
            @if(isset($check[$itrnow])==true)
            @php($test2 = 'n'.$countercheck)
            @if(strpos((string)$check[$itrnow],$test2)!== false)
              <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)" checked>
              
            @else
            <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
            @endif
            @else
            <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
            @endif
            </td>
            
              @php($countercheck += 1)
            
            
          </tr>
          @php($counter += 1)
          @php($counternow +=1)
        @endif
        @if(($counter + $counter2) != $batasakhir)
          @if($loopnow == $countdb[$itrnow])    
            @php($selisihcount = $batasakhir - ($counter+$counter2))
            @for($i = 0; $i < $selisihcount;$i++)
              <tr>
                <td colspan="2" style="margin-top:0;height:55px;">
                </td>
                <td style="margin-top:0;height:55px;"> 
                </td>
                <td style="margin-top:0; height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
                <td style="text-align:center;margin-top:0;height:55px;">
                </td>
                
              </tr>
              @php($counter += 1)    
            @endfor 
          @endif
        @endif
        
        @if(($counter + $counter2) == $batasakhir)
        <tr>
        <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
        Safety Note:
        </td>
        </tr>
        <tr>
        <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
        Gunakan "LOTTO" demi keamanan dalam bekerja
        </td>
        </tr>
      </table>
      <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm;page-break-after:always"class="borderless">
      @include('workorder.pdfprint2-footer')
        @if($counternow < $countdb[$itrnow] )
        @php($counter = 0)
        @php($counter2 = 0)
        @include('workorder.pdfprint2-header')
          <table style="width:710px; height:690px; margin-left:-0.5cm;margin-bottom:0px;"class="borderless">
          <!-- <tr><td style="height: 10px;border:0px" colspan='8'>{{$data->wo_nbr}}</td></tr> -->
          <tr>
              <td style="width: 100px;height:20px">
                <p style="margin:0px;"><b>Nama Mesin</b>
                <p style="margin:0px;"><b>Lokasi</b>
              </td>
              <td style="width: 15px;height:20px" >
                <p style="margin:0;"><b>: </b></p>
                <p style="margin:0;"><b>: </b></p>
              </td>
              <td style="width: 400px;height:20px" colspan="6">
                <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
                <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
              </td>

              <td style="width: 65.3px;text-align:center" rowspan="12" >
                <p ><b>Kondisi Abnormal</b></p>
              </td>
            </tr>

            <tr>
              <td style="width: 100px;height:30px">
                <p style="margin-bottom:0;"><b>Frekuensi</b></p>
              </td>
              <td style="width: 15px;height:30px" >
                <p style="margin-bottom:0;"><b>: </b></p>
              </td>
              <td style="width: 400px;height:30px" colspan="6">
                <p style="margin-bottom:0;"><b> </b></p>
              </td>
            </tr>
            <tr>
              <td style="width: 100px;height:30px">
                <p style="margin:0;"><b>Tipe/Model</b></p>
                <p style="margin:0;"><b>No. Serial</b></p>
              </td>
              <td style="width: 15px;height:30px"  >
                <p style="margin:0;"><b>: </b></p>
                <p style="margin:0;"><b>: </b></p>
              </td>
              <td style="width: 260px;height:30px" colspan="2" >
                <p style="margin:0;"><b>{{$data->asset_type}} </b></p>
                <p style="margin:0;"><b>{{$data->asset_sn}} </b></p>
              </td>
              <td style="width: 70px;height:30px" >
                <p style="margin:0;"><b>Tahun </b></p>
                <p style="margin:0;"><b>Daya </b></p>
              </td>
              <td style="width: 100px;height:30px" colspan="3" >
                <p style="margin:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
                <p style="margin:0;"><b> </b></p>
              </td>
            </tr>
            <tr><td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
            <tr>
              <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
              <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
              <td rowspan="2" style="text-align: center;">Standard</td>
              <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
              
              <td rowspan="8" colspan="2" style="text-align: center;">Tindakan Lanjutan</td>
            </tr>
            <tr>
              <td style="text-align:center;height:20px;margin:0px">Baik</td>
              <td style="text-align:center;height:20px;margin:0px">Tidak</td>
            </tr>
            @if ($currenttype !== $repair1->repm_code)
                @if(($counter + $counter2) != $batasakhir)
                @if($repair1->repm_desc == null)
                @php($counter2 +=1)
                <tr>
                  <td colspan="2" style="height:55px"><p style="margin:0px"><b>{{$counterheader}}. Lain-lain</b></p></td>
                  <td style="height:55px"></td>
                  <td style="height:55px"></td>
                  <td style="height:55px"></td>
                  
                  <td style="height:55px"></td>
                </tr>
                @php($currenttype = $repair1->repm_code)
                @php($counterheader += 1)
                @else
                    @php($counter2 +=1)
                    <tr>  
                        <td colspan="2" style="height:55px"><p style="margin:0px"><b>{{$counterheader}}. {{$repair1->repm_code}} - {{$repair1->repm_desc}}</b></p></td>
                        <td style="height:55px"></td>
                        <td style="height:55px"></td>
                        <td style="height:55px"></td>
                        
                        <td style="height:55px"></td>
                    </tr>
                    @php($currenttype = $repair1->repm_code)
                    @php($counterheader += 1)
                  @endif
                @endif
                @endif
                @if(($counter + $counter2) != $batasakhir)
                <tr>
                  <td colspan="2" style="margin-top:0;height:55px">
                  @if($repair1->spm_desc == null || $repair1->spm_desc == '')
                    <p style="margin:0px;font-size: 12px"><b>-</b></p>
                  @else
                    <p style="margin:0px;font-size: 12px"><b>{{$repair1->spm_desc}}</b></p>
                  @endif
                  </td>
                  <td style="margin-top:0;height:55px">
                  @if($repair1->ins_desc == null || $repair1->ins_desc = '')
                  <p style="margin:0px;font-size: 12px"><b>-</b></p>
                  @else
                    <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_desc}}</b></p>
                    @endif
                  </td>
                  <td style="margin-top:0;height:55px">
                  @if($repair1->ins_check == null || $repair1->ins_check == '')
                  <p style="margin:0px;font-size: 12px"><b>-</b></p>
                  @else
                  <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_check}}</b></p>
                  @endif
                  
                  <td style="text-align:center;margin-top:0;height:55px">
                  @if(isset($check[$itrnow])==true)
                  @php($test = 'y'.$countercheck)
                  @if(strpos((string)$check[$itrnow],$test)!== false)
                  
                    <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)" checked>
                  @else
                    <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
                  @endif
                  @else
                    <input type="checkbox" style="margin-left:0.7cm;transform:scale(1.2)">
                  @endif
                  </td>
                  <td style="text-align:center;margin-top:0;height:55px">
                  @if(isset($check[$itrnow])==true)
                  @php($test2 = 'n'.$countercheck)
                  @if(strpos((string)$check[$itrnow],$test2)!== false)
                    <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)" checked>
                    
                  @else
                  <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
                  @endif
                  @else
                  <input type="checkbox" style="margin-left:0.6cm;transform:scale(1.2)">
                  @endif
                  </td>
                    
                    @php($countercheck += 1)
                  
                  
                </tr>
                @php($counter += 1)
                @php($counternow +=1)
                @if($loopnow == $countdb[$itrnow]))
                  @if(($counter + $counter2) != $batasakhir)
                        
                    @php($selisihcount = $batasakhir - ($counter+$counter2))
                    @for($i = 0; $i < $selisihcount;$i++)
                      <tr>
                        <td colspan="2" style="margin-top:0;height:55px;">
                        </td>
                        <td style="margin-top:0;height:55px;"> 
                        </td>
                        <td style="margin-top:0; height:55px;">
                        </td>
                        <td style="text-align:center;margin-top:0;height:55px;">
                        </td>
                        <td style="text-align:center;margin-top:0;height:55px;">
                        </td>
                        
                        <td style="margin-top:0; height:55px;">
                        </td>
                      </tr>
                      @php($counter += 1)    
                    @endfor 
                  
                @endif
                @if(($counter + $counter2) == $batasakhir)
                  <tr>
                    <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
                      Safety Note:
                    </td>
                  </tr>
                  <tr>
                    <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
                      Gunakan "LOTTO" demi keamanan dalam bekerja
                    </td>
                  </tr>
                </table>
                <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm;page-break-after:always"class="borderless">
                @include('workorder.pdfprint2-footer')
                
                @endif
              @endif
            @endif    
        @endif
      @endif
          
  @endforeach
  @if($itrnow < $countrepairitre)
    @php($itrnow +=1)
  @endif
              
  @endforeach
  @include('workorder.pdfprint2-header')
  
  <table style="width:730px; height:690px; margin-left:-0.5cm;margin-bottom:0px;"class="borderless">
  
  <tr>
    <td style="width: 100px;height:20px">
      <p style="margin:0;"><b>Nama Mesin</b></p>
      <p style="margin:0;"><b>Lokasi</b></p>
    </td>
    <td style="width: 15px;height:20px" >
      <p style="margin:0;"><b>: </b></p>
      <p style="margin:0;"><b>: </b></p>
    </td>
    <td style="width: 400px;height:20px" colspan="6">
      <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
      <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
    </td>

    <td style="width: 65.3px;text-align:center" rowspan="12" >
      <p ><b>Kondisi Abnormal</b></p>
    </td>
  </tr>
  <tr>
    <td style="width: 100px;height:30px">
      <p style="margin-bottom:0;"><b>Frekuensi</b></p>
    </td>
    <td style="width: 15px;height:30px" >
      <p style="margin-bottom:0;"><b>: </b></p>
    </td>
    <td style="width: 400px;height:30px" colspan="6">
      <p style="margin-bottom:0;"><b> </b></p>
    </td>
  </tr>
  <tr>
    <td style="width: 100px;height:30px">
      <p style="margin:0;"><b>Tipe/Model</b></p>
      <p style="margin:0;"><b>No. Serial</b></p>
    </td>
    <td style="width: 15px;height:30px"  >
      <p style="margin:0;"><b>: </b></p>
      <p style="margin:0;"><b>: </b></p>
    </td>
    <td style="width: 260px;height:30px" colspan="2" >
      <p style="margin:0;"><b>{{$data->asset_type}} </b></p>
      <p style="margin:0;"><b>{{$data->asset_sn}} </b></p>
    </td>
    <td style="width: 70px;height:30px" >
      <p style="margin:0;"><b>Tahun </b></p>
      <p style="margin:0;"><b>Daya </b></p>
    </td>
    <td style="width: 100px;height:30px" colspan="3" >
      <p style="margin:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
      <p style="margin:0;"><b> </b></p>
    </td>
  </tr>
  <tr>
    <td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
  <tr>
    <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
    <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
    <td rowspan="2" style="text-align: center;">Standard</td>
    <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
    
    <td rowspan="8" colspan="2" style="text-align: center;">Tindakan Lanjutan</td>
  </tr>
  <tr>
    <td style="text-align:center;height:20px;margin:0px">Baik</td>
    <td style="text-align:center;height:20px;margin:0px">Tidak</td>
  </tr>
  <tr>
    <td colspan="3" style="margin-top:0;height:55px;"><p><b>{{$counterheader}}. SPARE PART CONSUMPTION</b></p>
    </td>
    <td style="margin-top:0; height:55px;">
    </td>
    <td style="text-align:center;margin-top:0;height:55px;">
    </td>
    <td style="text-align:center;margin-top:0;height:55px;">
    </td>

            
  </tr>
  <tr>
    <td colspan="2" style="margin-top:0;height:55px;">Item
    </td>
    <td style="margin-top:0;height:55px;"> Spesifikasi
    </td>
    <td style="margin-top:0; height:55px;"> Interval
    </td>
    <td style="text-align:center;margin-top:0;height:55px;">Qty
    </td>
    <td style="text-align:center;margin-top:0;height:55px;">
    </td>

    
  </tr>
  @for($po = 0; $po < 4; $po++)
    <tr>
      <td colspan="2" style="margin-top:0;height:55px;">{{$po+1}}.
      </td>
      <td style="margin-top:0;height:55px;"> 
      </td>
      <td style="margin-top:0; height:55px;"> 
      </td>
      <td style="text-align:center;margin-top:0;height:55px;">
      </td>
      <td style="text-align:center;margin-top:0;height:55px;">
      </td>

    
    </tr>   
  @endfor
  <tr>
    <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
      Safety Note:
    </td>
  </tr>
  <tr>
    <td style="height:10px;font-family:sans-serif;border-top:0px;margin:0px;padding:0px" colspan="9">
      Gunakan "LOTTO" demi keamanan dalam bekerja
    </td>
  </tr>
    
  </table>
  <table style="width:730px; height:140px;margin-top:-3.1cm; margin-left:-0.5cm;margin-bottom:0cm;"class="borderless">
  @include('workorder.pdfprint2-footer')
  @endif
</body>
</html>
