@include('default.header')

<body>

<div id="preloader"><h3>Retrieving data...</h3></div>

<div id="wrapper">

    @include('default.nav')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    &nbsp;
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <h2 class="casto-brown-font">Total Sales {{Cache::tags($id)->get('_year')}}</h2>
                    <h4>{{Cache::tags($id)->get('_clientname')}}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-plane fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_air'))
                                        <div><h3>${{Cache::tags($id)->get('_total_air')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>AIR Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('air')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-send fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_intl'))
                                        <div><h3>${{Cache::tags($id)->get('_total_intl')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>INTERNATIONAL Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('air')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-send-o fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_dom'))
                                        <div><h3>${{Cache::tags($id)->get('_total_dom')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>DOMESTIC Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('air')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bed fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_hotel'))
                                        <div><h3>${{Cache::tags($id)->get('_total_hotel')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>HOTEL Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('hotel')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-train fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_rail'))
                                        <div><h3>${{Cache::tags($id)->get('_total_rail')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>RAIL Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('rail')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_car'))
                                        <div><h3>${{Cache::tags($id)->get('_total_car')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>CAR Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('car')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-globe fa-4x" aria-hidden="true"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_visa'))
                                        <div><h3>${{Cache::tags($id)->get('_total_visa')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>VISA/PASSPORT Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('visa')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <div class="col-xs-12 text-right">
                                    @if(Cache::tags($id)->has('_total_sales'))
                                        <div><h3>${{Cache::tags($id)->get('_total_sales')}}</h3></div>
                                    @else
                                        <div><h3>$0</h3></div>
                                    @endif
                                    <div>TOTAL Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('#')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            @if(Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1'))
                <div class="row">
                    <div class="col-lg-6">

                        {!! Chart::display("hidechart", $charts) !!}

                    </div>
                    <div class="col-lg-12">

                        <div id="chart"></div>

                    </div>
                </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="msgError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">REMINDER</h4>
                        </div>
                        <div class="modal-body">
                            @if(isset($error))
                                <p>{{$error}}</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('dist/js/sb-admin-2.js')}}"></script>

    <!-- Highcharts 3D -->
    <script src="{{asset('code/highcharts-3d.js')}}"></script>

    <!-- Page JS -->
    <script type="text/javascript">
        $(document).ready(function(){

            $('#profiletype').change(function(){
                $('#frmProfileType').submit();
            });

            @if(isset($error) && $error != "")
                $('#msgError').modal();
            @endif

            $('#frmClientList').submit(function(e) {
                e.preventDefault;
                $('#preloader').fadeIn('slow');
                $(this).submit();
            });

            $("#hidechart").hide();

            // Build the chart
            Highcharts.chart('chart', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            useHTML: true,
                            formatter: function() {
                                return '<p>' + this.point.name + ' <i style="color:' + this.point.color + '">(' + Math.round(this.percentage*100)/100 + ' %)</i></p>';
                            },
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Total Sales',
                    data: [
                        ['AIR', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_air')))}}],
                        ['HOTEL', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_hotel')))}}],
                        ['RAIL', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_rail')))}}],
                        ['CAR', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_car')))}}],
                        ['VISA', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_visa')))}}],
                        ['TRANSACTION FEES', {{floatval(str_replace(',','', Cache::tags($id)->get('_total_fees')))}}],
                    ]
                }]
            });

        });
    </script>

</body>

</html>