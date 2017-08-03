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
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <h3>USER PROFILE</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="profile/update" method="post" role="form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="firstname" class="form-control" placeholder="First Name" value="{{$logged_user['original']['firstname']}}">
                                        @if ($errors->has('firstname'))<p class="help-block" style="color:red;">{!!$errors->first('firstname')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lastname" class="form-control" placeholder="Last Name" value="{{$logged_user['original']['lastname']}}">
                                        @if ($errors->has('lastname'))<p class="help-block" style="color:red;">{!!$errors->first('lastname')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <label>Change Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                                        @if ($errors->has('password'))<p class="help-block" style="color:red;">{!!$errors->first('password')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password2" class="form-control" placeholder="Re-enter New Password">
                                        @if ($errors->has('password2'))<p class="help-block" style="color:red;">{!!$errors->first('password2')!!}</p>@endif
                                    </div>
                                    <div class="form-group">
                                        <button name="submit" type="submit" class="btn btn-primary">Update</button>
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

<!-- Custom Theme JavaScript -->
<script src="{{asset('dist/js/sb-admin-2.js')}}"></script>

</body>

</html>
