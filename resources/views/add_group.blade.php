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
                <button class="btn btn-success" data-toggle="collapse" data-target="#addgroups">Add Group</button>
                <br /><br />
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row collapse" id="addgroups">
            <div class="col-lg-12">
                <div class="panel panel-green">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="store" role="form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input name="groupname" class="form-control" placeholder="Group Name">
                                        @if ($errors->has('groupname'))<p class="help-block" style="color:red;">{!!$errors->first('groupname')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input name="groupcode" class="form-control" placeholder="Group Code">
                                        @if ($errors->has('groupcode'))<p class="help-block" style="color:red;">{!!$errors->first('groupcode')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                        @if ($errors->has('description'))<p class="help-block" style="color:red;">{!!$errors->first('description')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <button name="submit" type="submit" class="btn btn-success">Create Group</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>GROUPS</h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($groups as $group)

                                    <tr class="gradeU">
                                        <td>{{$group->GroupName}}</td>
                                        <td>{{$group->GroupCode}}</td>
                                        <td>{{$group->description}}</td>
                                        <td class="center">
                                            @if($group->isActive == 1)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td align="center">
                                            <form action="destroy">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$group->id}}">
                                                <input type="hidden" name="status" value="{{$group->isActive}}">
                                                @if($group->isActive == 1)
                                                    <button type="submit" class="btn btn-danger">deactivate</button>
                                                @else
                                                    <button type="submit" class="btn btn-success">activate</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
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
