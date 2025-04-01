@extends('layouts.app', ['page' => __('Users'), 'pageSlug' => 'activeUsers'])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="card-title">Clients</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right mb-2">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Register New Client</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" action="{{ route('users.active.index', ['rd' => 1]) }}" id="frm-active-users"
                        method="get">
                        <input type="hidden" name="page" value="0">
                        <label class="my-1 mr-3" for="inlineFormInputName2">Name</label>
                        <input type="text" class="form-control my-1 mr-3" id="keyword" name="keyword"
                            placeholder="By Name, email" value="{{ request('keyword') }}">
                        <input type="submit" class="btn btn-primary mb-2" value="Submit" />
                    </form>
                    @include('alerts.success')
                </div>
            </div>
        </div>
    </div>
    {{ $users->links() }}
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid">
                <div class="row gy-5 card-group">
                    @forelse ($users as $user)
                        <div class="col-md-3 col-lg-4 border-dark">
                            @include('users._card', ['user' => $user, 'show_user_info' => true])
                        </div>
                    @empty
                       <tr>
                                <td colspan="2">
                                    <tr>
    <td colspan="12" class="text-center py-5">
        <h5 class="text-muted">No Transactions Available</h5>
        <p class="text-muted mb-0">
            Your portfolio currently does not have any transactions to display.
        </p>
    </td>
</tr>

                                </td>
                            </tr>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    {{ $users->links() }}
    <div class="row">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the user
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="#" method="post" id="deletebook">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-warning">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->



        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Book Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="book-details">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
    @endsection
