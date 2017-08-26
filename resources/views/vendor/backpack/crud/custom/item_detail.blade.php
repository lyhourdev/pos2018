
@php
    $r_id = rand(11111, 99999) .  time() . rand(1000, 5000);
@endphp

<div class="array-container form-group">

    <table class="table table-responsive table-bordered table-striped m-b-0">

        <thead>
        <tr>
            @foreach( $field['columns'] as $k => $prop )
                @php

                @endphp
                <th style="font-weight: 600!important; @if($prop['show'] == false) display: none !important;  @endif ; @if($prop['width'] > 0) width:{{$prop['width']}}px ; @endif " >
                    {{ $prop['label'] }}
                </th>
            @endforeach
            <th class="text-center" colspan="2" style="width: 200px !important;">
            {{--    <button class="btn btn-sm btn-success add{{$r_id}}" type="button"><span class="sr-only">Add</span><i class="fa fa-plus" role="presentation" aria-hidden="true"></i></button>
            --}}
            </th>
        </tr>
        </thead>

        @include('pos.item.item-rows',compact('crud', 'entry', 'field'))

        <tbody class="table-striped tbody-main-for-use"></tbody>


    </table>


</div>


<input type="hidden" class="q-item-name">


{{--//=============================================================================
//=============================================================================--}}
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"  id="show-item-big" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Search Item</h4>
            </div>
            <div class="modal-body" style="min-height: 400px;">

                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"></h3>

                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control pull-right search-item-to-show-txt" placeholder="Search">

                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default search-item-to-show"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding load-search-item-list">

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{--//=============================================================================
//=============================================================================--}}


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields) || $field['showOneTime'] == 1 )

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
    @endpush

@endif

<!-- include field specific select2 js-->
@push('crud_fields_scripts')
    <script>
        // Numeric only control handler
        jQuery.fn.ForceNumericOnly =
            function()
            {
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
                        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                        // home, end, period, and numpad decimal
                        return (
                            key == 8 ||
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 110 ||
                            key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };

        function dd(o) {
            console.log(o);
        }

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

    </script>
    <script>


        var page = 1;

        //$('.item_id-main-id')
        function getAllItemId(ob) {
            var id = [];
            ob.each(function () {
                var item_id = $(this).val();
                if(item_id>0) {
                    id.push(item_id);
                }
            });
            return id;
        }

        function addRowItemWithData(data,ob) {
                var c_c = 0;

                ob.each(function () {
                    if($(this).data('mainid') != 'uid-xxxx-uid-xxxx') {
                        var item_id = $(this).val();
                        var tr = $(this).parent().parent();
                        var item_code = tr.find('.item_code{{$r_id}}').val();
                        var title = tr.find('.title{{$r_id}}').val();

                        if (item_id > 0) {

                        } else if (item_code == '' && title == '') {
                            $(this).html('<option selected value="' + data.id + '">' + data.title + '</option>');
                            runSelect2{{$r_id}}($(this));
                            tr.find('.item_code{{$r_id}}').val(data.item_code);
                            tr.find('.title{{$r_id}}').val(data.title);
                            tr.find('.unit{{$r_id}}').val(data.unit);
                            c_c++;

                            var subid = $(this).data('subid');
                            var mainid = $(this).data('mainid');
                            if ($('#' + subid).is(":last-child")) {
                                for (i = 1; i <= 5; i++) {
                                    addRowMain();
                                }
                            }

                            return false;
                        }
                    }

                });

                if (c_c == 0) {
                    dd('no');
                }


        }

        function loadItemSearch(p,arrItemID) {
            var q = $('.search-item-to-show-txt').val();
            $('.load-search-item-list').html('');
            $('.load-search-item-list').load('{{ url('api/item-search') }}',{page:p,q:q,arr_item_id:arrItemID});
        }

        jQuery(document).ready(function() {

            $('body').delegate('.modal-add-item-main','click',function (e) {
                var id = $(this).data('id');
                var d = $(this);
                $.ajax({
                    type: "GET",
                    url: "{{url('api/item')}}/" + id,
                    //data: "{}",
                    dataType: "json",
                    success: function (data) {

                        addRowItemWithData(data,$('.item_id-main-id'));

                        d.parent().parent().remove();
                    },
                    error: function (result) {
                        dd("Error");
                    }
                });
            });

            $('body').delegate('.my-pagination ul li a','click',function (e) {
                e.preventDefault();
                page = $(this).data('page');
                var arrItemID = getAllItemId($('.item_id-main-id'));
                loadItemSearch(page,arrItemID);
            });

            $('.search-item-to-show-txt').on('keyup',function (e) {
                delay(function(){
                    var arrItemID = getAllItemId($('.item_id-main-id'));
                    loadItemSearch(1,arrItemID);
                }, 1000 );
            });

            $('.search-item-to-show').on('click',function (e) {
                e.preventDefault();
                var arrItemID = getAllItemId($('.item_id-main-id'));
                loadItemSearch(1,arrItemID);
            });

            $('#show-item-big').on('shown.bs.modal', function () {
                var arrItemID = getAllItemId($('.item_id-main-id'));
                loadItemSearch(1,arrItemID);
            });

            $('#show-item-big').on('hidden.bs.modal', function (e) {

                $('.ch-select-item:checked').each(function () {
                    var item_id = $(this).val();
                    console.log(item_id);
                });
            });

            $('body').delegate('.add{{$r_id}}','click',function () {

            });


        });


    </script>
    <script>
        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };

        function runSelect2{{$r_id}}(obj) {
            var placeholder = obj.data('placeholder');
            var url = obj.data('url');
            var multiple = false;
            //alert(category);
            obj.select2({
                theme: 'bootstrap',
                multiple: multiple,
                placeholder: placeholder,
                minimumInputLength: "0",
                ajax: {
                    url: url,
                    dataType: 'json',
                    quietMillis: 250,
                    closeOnSelect: false,
                    success: function (data) {
                        if(data.data.length > 0) {
                            //console.log(data.data[0].id);
                        }else {
                            //console.log(0);
                        }
                    },
                    data: function (params) {
                        if(params.term) {
                            $('.q-item-name').val(params.term);
                        }
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: $.map(data.data, function (item) {
                                //console.log(item);
                                return {
                                    text: item.title,
                                    id: item.id,
                                    xx:1111
                                }
                            }),
                            more: data.current_page < data.last_page
                        };
                    }
                    //cache: true
                },
                "language": {
                    "noResults": function(){
                        return 'No Results Found <button class="btn btn-danger no-result-add-item">Create New</button>';
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                },

            }).on('change',function (e) {
                var subid = $(this).data('subid');
                var mainid = $(this).data('mainid');

                var id = $(this).val();
                var tr = $(this).parent().parent();
                tr.find('.item_id{{$r_id}}').val(id);
                var d = $(this);

                $.ajax({
                    type: "GET",
                    url: "{{url('api/item')}}/" + id,
                    //data: "{}",
                    dataType: "json",
                    success: function (data) {
                        dd(data);
                        tr.find('.item_code{{$r_id}}').val(data.item_code);
                        tr.find('.title{{$r_id}}').val(data.title);
                        tr.find('.unit{{$r_id}}').val(data.unit);


                        if($('#'+subid).is(":last-child"))
                        {
                            if(d.hasClass('item_id-main-id')) {
                                for (i = 1; i <= 5; i++) {
                                    addRowMain();
                                }
                            }
                        }

                    },
                    error: function (result) {
                        dd("Error");
                    }
                });

            });

        }

        /*        String.prototype.replaceAll = function(search, replacement) {
                    var target = this;
                    return target.split(search).join(replacement);
                };*/
        function getUniqIDRan() {
            var uid = Math.floor(new Date().valueOf() * Math.random());
            uid += '8' + Math.floor(new Date().valueOf() * Math.random());
            return uid;
        }

        function addRowMain() {
            var uid = getUniqIDRan();
            var row_main = $('.table-origin-body').html()
                .replaceAll('xxxx-uid-xxxx',uid)
                .replaceAll('xx_name_xx','name');

            var row = $(row_main);
            runSelect2{{$r_id}}(row.find('.item_id-main-id'));
            runSelect2{{$r_id}}(row.find('.item_id-sub'));
            $('.tbody-main-for-use').append(row);
            $('.qty,.price,.discount,.cost').ForceNumericOnly();
        }

        function addRowSub(subid) {
            var uid = $('#'+subid).data('id');
            var uid2 = getUniqIDRan();
            var row_sub = $('.tbody-original-row-sub').first().html()
                .replaceAll('xxxx-uid-xxxx',uid)
                .replaceAll('yyyy-uid-yyyy',uid2)
                .replaceAll('www_name_www','name');

            var row = $(row_sub);
            runSelect2{{$r_id}}(row.find('.item_id-sub'));
            $('#'+subid).find('.tbody-original-row-sub').append(row);
            $('.qty,.price,.discount,.cost').ForceNumericOnly();
        }
        
        jQuery(document).ready(function () {
            for(i=1;i<=5;i++) {
                addRowMain();
            }

            $('.tbody-main-for-use').delegate('.delete-row-main-item','click',function (e) {
                e.preventDefault();
                var subid = $(this).data('subid');
                var mainid = $(this).data('mainid');

                var c = $('#'+mainid).find('.item_code-main').val();
                var t = $('#'+mainid).find('.title-main').val();

                if($('.delete-row-main-item').length >2){

                    if($('#'+subid).is(":last-child") && (c == '' || t == '')) {

                    }else {
                        $('#'+mainid).hide("slow", function(){ $(this).remove(); });
                        $('#'+subid).remove();
                    }

                }else {
                    addRowMain();
                }
            });


            $('.tbody-main-for-use').delegate('.delete-row-sub-item','click',function (e) {
                e.preventDefault();
                var subid = $(this).data('subid');
                var tr =  $(this).parent().parent();

                var c = tr.find('.item_code-sub').val();
                var t = tr.find('.title-sub').val();

                if($('#'+subid).find('.delete-row-sub-item').length >2){

                    if(tr.is(":last-child") && (c == '' || t == '')) {

                    }else {
                        tr.remove();
                    }

                }else {
                    addRowSub(subid);
                }
            });


            $('.tbody-main-for-use').delegate('.plus-row-sub-item','click',function (e) {
                e.preventDefault();
                var subid = $(this).data('subid');

                addRowSub(subid);
                addRowSub(subid);
                addRowSub(subid);
                addRowSub(subid);

            });


            $('.tbody-main-for-use').delegate('.main-add-sub-item','click',function (e) {
                e.preventDefault();
                var subid = $(this).data('subid');
                var mainid = $(this).data('mainid');

                if($(this).data('show') > 0) {
                    $('#' + subid).show(1000);

                    if($(this).data('add5') == 1){
                        $('#'+subid).find('.tbody-original-row-sub').html('');
                        for(ii=0;ii<=3;ii++) {
                            addRowSub(subid);
                        }
                        $(this).data('add5',-1);
                    }

                    $(this).data('show',-1);
                }else {
                    $('#' + subid).hide(1000);
                    $(this).data('show',1);
                }

            });


            $('.tbody-main-for-use').delegate('.item_code-main,.title-main','keyup',function (e) {
                var subid = $(this).data('subid');
                var mainid = $(this).data('mainid');
                if($('#'+subid).is(":last-child"))
                {
                    for(i=1;i<=5;i++) {
                        addRowMain();
                    }
                }

            });

        });
    </script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
