<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px; margin-top: 10px;">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 " style="text-align: center;">
        <img src="{{asset('/pos/img/logo.jpg')}}" width="90" height="90" alt="">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align: center;">
        <span style="font-size: 24px;"><b>POS SHOP REPORT</b></span><br>
        <span style="font-size: 18px;"><b>OPEN ITEM DETAIL</b></span>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

    </div>
</div>
@foreach($rows as $row)
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border: solid 1px darkgrey; margin-bottom: 10px;">
        <div>
            <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                <tbody style="font-size: 14px;">
                <tr style="text-align:center;">
                    <td style="vertical-align:middle;text-align:left; padding-left:10px;"><span><b>Number</b></span> : {{$row->open_number}}</td>
                    <td style="vertical-align:middle;text-align:left;"><span><b>Open Date</b></span> : {{$row->_date_}}</td>
                </tr>
                <tr style="text-align:center;">
                    <td style="vertical-align:middle;text-align:left; padding-left:10px;"><span><b>Description</b></span> : {{$row->description}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <style>
            .no_border_btm tr td{
                border:none !important;
            }
        </style>
        <table class="table-condensed receipt no_border_btm" style="width:100%;">
            <thead>
            <tr style="border:1px dotted black !important; font-size:14px;">
                <th>No</th>
                <th>Code</th>
                <th class="text-center">Title</th>
                <th class="text-center">Unit</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Cost</th>
            </tr>
            </thead>
            <tbody style="font-size: 12px;">
            @php
                $key = 1;
                $open_details = \App\Models\OpenItemDetail::where('ref_id','=',$row->id)->get();
            @endphp
            @foreach($open_details as $open_detail)

                @php
                    $item_field = \App\Models\Item::find($open_detail->item_id);
                @endphp

                <tr class="item">
                    <td class="text-left">{{$key++}}</td>
                    <td class="text-left">{{$open_detail->item_code}}</td>
                    <td class="text-left">{{$item_field->title}}</td>
                    <td class="text-left">{{$item_field->unit}}</td>
                    <td class="text-right">{{number_format($open_detail->qty)}}</td>
                    <td class="text-right">$ {{number_format($open_detail->cost)}}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
@endforeach