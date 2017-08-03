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
                <button class="btn btn-success" data-toggle="collapse" data-target="#adduser">Add User</button>
                <br /><br />
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row collapse" id="adduser">
            <div class="col-lg-12">
                <div class="panel panel-green">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form method="post" action="store" role="form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input name="firstname" class="form-control" placeholder="First Name">
                                        @if ($errors->has('firstname'))<p class="help-block" style="color:red;">{!!$errors->first('firstname')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input name="lastname" class="form-control" placeholder="Last Name">
                                        @if ($errors->has('lastname'))<p class="help-block" style="color:red;">{!!$errors->first('lastname')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input name="email" class="form-control" placeholder="Email">
                                        @if ($errors->has('email'))<p class="help-block" style="color:red;">{!!$errors->first('email')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                        @if ($errors->has('password'))<p class="help-block" style="color:red;">{!!$errors->first('password')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password2" class="form-control" placeholder="Confirm Password">
                                        @if ($errors->has('password2'))<p class="help-block" style="color:red;">{!!$errors->first('password2')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <button name="submit" type="submit" class="btn btn-success">Create</button>
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
                        <h3>USERS</h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Created</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)

                                    <tr class="gradeU">
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td class="center">{{date('F d, Y', strtotime($user->created_at))}}</td>
                                        <td class="center">
                                            @if($user->isActive == 1)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td align="center">
                                            <form action="destroy">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <input type="hidden" name="status" value="{{$user->isActive}}">
                                                @if($user->isActive == 1)
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
