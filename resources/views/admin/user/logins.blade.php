@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="page-title mt-0 d-inline">{{ $user->name }} :=: Log in/out History </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-borderless table-hover mb-0" id="stockTable" width="100%">
                            <thead class="thead-light">
                            <tr>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    <tr class="{{$history->action == 'Login' ? 'text-success' : ($history->action == 'Logout' ? 'text-danger' : '')}}">
                                        <td>{{ $history->action }}</td>
                                        <td>{{ $history->created_at->format('d-M-Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $histories->links() }}
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h4 class="page-title mt-0 d-inline">{{ $user->name }} :=: <span>{{$logins->count()}}</span> Active Devices </h4>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" class="text-md-right">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                                <input type="text" name="password" placeholder="User's Password" class="px-1 mr-1">
                                <button class="btn btn-danger btn-add btn-xs waves-effect waves-light float-right"><i class="fas fa-fire mr-1"></i> Logout Other Devices</button>
                            </form>
                        </div><!-- end col-->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-borderless table-hover mb-0" id="stockTable" width="100%">
                            <thead class="thead-light">
                            <tr>
                                <!--<th>IP Address</th>-->
                                <th>User Agent</th>
                                <th>Last Activity</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($logins as $session)
                                    <tr>
                                        <!--<td>{{ $session->ip_address }}</td>-->
                                        <td>{{ $session->user_agent }}</td>
                                        <td>{{ date('d-M-Y h:i A', $session->last_activity) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <div class="modal fade bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="roleID">Role</label>
                        <select name="roleID" class="form-control" id="roleID"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-submit btn-primary">Save</button>
                    <input type="hidden" id="userID">
                    @csrf
                </div>
            </div>
        </div>
    </div>

@endsection
