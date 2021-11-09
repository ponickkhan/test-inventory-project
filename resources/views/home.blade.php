@extends('layouts.app')

@section('header')
    {!! Html::script('admin/assets/js/lib/chart-js/Chart.bundle.js') !!}

@endsection

@section('content')

    <!-- Right Panel -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

        <div class="content mt-3" >



            <div class="row">
                Welcome!
            </div>




        </div> <!-- .content -->


    <!-- Right Panel -->

@endsection


@section('script')



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
            let count = $('.badge').length;
            let color = ['badge-primary', 'badge-primary', 'badge-success','badge-info','badge-dark','badge-warning','badge-danger','badge-secondary', 'badge-primary', 'badge-success',];

            for (let i = 1; i < count; i++){
                $('.badge').eq(i).addClass(color[i]);
            }

    </script>

    <script>
        $(document).ready(function(){

            $("#button").click(function(){
                let count = $('input').length - 4;
                let price = 0;
                let stock = 0;
                let quantity = [];
                let goods = [];

                $("input[name='quantity[]']").each(function() {
                    quantity.push($(this).val());
                });
                $("select[name='stock[]']").each(function() {
                    goods.push($(this).val());
                });

                for (let i = 0; i < count; i++) {

                    $.get("{{ url('/orders/price/') }}/"+goods[i], function(response){
                        price += response.selling_price * quantity[i];
                        let icon = '<i class="fa fa-lock fa-lg"></i>&nbsp;\n';
                        $('.amount').html(icon+" Pay "+price+" DH");
                        $("#total").val(price);
                    });
                }

            });

            $("#check").click(function () {
                let stock = 0;
                let quantity = [];
                let goods = [];
                let count = $('input').length - 4;
                let status = 0;

                $("select[name='stock[]']").each(function() {
                    goods.push($(this).val());
                });
                $("input[name='quantity[]']").each(function() {
                    quantity.push($(this).val());
                });
                for (let i = 0; i < count; i++){
                    $.get("{{ url('/orders/price/') }}/"+goods[i], function(response){
                        if (quantity[i] > response.quantity ){
                            let error = '<strong id="oldError" style="color: red">**There is not enough  '+response.goods_name+' in the stock'+ '\n Available quantity is:'+response.quantity+'</strong>'
                            $("#errors").html(error);
                            status = 1;
                        }else {
                            let final = count - i;
                            if (final == 1 & status == 0 & quantity[i] != '' & quantity[i] != 0 ){
                                $("form").submit();
                            }else if(final == 1 & status == 0 & quantity[i] == '' | quantity[i] == 0){
                                $("#errors").html('<strong id="oldError" style="color: red">**Invalid quantity</strong>')
                            }
                        }

                    });

                }



            });




            $("#addOne").click(function () {
                let form = '    <div class="col-12">' +
                    '<div class="row">' +
                    '    <div class="col-6">' +
                    '        <div class="form-group">' +
                    '            <label for="cc-payment" class="control-label mb-1">Goods</label>' +
                    '            {!! Form::select('stock[]', goods(), null, ['class' => 'form-control', 'id' => 'stock']) !!}' +
                    '        </div>' +
                    '    </div>' +
                    '    <div class="col-6">' +
                    '        <label for="cc-payment" class="control-label mb-1">Quantity</label>' +
                    '        {!! Form::text('quantity[]', null, ['class' => 'form-control', 'id' => 'quantity']) !!}' +
                    '    </div>' +
                    '</div>'+
                    '    </div>'
                ;

                $("#add").append(form);
            })


        });
    </script>


    <!--  Chart js -->
<script>
    //Sales chart
    var ctx = document.getElementById( "sales-chart" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                label: "Sales",
                data: [ {{ chartMonth("01") }},{{ chartMonth("02") }},{{ chartMonth("03") }},{{ chartMonth("04") }},{{ chartMonth("05") }},{{ chartMonth("06") }},{{ chartMonth("07") }},{{ chartMonth("08") }},{{ chartMonth("09") }},{{ chartMonth("10") }},{{ chartMonth("11") }},{{ chartMonth("12") }}, ],
                backgroundColor: 'transparent',
                borderColor: 'rgba(220,53,69,0.75)',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(220,53,69,0.75)',
            }]
        },
        options: {
            responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                } ],
                yAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                } ]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    } );



</script>

    <!--  Make sell -->




@endsection