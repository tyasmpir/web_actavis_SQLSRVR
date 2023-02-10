<!DOCTYPE html>
<html>
<head>
	<title>Work Order Requisition </title>
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
  @foreach($repair as $repair)
  @php($counter = 0)
  @php($counter2 = 0)
  @php($currenttype = '')
  @php($batasakhir = 9)
  @php($counternow=0)
  @php($counterheader = 1)
  @php($countercheck = 0)
  @php($loopnow = 0)


  @include('workorder.pdfprint2-header')
<table style="width:740px; height:690px; margin-left:-1.2cm;margin-bottom:0px;"class="borderless">
<!-- <tr><td style="height: 10px;border:0px" colspan='8'>{{$data->wo_nbr}}</td></tr> -->
<tr>
            <td style="width: 100px;">
              <p style="margin:0;"><b>Nama Mesin</b></p>
              <p style="margin:0;"><b>Lokasi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin:0;"><b>: </b></p>
              <p style="margin:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
              <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
            </td>

            <td style="width: 100px;text-align:center" rowspan="16" >
              <p ><b>Kondisi Abnormal</b></p>
            </td>
          </tr>

          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Frekuensi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin-bottom:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin-bottom:0;"><b> </b></p>
            </td>
          </tr>
          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Tipe/Model</b></p>
              <p style="margin-top:0;"><b>No. Serial</b></p>
            </td>
            <td style="width: 15px;"  >
              <p style="margin-bottom:0;"><b>: </b></p>
              <p style="margin-top:0;"><b>: </b></p>
            </td>
            <td style="width: 260px;" colspan="2" >
              <p style="margin-bottom:0;"><b>{{$data->asset_type}} </b></p>
              <p style="margin-top:0;"><b>{{$data->asset_sn}} </b></p>
            </td>
            <td style="width: 70px;" >
              <p style="margin-bottom:0;"><b>Tahun </b></p>
              <p style="margin-top:0;"><b>Daya </b></p>
            </td>
            <td style="width: 100px;" colspan="3" >
              <p style="margin-bottom:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
              <p style="margin-top:0;"><b> </b></p>
            </td>
          </tr>
  <tr><td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
  <tr>
    <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
    <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
    <td rowspan="2" style="text-align: center;">Standard</td>
    <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
    <td rowspan="2" style="text-align: center;">Tools</td>
    <td rowspan="12" style="text-align: center;">Tindakan Lanjutan</td>
  </tr>
  <tr>
    <td style="text-align:center;height:20px;margin:0px">Baik</td>
    <td style="text-align:center;height:20px;margin:0px">Tidak</td>
  </tr>

@foreach ($repair as $repair1)
    @php(++$loopnow)
  @if($currenttype !== $repair1->insg_desc)
  @if(($counter + $counter2) != $batasakhir)
        @if($repair1->insg_desc == null)
          @php($counter2 +=1)
          <tr>
            <td colspan="2" style="height:40px"><p style="margin:0px"><b>{{$counterheader}}. Lain-lain</b></p></td>
            <td style="height:40px"></td>
            <td style="height:40px"></td>
            <td style="height:40px"></td>
            <td style="height:40px"></td>
            <td style="height:40px"></td>
          </tr>
          @php($currenttype = $repair1->insg_desc)
          @php($counterheader += 1)
        @else
            @php($counter2 +=1)
            <tr>  
              <td colspan="2" style="height:40px"><p style="margin:0px"><b>{{$counterheader}}.{{$repair1->insg_desc}}</b></p></td>
              <td style="height:40px" ></td>
              <td style="height:40px"></td>
              <td style="height:40px"></td>
              <td style="height:40px"></td>
              <td style="height:40px"></td>
            </tr>
          @php($currenttype = $repair1->insg_desc)
          @php($counterheader += 1)
        @endif
      @endif
    @endif
    @if(($counter + $counter2) != $batasakhir)
      <tr>
        <td colspan="2" style="margin-top:0;height:40px">
          <p style="margin:0px;font-size: 12px"><b>{{$repair1->spm_desc}}</b></p>
        </td>
        <td style="margin-top:0;height:40px">
          <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_desc}}</b></p>
        </td>
        <td style="margin-top:0;height:40px">
          <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_check_mea}}</b></p>
        </td>
        
        <td style="text-align:center;margin-top:0;height:40px">
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
        <td style="text-align:center;margin-top:0;height:40px">
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
        @if($repair1->ins_tool == '')
          <td style="margin-top:0;height:40px"><p style="margin:0px;font-size: 12px"><b>-</b></p></td>;
        @else
          <td style="margin-top:0;height:40px"><p style="margin:0px;font-size: 12px">{{$repair1->ins_tool}}</p></td>;
        @endif
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
            <td colspan="2" style="margin-top:0;height: 40px;">
            </td>
            <td style="margin-top:0;height: 40px;"> 
            </td>
            <td style="margin-top:0; height: 40px;">
            </td>
            <td style="text-align:center;margin-top:0;height: 40px;">
            </td>
            <td style="text-align:center;margin-top:0;height: 40px;">
            </td>
            <td style="margin-top:0; height: 40px;">
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
    @include('workorder.pdfprint2-footer')
      @if($counternow < $countdb[$itrnow] )
      @php($counter = 0)
      @php($counter2 = 0)
      @include('workorder.pdfprint2-header')
        <table style="width:740px; height:690px; margin-left:-1.2cm;margin-bottom:0px;"class="borderless">
        <!-- <tr><td style="height: 10px;border:0px" colspan='8'>{{$data->wo_nbr}}</td></tr> -->
        <tr>
            <td style="width: 100px;">
              <p style="margin:0;"><b>Nama Mesin</b></p>
              <p style="margin:0;"><b>Lokasi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin:0;"><b>: </b></p>
              <p style="margin:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
              <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
            </td>

            <td style="width: 100px;text-align:center" rowspan="16" >
              <p ><b>Kondisi Abnormal</b></p>
            </td>
          </tr>

          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Frekuensi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin-bottom:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin-bottom:0;"><b> </b></p>
            </td>
          </tr>
          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Tipe/Model</b></p>
              <p style="margin-top:0;"><b>No. Serial</b></p>
            </td>
            <td style="width: 15px;"  >
              <p style="margin-bottom:0;"><b>: </b></p>
              <p style="margin-top:0;"><b>: </b></p>
            </td>
            <td style="width: 260px;" colspan="2" >
              <p style="margin-bottom:0;"><b>{{$data->asset_type}} </b></p>
              <p style="margin-top:0;"><b>{{$data->asset_sn}} </b></p>
            </td>
            <td style="width: 70px;" >
              <p style="margin-bottom:0;"><b>Tahun </b></p>
              <p style="margin-top:0;"><b>Daya </b></p>
            </td>
            <td style="width: 100px;" colspan="3" >
              <p style="margin-bottom:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
              <p style="margin-top:0;"><b> </b></p>
            </td>
          </tr>
          <tr><td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
          <tr>
            <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
            <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
            <td rowspan="2" style="text-align: center;">Standard</td>
            <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
            <td rowspan="2" style="text-align: center;">Tools</td>
            <td rowspan="12" style="text-align: center;">Tindakan Lanjutan</td>
          </tr>
          <tr>
            <td style="text-align:center;height:20px;margin:0px">Baik</td>
            <td style="text-align:center;height:20px;margin:0px">Tidak</td>
          </tr>
          @if ($currenttype !== $repair1->insg_desc)
              @if(($counter + $counter2) != $batasakhir)
              @if($repair1->insg_desc == null)
              @php($counter2 +=1)
              <tr>
                <td colspan="2" style="height:40px"><p style="margin:0px"><b>{{$counterheader}}. Lain-lain</b></p></td>
                <td style="height:40px"></td>
                <td style="height:40px"></td>
                <td style="height:40px"></td>
                <td style="height:40px"></td>
                <td style="height:40px"></td>
              </tr>
              @php($currenttype = $repair1->insg_desc)
              @php($counterheader += 1)
              @else
                  @php($counter2 +=1)
                  <tr>  
                      <td colspan="2" style="height:40px"><p style="margin:0px"><b>{{$counterheader}}.{{$repair1->spt_desc}}</b></p></td>
                      <td style="height:40px"></td>
                      <td style="height:40px"></td>
                      <td style="height:40px"></td>
                      <td style="height:40px"></td>
                      <td style="height:40px"></td>
                  </tr>
                  @php($currenttype = $repair1->insg_desc)
                  @php($counterheader += 1)
                @endif
              @endif
              @endif
              @if(($counter + $counter2) != $batasakhir)
              <tr>
                <td colspan="2" style="margin-top:0;height:40px">
                  <p style="margin:0px;font-size: 12px"><b>{{$repair1->spm_desc}}</b></p>

                </td>
                <td style="margin-top:0;height:40px">
                  <p style="margin:0px;font-size: 12px"><b>{{$repair1->ins_desc}}</b></p>
                </td>
                <td style="margin-top:0;height:40px">
                  <p style="margin:0px;font-size: 12px"><b>{{$repair1->repdet_std}}</b></p>
                </td>
                
                <td style="text-align:center;margin-top:0;height:40px">
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
                <td style="text-align:center;margin-top:0;height:40px">
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
                @if($repair1->ins_tool == '')
                  <td style="margin-top:0;height:40px"><p style="margin:0px;font-size: 12px"><b>-</b></p></td>;
                @else
                  <td style="margin-top:0;height:40px"><p style="margin:0px;font-size: 12px">{{$repair1->ins_tool}}</p></td>;
                @endif  
                  @php($countercheck += 1)
                
                
              </tr>
              @php($counter += 1)
              @php($counternow +=1)
              @if($loopnow == $countdb[$itrnow]))
                @if(($counter + $counter2) != $batasakhir)
                      
                  @php($selisihcount = $batasakhir - ($counter+$counter2))
                  @for($i = 0; $i < $selisihcount;$i++)
                    <tr>
                      <td colspan="2" style="margin-top:0;height: 40px;">
                      </td>
                      <td style="margin-top:0;height: 40px;"> 
                      </td>
                      <td style="margin-top:0; height: 40px;">
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="margin-top:0; height: 40px;">
                      </td>
                      <td style="margin-top:0; height: 40px;">
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
@include('workorder.pdfprint2-header')
<table style="width:740px; height:690px; margin-left:-1.2cm;margin-bottom:0px;"class="borderless">
<!-- <tr><td style="height: 10px;border:0px" colspan='8'>{{$data->wo_nbr}}</td></tr> -->
<tr>
            <td style="width: 100px;">
              <p style="margin:0;"><b>Nama Mesin</b></p>
              <p style="margin:0;"><b>Lokasi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin:0;"><b>: </b></p>
              <p style="margin:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin:0;"><b>{{$data->asset_desc}} </b></p>
              <p style="margin:0;"><b>{{$data->loc_desc}} </b></p>
            </td>

            <td style="width: 100px;text-align:center" rowspan="16" >
              <p ><b>Kondisi Abnormal</b></p>
            </td>
          </tr>
          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Frekuensi</b></p>
            </td>
            <td style="width: 15px;" >
              <p style="margin-bottom:0;"><b>: </b></p>
            </td>
            <td style="width: 400px;" colspan="6">
              <p style="margin-bottom:0;"><b> </b></p>
            </td>
          </tr>
          <tr>
            <td style="width: 100px">
              <p style="margin-bottom:0;"><b>Tipe/Model</b></p>
              <p style="margin-top:0;"><b>No. Serial</b></p>
            </td>
            <td style="width: 15px;"  >
              <p style="margin-bottom:0;"><b>: </b></p>
              <p style="margin-top:0;"><b>: </b></p>
            </td>
            <td style="width: 260px;" colspan="2" >
              <p style="margin-bottom:0;"><b>{{$data->asset_type}} </b></p>
              <p style="margin-top:0;"><b>{{$data->asset_sn}} </b></p>
            </td>
            <td style="width: 70px;" >
              <p style="margin-bottom:0;"><b>Tahun </b></p>
              <p style="margin-top:0;"><b>Daya </b></p>
            </td>
            <td style="width: 100px;" colspan="3" >
              <p style="margin-bottom:0;"><b>{{date('Y',strtotime($data->asset_prc_date))}} </b></p>
              <p style="margin-top:0;"><b> </b></p>
            </td>
          </tr>
          <tr>
            <td colspan="8" style="height:20px" ><p style="margin:0px;"><b>Tugas : </b></p></td></tr>
            <tr>
              <td colspan="2" rowspan="2" style="text-align: center;">Part</td>
              <td rowspan="2" style="text-align: center;">Deskripsi Pekerjaan</td>
              <td rowspan="2" style="text-align: center;">Standard</td>
              <td colspan="2" style="text-align: center;margin:0;height:20px">Kondisi</td>
              <td rowspan="2" style="text-align: center;">Tools</td>
              <td rowspan="12" style="text-align: center;">Tindakan Lanjutan</td>
            </tr>
            <tr>
              <td style="text-align:center;height:20px;margin:0px">Baik</td>
              <td style="text-align:center;height:20px;margin:0px">Tidak</td>
            </tr>
            <tr>
                      <td colspan="3" style="margin-top:0;height: 40px;"><p><b>3. SPARE PART CONSUMPTION</b></p>
                      </td>
                      <td style="margin-top:0; height: 40px;">
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="margin-top:0; height: 40px;">
                      </td>
                      
                    </tr>
                    <tr>
                      <td colspan="2" style="margin-top:0;height: 40px;">Item
                      </td>
                      <td style="margin-top:0;height: 40px;"> Spesifikasi
                      </td>
                      <td style="margin-top:0; height: 40px;"> Interval
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">Qty
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="margin-top:0; height: 40px;">
                      </td>
                      
                    </tr>
                    @for($po = 0; $po < 7; $po++)
                      <tr>
                      <td colspan="2" style="margin-top:0;height: 40px;">{{$po+1}}.
                      </td>
                      <td style="margin-top:0;height: 40px;"> 
                      </td>
                      <td style="margin-top:0; height: 40px;"> 
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="text-align:center;margin-top:0;height: 40px;">
                      </td>
                      <td style="margin-top:0; height: 40px;">
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
              @include('workorder.pdfprint2-footer')              
@endforeach


</body>
</html>
