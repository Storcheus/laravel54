<html>
<head>
    <title>Application</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Application CRUD
            <button id="btn_add" name="btn_add" class="btn btn-default pull-right">Add User</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Personal Code</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="users-list" name="users-list">
                        @foreach ($users as $user)
                            <tr id="user{{$user->id}}">
                                <td>{{$user->id}}</td>
                                <td>{{$user->firstname}}</td>
                                <td>{{$user->lastname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->personal_code}}</td>
                                <td>
                                    <button class="btn btn-warning btn-detail open_modal" value="{{$user->id}}">Edit</button>
                                    <button class="btn btn-danger btn-delete delete-user" value="{{$user->id}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">User</h4>
                </div>
                <div class="modal-body">
                    <form id="formUsers" name="formUsers" class="form-horizontal" novalidate="">
                        <div class="form-group error">
                            <label for="firstname" class="col-sm-3 col-xs-3 control-label">Firstname</label>
                            <div class="col-sm-9 col-xs-9">
                                <input type="text" class="form-control has-error" id="firstname" name="firstname" placeholder="Firstname" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="col-sm-3 col-xs-3 control-label">Lastname</label>
                            <div class="col-sm-9 col-xs-9">
                                <input type="text" class="form-control" id="lastname" name="larstname" placeholder="Lastname" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 col-xs-3 control-label">Email</label>
                            <div class="col-sm-9 col-xs-9">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="personal_code" class="col-sm-3 col-xs-3 control-label">Personal Code</label>
                            <div class="col-sm-9 col-xs-9">
                                <input type="text" class="form-control" id="personal_code" name="personal_code" placeholder="Personal code" value="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                    <input type="hidden" id="user_id" name="user_id" value="0">
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/user.js')}}"></script>
</body>
</html>