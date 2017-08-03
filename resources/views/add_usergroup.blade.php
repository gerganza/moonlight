@include('default.header')

<body>

<div id="wrapper">

    @include('default.nav')

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>ASSIGN GROUP</h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Group Code</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                            <tr class="gradeU">
                                <form action="store">
                                    <td>{{$user->name}}</td>
                                    <td>
                                        <select name="groupcode" class="selection form-control">
                                            <option value="">-- select group --</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->GroupCode}}"
                                                @if($usergroup->getUserGroup($user->id) == $group->GroupCode)
                                                    selected="selected"
                                                @endif
                                                >{{$group->GroupName}} - {{$group->description}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="center">
                                        <input type="hidden" name="userid" value="{{$user->id}}" />
                                        <button type="submit" class="btn btn-success">assign</button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /datatable -->
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{asset('vendor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendor/morrisjs/morris.min.js')}}"></script>
<script src="{{asset('data/morris-data.js')}}"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('dist/js/sb-admin-2.js')}}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        $('#users').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
