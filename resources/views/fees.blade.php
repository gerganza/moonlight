@include('default.header')

<body>

<div id="wrapper">

    @include('default.nav')

    <div id="page-wrapper">

        <br />
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">TRANSACTION FEES {{Cache::tags($id)->get('_year')}}</a>
                            </li>
                            <li><a href="#profile" data-toggle="tab">TRANSACTION FEES {{Cache::tags($id)->get('_year')}} - {{Cache::tags($id)->get('_year') + 4}}</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <div>

                                    {!! Chart::display("id-highcharts", $charts) !!}

                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div>

                                    <div id="chart2"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="casto-brown-font">TRANSACTION FEES Data - {{Cache::tags($id)->get('_year')}}</h2>
                <h4>{{Cache::tags($id)->get('_clientname')}}</h4>
                <div class="table-responsive">
                    <table id="FEESdata" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Category</th>
                            <th>January</th>
                            <th>February</th>
                            <th>March</th>
                            <th>April</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>August</th>
                            <th>September</th>
                            <th>October</th>
                            <th>November</th>
                            <th>December</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i=0; $i<=Cache::tags($id)->get('_FEES_total_rows'); $i++)
                            <tr>
                                <td>{{Cache::tags($id)->get('_FEES_item_'.$i)}}</td>
                                <td>{{str_replace('_', ' ', Cache::tags($id)->get('_FEES_category_'.$i))}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_JanData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_FebData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_MarData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_AprData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_MayData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_JunData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_JulData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_AugData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_SepData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_OctData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_NovData_'.$i),2)}}</td>
                                <td>{{number_format(Cache::tags($id)->get('_FEES_DecData_'.$i),2)}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

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

<!-- Page JS -->
<script type="text/javascript">
    $(document).ready(function(){

        Highcharts.chart('chart2', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false,
            },
            xAxis: {
                categories: [
                    '{{Cache::tags($id)->get('_FEES_fiveyear_yeardate_0')}}',
                    '{{Cache::tags($id)->get('_FEES_fiveyear_yeardate_1')}}',
                    '{{Cache::tags($id)->get('_FEES_fiveyear_yeardate_2')}}',
                    '{{Cache::tags($id)->get('_FEES_fiveyear_yeardate_3')}}',
                    '{{Cache::tags($id)->get('_FEES_fiveyear_yeardate_4')}}',
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sales ($)'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: '{{Cache::tags($id)->get('_clientname')}}',
                data: [
                    {{Cache::tags($id)->get('_FEES_fiveyear_yeardata_0')}},
                    {{Cache::tags($id)->get('_FEES_fiveyear_yeardata_1')}},
                    {{Cache::tags($id)->get('_FEES_fiveyear_yeardata_2')}},
                    {{Cache::tags($id)->get('_FEES_fiveyear_yeardata_3')}},
                    {{Cache::tags($id)->get('_FEES_fiveyear_yeardata_4')}},
                ],
                color: '#2d5554',

            }]
        });

    });
</script>

</body>

</html>
