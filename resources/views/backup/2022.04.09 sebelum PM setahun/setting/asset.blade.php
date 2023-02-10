@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Asset Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<!-- 
    Daftar Perubahan :
    
    A210929 : penambahan start date untuk measurement
    A211102 : calender dirubah dari hari ke bulan
 -->

<!-- Bagian Searching -->
<div class="container-fluid mb-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item has-treeview bg-black">
<a href="#" class="nav-link mb-0 p-0"> 
<p>
  <label class="col-md-2 col-form-label text-md-left" style="color:white;">{{ __('Click here to search') }}</label>
  <i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">
<li class="nav-item">
<div class="col-12 form-group row">
    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Code</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_code" class="form-control" name="s_code">
            <option value=""></option>
            @foreach($datasearch as $sdata)
                <option value="{{$sdata->asset_code}}">{{$sdata->asset_code}} - {{$sdata->asset_desc}}</option>
            @endforeach
        </select>
    </div>
    
    <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_loc" class="form-control" name="s_loc" required>
            <option value="">--Select Data--</option>
            @foreach($dataloc as $dl)
                <option value="{{$dl->loc_site}}.{{$dl->loc_code}}">{{$dl->loc_site}} : {{$dl->loc_code}} -- {{$dl->loc_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_type" class="col-md-2 col-sm-2 col-form-label text-md-right">Type</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_type" class="form-control" name="s_type" required>
            <option value="">--Select Data--</option>
            @foreach($dataastype as $stype)
                <option value="{{$stype->astype_code}}">{{$stype->astype_code}} -- {{$stype->astype_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="s_group" class="col-md-2 col-sm-2 col-form-label text-md-right">Group</label>
    <div class="col-md-4 mb-2 input-group">
        <select id="s_group" class="form-control" name="s_group" required>
            <option value="">--Select Data--</option>
            @foreach($dataasgroup as $sgroup)
                <option value="{{$sgroup->asgroup_code}}">{{$sgroup->asgroup_code}} -- {{$sgroup->asgroup_desc}}</option>
            @endforeach
        </select>
    </div>
    <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"/> 
    </div>
    <div class="col-md-2 col-sm-4 mb-2 input-group">
        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
    </div>
    <input type="hidden" id="tmpcode"/>
    <input type="hidden" id="tmploc"/>
    <input type="hidden" id="tmptype"/>
    <input type="hidden" id="tmpgroup"/>
</div>
</li>
</ul>
</li>
</ul>
</div>

<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Code</th>
                <th width="25%">Description</th>
                <th width="15%">Type</th>
                <th width="15%">Group</th>
                <th width="5%">Mea</th>
                <th width="20%">Location</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-asset')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asset_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createasset" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" autofocus maxlength="20" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="50" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_um" class="col-md-4 col-form-label text-md-right">UM </label>
                        <div class="col-md-6">
                            <input id="t_um" type="text" class="form-control" name="t_um" autocomplete="off" autofocus maxlength="8" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_type" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-6">
                            <select id="t_type" class="form-control" name="t_type" >
                                <option value="">--Select Data--</option>
                                @foreach($dataastype as $t)
                                    <option value="{{$t->astype_code}}">{{$t->astype_code}} -- {{$t->astype_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_group" class="col-md-4 col-form-label text-md-right">Group</label>
                        <div class="col-md-6">
                            <select id="t_group" class="form-control" name="t_group" >
                                <option value="">--Select Data--</option>
                                @foreach($dataasgroup as $g)
                                    <option value="{{$g->asgroup_code}}">{{$g->asgroup_code}} -- {{$g->asgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_site" class="col-md-4 col-form-label text-md-right">Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_site" class="form-control" name="t_site" required>
                                <option value="">--Select Data--</option>
                                @foreach($datasite as $s)
                                    <option value="{{$s->site_code}}">{{$s->site_code}} -- {{$s->site_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-4 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_loc" class="form-control" name="t_loc" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_sn" class="col-md-4 col-form-label text-md-right">Serial Number</label>
                        <div class="col-md-6">
                            <input id="t_sn" type="text" class="form-control" name="t_sn" autocomplete="off" autofocus maxlength="25" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_daya" class="col-md-4 col-form-label text-md-right">Maintenance By</label>
                        <div class="col-md-6">
                            <input id="t_daya" type="text" class="form-control" name="t_daya" autocomplete="off" autofocus maxlength="50" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                        <div class="col-md-6">
                            <select id="t_supp" class="form-control" name="t_supp" >
                                <option value="">--Select Data--</option>
                                @foreach($datasupp as $p)
                                    <option value="{{$p->supp_code}}">{{$p->supp_code}} -- {{$p->supp_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_prc_date" class="col-md-4 col-form-label text-md-right">Purchase Date</label>
                        <div class="col-md-6">
                            <input id="t_prc_date" type="date" class="form-control" name="t_prc_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                        <div class="col-md-6">
                            <input id="t_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="t_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_mea" class="col-md-4 col-form-label text-md-right">Measurement</label>
                        <div class="col-md-6">
                            <select id="t_mea" class="form-control" name="t_mea" >
                                <option value="">--Select Data--</option>
                                <option value="C">Calendar</option>
                                <option value="M">Meter</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row divmeter" id="divmeter" style="display: none;">
                        <label for="t_meter" class="col-md-4 col-form-label text-md-right">Meter</label>
                        <div class="col-md-6">
                            <input id="t_meter" type="number" step="0.01" placeholder="0.00" class="form-control" name="t_meter" autocomplete="off" autofocus max="999999" />
                        </div>
                    </div>
                    <div class="form-group row divcal" id="divcal" style="display: none;">
                        <label for="t_cal" class="col-md-4 col-form-label text-md-right">Calendar (month)</label>
                        <div class="col-md-6">
                            <input id="t_cal" type="number" class="form-control" name="t_cal" autocomplete="off" autofocus max="9999" placeholder="0" max="12" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_tolerance" class="col-md-4 col-form-label text-md-right">Measurement Tolerance</label>
                        <div class="col-md-6">
                            <input id="t_tolerance" type="number" placeholder="0.00" class="form-control" name="t_tolerance" autocomplete="off" autofocus max="999999" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_mea_date" class="col-md-4 col-form-label text-md-right">Measurement Start Date</label>
                        <div class="col-md-6">
                            <input id="t_mea_date" type="date" class="form-control" name="t_mea_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_note" class="col-md-4 col-form-label text-md-right">Note</label>
                        <div class="col-md-6">
                            <textarea id="t_note" type="text" class="form-control" name="t_note" autocomplete="off" autofocus maxlength="200" />
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_active" class="col-md-4 col-form-label text-md-right">Active</label>
                        <div class="col-md-6">
                            <select id="t_active" class="form-control" name="t_active" >
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row " id="cdevrepairtype">
                        <label for="crepaircode" class="col-md-4 col-form-label text-md-right">Repair Type</label>
                        <div class="col-md-6">
                            <input class=" d-inline" type="radio" name="crepairtype" id="cargcheck" value="group">
                            <label class="form-check-label" for="cargcheck">
                              Repair Group
                            </label>

                            <input class="d-inline ml-5" type="radio"  name="crepairtype" id="carccheck" value="code">
                            <label class="form-check-label" for="carccheck">
                              Repair Code
                            </label>
                        </div>
                    </div>
                    <div class="form-group row " id="crepaircodediv" style="display: none;">
                        <label for="crepaircode" class="col-md-4 col-form-label text-md-right">Repair Code(Max 3) 
                            <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="crepaircode" name="crepaircode[]" class="form-control" multiple="multiple">
                            @foreach($repaircode as $rc)
                                <option value="{{$rc->repm_code}}">{{$rc->repm_code}} -- {{$rc->repm_desc}}</option>
                            @endforeach
                            </select>             
                        </div>
                    </div>
                    <div class="form-group row " id="crepairgroupdiv" style="display: none;">
                        <label for="crepairgroup" class="col-md-4 col-form-label text-md-right">Repair Group 
                            <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="crepairgroup" name="crepairgroup" class="form-control">
                            @foreach($repairgroup as $rp)
                                <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- 7-16-2021 AC -->
                    <div class="form-group row">
			            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Upload') }}</label>
			            <div class="col-md-6 input-file-container">  
			                <input type="file" class="form-control" name="filename[]" multiple>
			            </div>
			        </div>

                    <!-- 7-29-2021 -->
                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                        <div class="col-md-6 input-file-container">  
                            <input type="file" class="form-control" name="t_image">
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editasset" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="50" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_um" class="col-md-4 col-form-label text-md-right">UM </label>
                    <div class="col-md-6">
                        <input id="te_um" type="text" class="form-control" name="te_um" autocomplete="off" autofocus maxlength="8" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_type" class="col-md-4 col-form-label text-md-right">Type</label>
                    <div class="col-md-6">
                        <select id="te_type" class="form-control" name="te_type" >
                            <option value="">--Select Data--</option>
                            @foreach($dataastype as $o)
                                <option value="{{$o->astype_code}}">{{$o->astype_code}} -- {{$o->astype_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_group" class="col-md-4 col-form-label text-md-right">Group</label>
                    <div class="col-md-6">
                        <select id="te_group" class="form-control" name="te_group" >
                            <option value="">--Select Data--</option>
                            @foreach($dataasgroup as $r)
                                <option value="{{$r->asgroup_code}}">{{$r->asgroup_code}} -- {{$r->asgroup_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_site" class="col-md-4 col-form-label text-md-right">Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_site" class="form-control" name="te_site" required>
                            <option value="">--Select Data--</option>
                            @foreach($datasite as $a)
                                <option value="{{$a->site_code}}">{{$a->site_code}} -- {{$a->site_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_loc" class="col-md-4 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_loc" class="form-control te_loc" name="te_loc" required>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_sn" class="col-md-4 col-form-label text-md-right">Serial Number</label>
                    <div class="col-md-6">
                        <input id="te_sn" type="text" class="form-control" name="te_sn" autocomplete="off" autofocus maxlength="25" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_daya" class="col-md-4 col-form-label text-md-right">Maintenance By</label>
                    <div class="col-md-6">
                        <input id="te_daya" type="text" class="form-control" name="te_daya" autocomplete="off" autofocus maxlength="25" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                    <div class="col-md-6">
                        <select id="te_supp" class="form-control" name="te_supp" >
                            <option value="">--Select Data--</option>
                            @foreach($datasupp as $u)
                                <option value="{{$u->supp_code}}">{{$u->supp_code}} -- {{$u->supp_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_date" class="col-md-4 col-form-label text-md-right">Purchase Date</label>
                    <div class="col-md-6">
                        <input id="te_prc_date" type="date" class="form-control" name="te_prc_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                    <div class="col-md-6">
                        <input id="te_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="te_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_mea" class="col-md-4 col-form-label text-md-right">Measurement</label>
                    <div class="col-md-6">
                        <select id="te_mea" class="form-control" name="te_mea" >
                            <option value="">--Select Data--</option>
                            <option value="C">Calendar</option>
                            <option value="M">Meter</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row divemeter" id="divemeter" style="display: none;">
                    <label for="te_meter" class="col-md-4 col-form-label text-md-right">Meter</label>
                    <div class="col-md-6">
                        <input id="te_meter" type="number" step="0.01" placeholder="0.00" class="form-control" name="te_meter" autocomplete="off" autofocus max="999999" />
                    </div>
                </div>
                <div class="form-group row divecal" id="divecal" style="display: none;">
                    <label for="te_cal" class="col-md-4 col-form-label text-md-right">Calendar (month)</label>
                    <div class="col-md-6">
                        <input id="te_cal" type="number" class="form-control" name="te_cal" autocomplete="off" autofocus max="12" placeholder="0"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_tolerance" class="col-md-4 col-form-label text-md-right">Measurement Tolerance</label>
                    <div class="col-md-6">
                        <input id="te_tolerance" type="number" placeholder="0.00" class="form-control" name="te_tolerance" autocomplete="off" autofocus max="999999" />
                    </div>
                </div>
                <div class="form-group row">
                        <label for="te_mea_date" class="col-md-4 col-form-label text-md-right">Measurement Start Date</label>
                        <div class="col-md-6">
                            <input id="te_mea_date" type="date" class="form-control" name="te_mea_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="te_note" class="col-md-4 col-form-label text-md-right">Note</label>
                    <div class="col-md-6">
                        <textarea id="te_note" type="text" class="form-control" name="te_note" autocomplete="off" autofocus maxlength="200" />
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_active" class="col-md-4 col-form-label text-md-right">Active</label>
                    <div class="col-md-6">
                        <select id="te_active" class="form-control" name="te_active" >
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="repaircode" class="col-md-4 col-form-label text-md-right">Repair Type</label>
                    <div class="col-md-6" style="vertical-align:middle;">
                        <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group">
                        <label class="form-check-label" for="argcheck">
                            Repair Group
                        </label>

                        <input class="d-inline ml-5" type="radio"  name="repairtype" id="arccheck" value="code">
                        <label class="form-check-label" for="arccheck">
                            Repair Code
                        </label>
                    </div>
                </div>
                <input type="hidden" name="te_repair" id="te_repair">
                <div class="form-group row" id="repaircodediv" style="display: none;">
                    <label for="repaircodeselect" class="col-md-4 col-form-label text-md-right">Repair Code(Max 3) 
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="repaircodeselect" name="repaircode[]" class="form-control repaircodeselect" multiple="multiple">
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row" id="repairgroupdiv" style="display: none;">
                    <label for="repairgroup" class="col-md-4 col-form-label text-md-right">Repair Group 
                        <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="repairgroup" name="repairgroup" class="form-control">
                            @foreach($repairgroup as $rp)
                                <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- 7-16-2021 AC -->
                <div class="form-group row">
                    <label for="te_file" class="col-md-4 col-form-label text-md-right">Current File</label>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                        	<thead>
                        		<tr>
                        			<th>File Name</th>
                        		</tr>
                        	</thead>
                        	<tbody id="listupload">
                        		
                        	</tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group row">
		            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Upload New') }}</label>
		            <div class="col-md-6 input-file-container">  
		                <input type="file" class="form-control" name="filename[]" multiple>
		            </div>
		        </div>

                <!-- 7-27-2021 Asset Image -->
                <div class="form-group row divefoto">
                    <label for="te_image" class="col-md-4 col-form-label text-md-right">Image</label>
                    <div class="col-md-6">
                        <input id="te_image" name="te_image" type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <div class="form-group row divefoto1">
                    <label class="col-md-4 col-form-label text-md-right"></label>
                    <div class="col-md-6">
                        <img src="" class="rounded" width="150px" id="foto1">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="te_prev" class="col-md-4 col-form-label text-md-right">Data Preventive : </label>
                </div>
                <div class="form-group row">
                    <label for="te_lastusage" class="col-md-4 col-form-label text-md-right">Last Usage</label>
                    <div class="col-md-6">
                        <input id="te_lastusage" type="text" class="form-control" name="te_lastusage" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_lastusagemtc" class="col-md-4 col-form-label text-md-right">Last Usage maintenance</label>
                    <div class="col-md-6">
                        <input id="te_lastusagemtc" type="text" class="form-control" name="te_lastusagemtc" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_lastmtc" class="col-md-4 col-form-label text-md-right">Last Maintenance</label>
                    <div class="col-md-6">
                        <input id="te_lastmtc" type="text" class="form-control" name="te_lastmtc" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_onuse" class="col-md-4 col-form-label text-md-right">WO on Use</label>
                    <div class="col-md-6">
                        <input id="te_onuse" type="text" class="form-control" name="te_onuse" readonly/>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Asset Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteasset">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_site" name="d_site">
                    <input type="hidden" id="d_loc" name="d_loc">
                    Delete Asset <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>

    	$(document).on('click', '.deleterow', function(e){
    		var data = $(this).closest('tr').find('.rowval').val();

    		$.ajax({
                url:"/deleteupload/" + data,
                success: function(data) {
                
                    $('#listupload').html('').append(data); 
                }
            })
    	});
    	

       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var code         = $(this).data('code');
           var desc         = $(this).data('desc');
           var site         = $(this).data('site');
           var loc          = $(this).data('loc');
           var um           = $(this).data('um');
           var sn           = $(this).data('sn');
           var prc_date     = $(this).data('prc_date');
           var prc_price    = $(this).data('prc_price');
           var type         = $(this).data('type');
           var group        = $(this).data('group');
           var measure      = $(this).data('measure');
           var supp         = $(this).data('supp');
           var meter        = $(this).data('meter');
           var cal          = $(this).data('cal');
           var start_mea    = $(this).data('start_mea');
           var note         = $(this).data('note');
           var daya         = $(this).data('daya');
           var active       = $(this).data('active');
           var repair_type  = $(this).data('repair_type');
           var repair       = $(this).data('repair');
           var upload 		= $(this).data('upload');
           var lastusage    = $(this).data('lastusage');
           var lastusagemtc = $(this).data('lastusagemtc');
           var lastmtc      = $(this).data('lastmtc');
           var onuse        = $(this).data('onuse');
           var tolerance    = $(this).data('tolerance');
           var assetimg    = '/uploadassetimage/' +$(this).data('assetimg');


           var uploadname = upload.substring(upload.lastIndexOf('/') + 1,upload.length);

           document.getElementById('te_code').value         = code;
           document.getElementById('te_desc').value         = desc;
           document.getElementById('te_site').value         = site;
           document.getElementById('te_um').value           = um;
           document.getElementById('te_sn').value           = sn;
           document.getElementById('te_prc_date').value     = prc_date;
           document.getElementById('te_prc_price').value    = prc_price;
           document.getElementById('te_type').value         = type;
           document.getElementById('te_group').value        = group;
           document.getElementById('te_mea').value          = measure;
           document.getElementById('te_supp').value         = supp;
           document.getElementById('te_meter').value        = meter;
           document.getElementById('te_cal').value          = cal;
           document.getElementById('te_mea_date').value     = start_mea;
           document.getElementById('te_note').value         = note;
           document.getElementById('te_daya').value         = daya;
           document.getElementById('te_active').value       = active;
           document.getElementById('te_repair').value       = repair;
           document.getElementById('te_lastusage').value       = lastusage;
           document.getElementById('te_lastusagemtc').value       = lastusagemtc;
           document.getElementById('te_lastmtc').value       = lastmtc;
           document.getElementById('te_onuse').value       = onuse;
           document.getElementById('te_tolerance').value       = tolerance;
           document.getElementById('foto1').src       = assetimg;

           
            if (repair_type == "group") {
                document.getElementById('argcheck').checked = true;
                document.getElementById('arccheck').checked = false;
                document.getElementById('repairgroup').value = repair;
                document.getElementById('repairgroupdiv').style.display='';
                document.getElementById('repaircodediv').style.display='none';
            } else if (repair_type == "code") {
                document.getElementById('argcheck').checked = false;
                document.getElementById('arccheck').checked = true;
                document.getElementById('repairgroupdiv').style.display='none';
                document.getElementById('repaircodediv').style.display='';
            }

            if (measure == "C") {
                document.getElementById('divecal').style.display='';
                document.getElementById('divemeter').style.display='none';
                document.getElementById('te_cal').focus();
            } else if (measure == "M") {
                document.getElementById('divemeter').style.display='';
                document.getElementById('divecal').style.display='none';
                document.getElementById('te_meter').focus();
            } else {
                document.getElementById('divemeter').style.display='none';
                document.getElementById('divecal').style.display='none';
            }

            $.ajax({
                url:"/locasset2?site=" + site + "&&loc=" + loc ,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 

            $("#te_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#te_supp").select2({
                width : '100%',
                theme : 'bootstrap4',
                supp
            });

            $("#te_type").select2({
                width : '100%',
                theme : 'bootstrap4',
                type
            });

            $("#te_group").select2({
                width : '100%',
                theme : 'bootstrap4',
                group
            });

            $("#repaircodeselect").select2({
                width : '100%',
                placeholder : "Select Repair Code",
                maximumSelectionLength : 3,
                closeOnSelect : false,
                allowClear : true,
            });

            ambilrepair();

            $.ajax({
                url:"/listupload/" + code,
                success: function(data) {
                
                    $('#listupload').html('').append(data); 
                }
            })
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');
            var site = $(this).data('site');
            var loc = $(this).data('loc');

            document.getElementById('d_code').value      = code;
            document.getElementById('d_site').value      = site;
            document.getElementById('d_loc').value      = loc;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, loc, type, group){
            $.ajax({
                url:"assetmaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&loc="+loc+"&type="+type+"&group="+group,
                success:function(data){
                    console.log(data);

                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var loc = $('#s_loc').val();
            var type = $('#s_type').val();
            var group = $('#s_group').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmploc').value = loc;
            document.getElementById('tmptype').value = type;
            document.getElementById('tmpgroup').value = group;

            fetch_data(page, sort_type, column_name, code, loc, type, group);
        });

       $(document).on('click', '.sorting', function(){
			var column_name = $(this).data('column_name');
			var order_type = $(this).data('sorting_type');
			var reverse_order = '';
			if(order_type == 'asc')
			{
			$(this).data('sorting_type', 'desc');
			reverse_order = 'desc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
			}
			if(order_type == 'desc')
			{
			$(this).data('sorting_type', 'asc');
			reverse_order = 'asc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
			}
			$('#hidden_column_name').val(column_name);
			$('#hidden_sort_type').val(reverse_order);

            var page = $('#hidden_page').val();
            var code = $('#s_code').val();
            var loc = $('#s_loc').val();
            var type = $('#s_type').val();
            var group = $('#s_group').val();

			fetch_data(page, sort_type, column_name, code, loc, type, group);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            
            var code = $('#s_code').val();
            var loc = $('#s_loc').val();
            var type = $('#s_type').val();
            var group = $('#s_group').val();
            
            fetch_data(page, sort_type, column_name, code, loc, type, group);
       });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var loc = '';
            var type = '';
            var group = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_loc').value  = '';
            document.getElementById('s_type').value  = '';
            document.getElementById('s_group').value  = '';

            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmploc').value  = loc;
            document.getElementById('tmptype').value  = type;
            document.getElementById('tmpgroup').value  = group;

            fetch_data(page, sort_type, column_name, code, loc, type, group);

            $("#s_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_code").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_type").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });

            $("#s_group").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });

        $(document).on('change', '#t_site', function() {
          var site = $('#t_site').val();

            $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#t_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#te_site', function() {
          var site = $('#te_site').val();

            $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#t_loc', function() {
          
          var code = $('#t_code').val();
          var desc = $('#t_desc').val();
          var site = $('#t_site').val();
          var loc = $('#t_loc').val();

            $.ajax({
              url:"/cekasset?code="+code+"&site="+site+"&loc="+loc ,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Asset Already Registered!!");
                  document.getElementById('t_loc').value = '';
                  document.getElementById('t_loc').focus();
                }
                console.log(data);
              
              }
            })
        });

        $(document).on('change', '#t_mea', function() {
          var mea = $('#t_mea').val();
          
          if (mea == "C") {
            document.getElementById('divcal').style.display='';
            document.getElementById('divmeter').style.display='none';
            document.getElementById('t_cal').focus();
          } else if (mea == "M") {
            document.getElementById('divmeter').style.display='';
            document.getElementById('divcal').style.display='none';
            document.getElementById('t_meter').focus();
          } else {
            document.getElementById('divmeter').style.display='none';
            document.getElementById('divcal').style.display='none';
          }
        });

        $(document).on('change', '#te_mea', function() {
          var mea = $('#te_mea').val();
          
            if (mea == "C") {
                document.getElementById('divecal').style.display='';
                document.getElementById('divemeter').style.display='none';
                document.getElementById('te_cal').focus();
            } else if (mea == "M") {
                document.getElementById('divemeter').style.display='';
                document.getElementById('divecal').style.display='none';
                document.getElementById('te_meter').focus();
            } else {
                document.getElementById('divemeter').style.display='none';
                document.getElementById('divecal').style.display='none';
            }
        });

        $("#t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_supp").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_type").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });


        $(document).on('change','#carccheck',function(e){
          document.getElementById('crepaircodediv').style.display='';
          document.getElementById('crepairgroupdiv').style.display='none';
          $("#crepairgroup").val(null).trigger('change');
          $("#crepaircode").val(null).trigger('change');
          document.getElementById('crepairtypeedit').value = 'code';
        });

        $(document).on('change','#cargcheck',function(e){
          document.getElementById('crepairgroupdiv').style.display='';
          document.getElementById('crepaircodediv').style.display='none';
          $("#crepairgroup").val(null).trigger('change');
          $("#crepaircode").val(null).trigger('change');
          document.getElementById('crepairtypeedit').value = 'group';
        });

        $("#crepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
        });

        $(document).on('change','#arccheck',function(e){
          document.getElementById('repaircodediv').style.display='';
          document.getElementById('repaircodeselect').value=null;
          document.getElementById('repairgroupdiv').style.display='none';
          document.getElementById('repairgroup').value=null;  
          document.getElementById('repairtype').value= 'code';
        });
        $(document).on('change','#argcheck',function(e){
          document.getElementById('repairgroupdiv').style.display='';
          document.getElementById('repairgroup').value=null;
          document.getElementById('repaircodediv').style.display='none';
          document.getElementById('repaircodeselect').value=null;
          document.getElementById('repairtype').value= 'group';
        });

        $("#crepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
        });

        function ambilrepair(){
            var repair = $('#te_repair').val();
            var a = repair.split(",");

            $.ajax({
                url:"/repaircode",
                success: function(data) {
                    var jmldata = data.length;

                    var repm_code = [];
                    var repm_desc = [];
                    var test = [];

                    test += '<option value="">--Select Repair--</option>';

                    for(i = 0; i < jmldata; i++){
                        repm_code.push(data[i].repm_code);
                        repm_desc.push(data[i].repm_desc);

                        if (a.includes(repm_code[i])) {
                            test += '<option value=' + repm_code[i] + ' selected>' + repm_code[i] + '--' + repm_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + repm_code[i] + '>' + repm_code[i] + '--' + repm_desc[i] + '</option>';
                        }                        
                    }

                    $('#repaircodeselect').html('').append(test); 
                }
            })
        }

        $("#s_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_code").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_type").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#s_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection