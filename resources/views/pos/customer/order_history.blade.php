
<style>
    .timeline > li > .timeline-item {
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        margin-top: 0;
        background: #fff;
        /* color: #444; */
        margin-left: 60px;
        margin-right: 15px;
        padding: 0;
        position: relative;
        height: auto;
        overflow: hidden;
        padding-bottom: 30px !important;
    }
     table{
         border-collapse: collapse;
     }
    .border th, .border td {
        border: 1px solid rgba(188, 188, 188, 0.96);
        padding: 5px;
    }
</style>
@extends('vendor.backpack.base.layout')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <ul class="timeline">
                    <li class="time-label">
                      <span class="bg-red">
                      <td  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">{{_t('Customer Information')}}</td>
                      </span>
                    </li>
                    <li>
                        <i class="fa fa-calendar bg-yellow"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i></span>

                            <h3 class="timeline-header"><a href="#"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">{{_t('Customer Record')}}</a></h3>

                            <div class="timeline-body">
                                <div class="col-md-3">
                                    {{--<img src="http://placehold.it/150x100" alt="..." class="margin">--}}
                                    {{--  <a href=""
                                         class="zoom"><i class="fa fa-search"></i></a>--}}
                                    @if($row->image != null)

                                        <img src="{{ url('img/cache/img150x100/'.\App\Helpers\Glb::get_basename($row->image)) }}">
                                    @else
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <table width="100%">
                                        <tr>
                                            <td>{{_t('Name')}}: </td>
                                            <td>{{$row->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{_t('Gender')}}: </td>
                                            <td>{{$row->gender}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{_t('Phone')}}: </td>
                                            <td>{{$row->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{_t('Description')}}: </td>
                                            <td>{{$row->description}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{_t('Member Date')}}: </td>
                                            <td>{{\Carbon\Carbon::parse($row->created_at)->format('d/M/Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </li>

                    @if(count($row_invoice)> 0)
                        <li class="time-label">
                          <span class="bg-green"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">
                           {{_t('Invoice history')}}
                          </span>
                        </li>
                        <li>
                            <i class="fa fa-camera bg-purple"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i></span>
                                <h3 class="timeline-header"><a href="#"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">{{_t('Customer Invoice Record')}}</a></h3>
                                <div class="timeline-body">
                                    @php
                                        $total_qty = 0;
                                        $total_deposit = 0;
                                        $complete_price = 0;
                                        $total_amount = 0;
                                        $total_discount = 0;
                                        $total_payable = 0;
                                        $total_paid = 0;
                                        $total_remaining = 0;
                                    @endphp
                                    @foreach($row_invoice as $invoice)
                                        @php
                                            $total_deposit+= ($invoice->deposit);
                                            $complete_price+= ($invoice->complete_price);
                                            $total_amount+= ($invoice->total_amt);
                                            $total_discount+= ($invoice->total_discount);
                                            $total_payable+= ($invoice->total_payable);
                                            $total_paid+= ($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate));
                                            $total_remaining+= (($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate))-$invoice->total_payable);
                                        @endphp
                                        <table style="width: 100%">
                                            <tr style="">
                                                <td colspan="7">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="33%" valign="top">
                                                                {{_t('Invoice No')}}: {{$invoice->invoice_number}}<br>
                                                                {{_t('Status')}}: {{$invoice->status}}<br>
                                                                {{_t('Note')}}: {{$invoice->payment_note}}
                                                            </td>
                                                            <td width="34%" valign="top">
                                                                {{_t('Exchange Rate')}}: {{$invoice->exchange_rate}} ៛<br>
                                                                @if($invoice->deposit != '')
                                                                    {{_t('Deposit')}}: $ {{number_format($invoice->deposit,2)}}<br>
                                                                    {{_t('Complete Price')}}: $ {{number_format($invoice->complete_price,2)}}<br>
                                                                @endif
                                                            </td>
                                                            <td width="33%" valign="top">
                                                                {{_t('Invoice Due')}}: {{\Carbon\Carbon::parse($invoice->_date_)->format('d/m/Y') }}<br>
                                                                @if($invoice->complete_date != '')
                                                                    {{_t('Complete Date')}}: {{\Carbon\Carbon::parse($invoice->complete_date)->format('d/m/Y') }}<br>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">
                                                    <br>
                                                </td>
                                            </tr>
                                            <table width="100%">
                                                <thead class="border" style="background: #CCCCCC">
                                                <tr>
                                                    <th class="text-center">{{_t('No')}}</th>
                                                    <th class="text-center" style="width: 62px;">{{_t('Image')}}</th>
                                                    <th class="text-center">{{_t('Code')}}</th>
                                                    <th class="text-center">{{_t('Name')}}</th>
                                                    <th class="text-center">{{_t('Unit')}}</th>
                                                    <th class="text-center">{{_t('Qty')}}</th>
                                                    <th class="text-center">{{_t('Price')}}</th>
                                                    <th class="text-center">{{_t('Total')}}</th>

                                                </tr>
                                                </thead>
                                                <tbody class="border" style="border-bottom: none;">
                                                    @php
                                                        $rowds = \App\Models\InvoiceDetail::where('ref_id',$invoice->id)
                                                              ->join('items','items.id','=','invoice_detail.item_id')
                                                              ->selectRaw("items.id,
                                                              invoice_detail.item_id,
                                                              invoice_detail.item_code,
                                                              invoice_detail.title,
                                                              invoice_detail.unit,
                                                              invoice_detail.num_qty,
                                                              invoice_detail.qty,
                                                              invoice_detail.cost,
                                                              invoice_detail.price,
                                                              invoice_detail.discount,
                                                              invoice_detail.note,
                                                              invoice_detail.item_detail,
                                                              items.image")
                                                              ->get();
                                                    @endphp
                                                    @foreach($rowds as $rd)
                                                        @php
                                                            $rds = \App\Models\ItemDetail::where('ref_id',$rd->item_id)->get();
                                                            $total_qty+= ($rd->qty);
                                                             $units = \App\Models\Unit::where('id',$rd->unit)->first();
                                                            $oe = $loop->index;
                                                        @endphp
                                                           <tr class="item" style="height: 30px;  @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif color: #0586ff; font-weight: bold;">
                                                               <td class="text-left">{{$loop->index+1}}</td>
                                                               <td class="text-left">
                                                                   @php
                                                                       $img = json_decode($rd->image);
                                                                   @endphp
                                                                   @if(count($img)>0)
                                                                       <img src="{{url('img/cache/original/'.\App\Helpers\Glb::get_basename($img[0]))}}" width="60" height="60">
                                                                   @endif
                                                               </td>
                                                               <td class="text-left">{{$rd->item_code}}</td>
                                                               <td class="text-left">{{$rd->title}}</td>
                                                               <td class="text-left">{{isset($units->name)?$units->name:''}}</td>

                                                               <td class="text-right">{{$rd->qty}}</td>
                                                               <td class="text-right">$ {{number_format($rd->price,2)}}</td>
                                                               <td class="text-right">$ {{number_format($rd->price*$rd->qty,2)}}</td>
                                                            </tr>
                                                        @if(count($rds)>0)
                                                            @foreach($rds as $r)
                                                                @php
                                                                    $unit = \App\Models\Unit::where('id',$r->unit)->first();
                                                                @endphp
                                                             <tr class="item" style="height: 30px; @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif">
                                                                 <td class="text-left"></td>
                                                                 <td class="text-left"></td>
                                                                 <td class="text-left">{{$r->item_code}}</td>
                                                                 <td class="text-left">{{$r->title}}</td>
                                                                 <td class="text-left">{{$r->num_qty}} {{isset($unit->name)?$unit->name:''}}</td>
                                                                 <td class="text-right">{{$r->qty}}</td>
                                                                 <td class="text-right">$ {{number_format($r->price,2)}}</td>
                                                                 <td class="text-right">$ {{number_format($r->price*$r->qty,2)}}</td>
                                                             </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                                <tr style="color: #0586ff; font-weight: bold;">
                                                    <td colspan="5"></td>
                                                    <td style="text-align:right;">{{_t('Total')}}</td>
                                                    <td style="text-align:right;">$ {{number_format($invoice->total_amt,2)}}</td>
                                                    <td style="text-align:right;">{{number_format(($invoice->total_amt)*$invoice->exchange_rate,2)}} ៛</td>
                                                </tr>
                                                <tr style="color: #0586ff; font-weight: bold;">
                                                    <td colspan="5"></td>
                                                    <td style="text-align:right;">{{_t('Total Discount')}}</td>
                                                    <td style="text-align:right;">$ {{number_format($invoice->total_discount,2)}}</td>
                                                    <td style="text-align:right;">{{number_format(($invoice->total_discount)*$invoice->exchange_rate,2)}} ៛</td>
                                                </tr>
                                                <tr style="color: #0586ff; font-weight: bold;">
                                                    <td colspan="5"></td>
                                                    <td style="text-align:right;">{{_t('Grand Total')}}</td>
                                                    <td style="text-align:right;">$ {{number_format($invoice->total_payable,2)}}</td>
                                                    <td style="text-align:right;">{{number_format(($invoice->total_payable)*$invoice->exchange_rate,2)}} ៛</td>
                                                </tr>
                                                <tr style="color: #0586ff; font-weight: bold;">
                                                    <td colspan="5"></td>
                                                    <td style="text-align:right;">{{_t('Total Paid')}}</td>
                                                    <td style="text-align:right;">$ {{number_format($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate),2)}}</td>
                                                    <td style="text-align:right;">{{number_format(($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate))*$invoice->exchange_rate,2)}} ​​៛</td>
                                                </tr>
                                                <tr style="color: #0586ff; font-weight: bold;">
                                                    <td colspan="5"></td>
                                                    <td style="text-align:right;">{{_t('Remaining')}}</td>
                                                    <td style="text-align:right;">$ {{number_format(($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate))-$invoice->total_payable,2)}}</td>
                                                    <td style="text-align:right;">{{number_format((($invoice->paid+($invoice->paid_kh/$invoice->exchange_rate))-$invoice->total_payable)*$invoice->exchange_rate,2)}}​ ៛</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8">
                                                        <br>
                                                        <hr>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </table>
                                    </table>
                                    @endforeach
                                    <table width="100%">
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL QTY')}}</td>
                                            <td style="text-align:right;">{{$total_qty}} @if($total_qty > 1) {{_t('Units')}}  @else {{_t('Unit')}} @endif</td>
                                        </tr>

                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL DEPOSIT')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_deposit,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL COMPLETE PRICE ')}}</td>
                                            <td style="text-align:right;">$ {{number_format($complete_price,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('GRAND TOTAL')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_amount,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL DISCOUNT')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_discount,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL PAYABLE')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_payable,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL PAID')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_paid,2)}}</td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="6"></td>
                                            <td style="text-align:right;">{{_t('TOTAL REMAINING')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_remaining,2)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                    @else
                    @endif

                    @if(count($row_production) > 0)
                    {{---------------------------}}
                    <li class="time-label">
                      <span class="bg-green"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">
                        {{_t('Production History')}}
                      </span>
                    </li>
                    <li>
                        <i class="fa fa-camera bg-purple"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i></span>

                            <h3 class="timeline-header"><a href="#"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">{{_t('Customer Production Record')}}</a></h3>

                            <div class="timeline-body">
                                @php
                                    $total_qty = 0;
                                    $total_cost = 0;
                                @endphp
                                @foreach($row_production as $production)
                                    <table style="width: 100%">
                                        <tr style="">
                                            <td colspan="7">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="33%" valign="top">
                                                            {{_t('Production Number')}}: {{$production->production_number}}<br>
                                                        </td>
                                                        <td width="33%" valign="top">
                                                            {{_t('Production Due')}}: {{\Carbon\Carbon::parse($production->_date_)->format('d/m/Y') }}<br>
                                                        </td>
                                                        <td width="34%" valign="top">
                                                            {{_t('Note')}}: {{$production->description}}<br>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <br>
                                            </td>
                                        </tr>
                                        <table width="100%">
                                            <thead class="border" style="background: #CCCCCC">
                                            <tr>
                                                <th class="text-center">{{_t('No')}}</th>
                                                <th class="text-center">{{_t('Code')}}</th>
                                                <th class="text-center">{{_t('Name')}}</th>
                                                <th class="text-center">{{_t('Unit')}}</th>
                                                <th class="text-center">{{_t('Qty')}}</th>
                                                <th class="text-center">{{_t('Cost')}}</th>
                                                <th class="text-center">{{_t('Total')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody class="border">
                                            @php
                                                $rowss = \App\Models\ProductionDetail::where('ref_id',$production->id)->get();
                                            @endphp
                                            @foreach($rowss as $rd)
                                                @php
                                                    $total_qty+= ($rd->qty);
                                                    $total_cost+= ($rd->cost*($rd->qty));
                                                    $units = \App\Models\Unit::where('id',$rd->unit)->first();
                                                    $oe = $loop->index;
                                                @endphp
                                                <tr class="item" style="height: 30px; @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif color: #0586ff; font-weight: bold;">
                                                    <td class="text-left">{{$loop->index+1}}</td>
                                                    <td class="text-left">{{$rd->item_code}}</td>
                                                    <td class="text-left">{{$rd->title}}</td>

                                                    <td class="text-left">{{isset($units->name)?$units->name:''}}</td>
                                                    <td class="text-right">{{$rd->qty}}</td>
                                                    <td class="text-right">$ {{number_format($rd->cost,2)}}</td>
                                                    <td class="text-right">$ {{number_format($rd->cost*$rd->qty,2)}}</td>
                                                </tr>
                                                    @if(count($rd->item_detail)>0)
                                                        @foreach(json_decode($rd->item_detail) as $r)
                                                            @php
                                                                $unit = \App\Models\Unit::where('id',$r->unit)->first();
                                                            @endphp
                                                            <tr class="item" style="height: 30px; @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif ">
                                                                <td class="text-left"></td>
                                                                <td class="text-left">{{$r->item_code}}</td>
                                                                <td class="text-left">{{$r->title}}</td>
                                                                <td class="text-left">{{$r->num_qty}} {{isset($unit->name)?$unit->name:''}}</td>
                                                                <td class="text-right">{{$r->qty}}</td>
                                                                <td class="text-right">$ {{number_format($r->cost,2)}}</td>
                                                                <td class="text-right">$ {{number_format($r->cost*$r->qty,2)}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tbody>
                                            <tr>
                                                <td colspan="7">
                                                    <br>
                                                    <hr>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>

                                    </table>
                                @endforeach
                                <table width="100%">
                                    <tr style="color: #a00816; font-weight: bold;">
                                        <td colspan="5"></td>
                                        <td style="text-align:right;">{{_t('TOTAL QTY')}}</td>
                                        <td style="text-align:right;">{{$total_qty}} @if($total_qty > 1) {{_t('Units')}}  @else {{_t('Unit')}} @endif </td>
                                    </tr>
                                    <tr style="color: #a00816; font-weight: bold;">
                                        <td colspan="5"></td>
                                        <td style="text-align:right;">{{_t('TOTAL COST')}}</td>
                                        <td style="text-align:right;">$ {{number_format($total_cost,2)}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                    @else
                    @endif

                    @if(count($row_purchase) > 0)
                    {{---------------------------}}
                    <li class="time-label">
                      <span class="bg-green"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">
                        {{_t('Purchase History')}}
                      </span>
                    </li>
                    <li>
                        <i class="fa fa-camera bg-purple"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i></span>

                            <h3 class="timeline-header"><a href="#"  style="font-family: 'Encode Sans Semi Condensed', sans-serif;
            font-family: 'Hanuman', serif;">{{_t('Customer Purchase Record')}}</a></h3>

                            <div class="timeline-body">
                                @php
                                    $total_qty = 0;
                                    $total_cost = 0;
                                @endphp
                                @foreach($row_purchase as $purchase)
                                <table style="width: 100%">
                                    <tr style="">
                                        <td colspan="6">
                                            <table width="100%">
                                                <tr>
                                                    <td width="33%" valign="top">
                                                        {{_t('Purchase Number')}}: {{$purchase->purchase_number}}<br>
                                                    </td>
                                                    <td width="34%" valign="top">
                                                        {{_t('Purchase Due')}}: {{\Carbon\Carbon::parse($purchase->_date_)->format('d/m/Y') }}<br>
                                                    </td>
                                                    <td width="33%" valign="top">
                                                        {{_t('Note')}}: {{$purchase->description}}<br>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <br>
                                        </td>
                                    </tr>
                                    <table width="100%">
                                        <thead class="border" style="background: #CCCCCC">
                                        <tr>
                                            <th class="text-center">{{_t('No')}}</th>
                                            <th class="text-center">{{_t('Code')}}</th>
                                            <th class="text-center">{{_t('Name')}}</th>
                                            <th class="text-center">{{_t('Unit')}}</th>
                                            <th class="text-center">{{_t('Qty')}}</th>
                                            <th class="text-center">{{_t('Cost')}}</th>
                                            <th class="text-center">{{_t('Total')}}</th>

                                        </tr>
                                        </thead>
                                        <tbody class="border">
                                        @php
                                            $rowss = \App\Models\PurchaseDetail::where('ref_id',$purchase->id)->get();
                                        @endphp
                                        @foreach($rowss as $rd)
                                            @php
                                                    $total_qty+= ($rd->qty);
                                                   $total_cost+= ($rd->cost*($rd->qty));
                                                   $units = \App\Models\Unit::where('id',$rd->unit)->first();
                                                   $oe = $loop->index;
                                            @endphp
                                            <tr class="item" style="height: 30px; @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif color: #0586ff; font-weight: bold;">
                                                <td class="text-left">{{$loop->index+1}}</td>
                                                <td class="text-left">{{$rd->item_code}}</td>
                                                <td class="text-left">{{$rd->title}}</td>
                                                <td class="text-left">{{isset($units->name)?$units->name:''}}</td>
                                                <td class="text-right">{{$rd->qty}}</td>
                                                <td class="text-right">$ {{number_format($rd->cost,2)}}</td>
                                                <td class="text-right">$ {{number_format($rd->cost*$rd->qty,2)}}</td>
                                            </tr>
                                            @if(count($rd->item_detail)>0)
                                                @foreach(json_decode($rd->item_detail) as $r)
                                                    @php
                                                        $unit = \App\Models\Unit::where('id',$r->unit)->first();
                                                    @endphp
                                                    <tr class="item" style="height: 30px; @if($oe % 2 > 0) background: rgba(240,255,0,0.29); @endif ">
                                                        <td class="text-left"></td>
                                                        <td class="text-left">{{$r->item_code}}</td>
                                                        <td class="text-left">{{$r->title}}</td>
                                                        <td class="text-left">{{$r->num_qty}} {{isset($unit->name)?$unit->name:''}}</td>
                                                        <td class="text-right">{{$r->qty}}</td>
                                                        <td class="text-right">$ {{number_format($r->cost,2)}}</td>
                                                        <td class="text-right">$ {{number_format($r->cost*$r->qty,2)}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="7">
                                                <br>
                                                <hr>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>

                                </table>
                                @endforeach
                                    <table width="100%">
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="5"></td>
                                            <td style="text-align:right;">{{_t('TOTAL QTY')}}</td>
                                            <td style="text-align:right;">{{$total_qty}} @if($total_qty > 1) {{_t('Units')}}  @else {{_t('Unit')}} @endif </td>
                                        </tr>
                                        <tr style="color: #a00816; font-weight: bold;">
                                            <td colspan="5"></td>
                                            <td style="text-align:right;">{{_t('TOTAL COST')}}</td>
                                            <td style="text-align:right;">$ {{number_format($total_cost,2)}}</td>
                                        </tr>
                                    </table>

                            </div>
                        </div>
                    </li>
                    @else
                    @endif
                </ul>
            </div>
        </div>
    </section>
@endsection