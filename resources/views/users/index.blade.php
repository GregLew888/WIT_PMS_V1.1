@extends('layouts.app', ['page' => __('users'), 'pageSlug' => 'users'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">clients</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Register New Client</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter hover" id="example">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Annual Income</th>
                                    <th scope="col">Liquid Net Worth</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->full_address }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->annual_income }}</td>
                                        <td>{{ $user->liquid_net_worth }}</td>
                                        <td>
                                            <a href="{{ $user->getFirstMediaUrl('profile_image') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                View
                                                <div class="ml-3 photo">
                                                    <img src="{{ $user->getFirstMediaUrl('profile_image') }}"
                                                        alt="{{ __('Profile Photo') }}">
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('users.approve', $user->id) }}">Activate</a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#exampleModal" data-userid="{{ $user->id }}">
                                                Delete
                                            </button>
                                            <!-- Button trigger modal -->
                                        </td>
                                    </tr>
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
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>

        </div>
    </div>


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
                    <form action="#" method="post" id="deleteuser">
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
                    <h5 class="modal-title" id="exampleModalLongTitle">user Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="user-details">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    @push('js')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {

                //data table
                $('#example').DataTable();
                //data table

                //deletion
                let route = "{{ route('users.index') }}/";
                $('#exampleModal').on('show.bs.modal', function(event) {
                    let userId = $(event.relatedTarget).data('userid');
                    $('#deleteuser').prop('action', route + userId);
                })
                //deletion



            });
        </script>
    @endpush
@endsection
