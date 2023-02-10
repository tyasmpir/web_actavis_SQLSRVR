@forelse($datas as $show)
<tr>
    <td style="text-align: center;">{{$show->so_nbr}}</td>
    <td style="text-align: center;">{{$show->so_cust}}</td>
    <td style="text-align: center;">{{$show->so_duedate}}</td>
    <td style="text-align: center;">
        <a href="" id="editdatawh"  data-toggle="modal" data-target="#editModal" data-sonbr="{{$show->so_nbr}}" 
        data-cust="{{$show->so_cust}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>

        <a href="" id="deletedatawh" data-toggle="modal" data-target="#deleteModal" data-sonbr="{{$show->so_nbr}}" 
        data-cust="{{$show->so_cust}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse