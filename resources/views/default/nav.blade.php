<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="{{asset('images/castoLogo.jpg')}}" wi /></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user pull-right">
                <li><a href="{{url('user/profile')}}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-search fa-fw"></i> Filter Parameters<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <div class="row" id="filter">
                            <div class="col-lg-12">

                                <div class="col-lg-12">
                                    <div>Profile Type:</div>
                                    <form action="/home/clientlist/update" method="post" id="frmProfileType">
                                        {{csrf_field()}}
                                        <select name="profiletype" class="form-control" id="profiletype">
                                            <option value="">- select profile type -</option>
                                            <option value="'11','31'">Corporate & Group</option>
                                            <option value="'11','0'">Corporate</option>
                                            <option value="'31','0'">Group</option>
                                            <option value="'51','0'">Personal</option>
                                        </select>
                                        <br />
                                    </form>
                                </div>

                                @if(isset($clientlist))
                                    <div class="col-lg-12">
                                        <div>Client:</div>
                                        <form action="/home/report/generate" method="post" id="frmClientList">
                                            {{csrf_field()}}
                                            <select multiple name="client[]" class="form-control" id="clientlist">
                                                @foreach($clientlist as $client)
                                                    <option value="{{$client->cltID}}">{{$client->cltName}}</option>
                                                @endforeach
                                            </select>
                                            <br />
                                            <div>Year:</div>
                                            <select name="year" class="form-control">
                                                <optgroup>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                </optgroup>
                                            </select>
                                            <br />
                                            <button type="submit" class="btn btn-primary center-block">Generate</button>
                                            <br />
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </ul>
                </li>
                <li>
                    <a href="{{url('home/dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{url('air')}}"><i class="fa fa-plane fa-fw"></i> AIR</a>
                </li>
                <!-- Hotel -->
                <li>
                    <a href="{{url('hotel')}}"><i class="fa fa-bed fa-fw"></i> HOTEL</a>
                </li>
                <!-- Rail -->
                <li>
                    <a href="{{url('rail')}}"><i class="fa fa-train fa-fw"></i> RAIL</a>
                </li>
                <!-- Car -->
                <li>
                    <a href="{{url('car')}}"><i class="fa fa-car fa-fw"></i> CAR</a>
                </li>
                <!-- Visa & Passport -->
                <li>
                    <a href="{{url('visa')}}"><i class="fa fa-globe fa-fw"></i> VISA</a>
                </li>
                <!-- Transaction Fees -->
                <li>
                    <a href="{{url('fees')}}"><i class="fa fa-money fa-fw"></i> TRANSACTION FEES </a>
                </li>

                @if(\App\UserGroup::getUserGroup(Auth::id()) == 'ADMIN')
                <li>
                    <a href="#"><i class="fa fa-group fa-fw"></i> Admin<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{url('admin/user/create')}}">Users</a>
                        </li>
                        <li>
                            <a href="{{url('admin/group/create')}}">Groups</a>
                        </li>
                        <li>
                            <a href="{{url('admin/usergroup/create')}}">Assign Group</a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>