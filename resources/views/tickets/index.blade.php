@extends('layouts.app', ['page' => __('Tickets'), 'pageSlug' => 'tickets'])
@section('content')
    <div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Tickets</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')
                
                <div class="">
                    <table class="table tablesorter hover" id="example">
                        <thead class=" text-primary">
                            <tr><th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Files</th>
                            <th scope="col"></th>
                        </tr></thead>
                        <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{$ticket->id}}</td>
                                <td>{{$ticket->title}}</td>
                                <td>{{$ticket->description}}</td>
                                <td>{{$ticket->customer->name}}</td>
                                <td>
                                    @foreach ($ticket->getMedia('files') as $file)
                                        <a href="{{$file->getUrl()}}" target="_blank" rel="noopener noreferrer">
                                            View
                                            <div class="ml-3 photo">
                                                <img src="{{$file->getUrl()}}">
                                            </div>
                                        </a>
                                    @endforeach
                                </td>
                                <td class="td-actions text-right">
                                @role('admin')
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal" data-ticketid="{{$ticket->id}}" >
                                        Delete
                                    </button>
                                    <!-- Button trigger modal -->
                                @endrole
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#exampleModalLong" data-ticketid="{{$ticket->id}}">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <h6>Nothing Found</h6>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                
            </div>
            

        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete the ticket
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="#" method="post" id="deleteticket">
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
<div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ticket Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ticket-details">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

    @push('js')
    
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function(){

                //data table
                $('#example').DataTable();
                //data table

                //deletion
                let route = "{{route('tickets.index')}}/";
                $('#exampleModal').on('show.bs.modal', function (event) {
                    let ticketId = $(event.relatedTarget).data('ticketid');
                    $('#deleteticket').prop('action', route + ticketId);
                })
                //deletion
                
                let tickets = JSON.parse(`{!!$ticketsJson!!}`);
                console.log(tickets);

                $('#exampleModalLong').on('show.bs.modal', function (event) {

                    let ticketId = $(event.relatedTarget).data('ticketid');
                    ticket = tickets.find(ticket => ticket.id == ticketId);

                    let data = 
                        `<p><b class="title">ID: </b><i>${ticket.id}</i></p>`+
                        `<p><b class="title">Title: </b>${ticket.title}</p>`+
                        `<p><b class="title">Description: </b>${ticket.description}</p>`+
                        `<p><b class="title">Customer: </b>${ticket.customer.name}</p>`;

                        if (ticket.replies.length > 0) {
                            data+= `<hr><h3>Replies</h3>`;
                        }

                        ticket.replies.forEach(reply => {
                            
                            data +=`<div class="card">
                                <div class="card-header">
                                    ${reply.user.name}  <br>~${reply.created_at}
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                    <p>${reply.text}<p>
                                    </blockquote>
                                </div>
                            </div><hr>`;
                        });

                    data+= `<form method="post" action="{{ route('replies.store') }}">
                    <div class="card-body">
                            @csrf
                            <input name="user_id" value="{{auth()->user()->id}}" type="hidden">
                            <input name="ticket_id" value="${ticket.id}" type="hidden">
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label>{{ _('Reply') }}</label>
                                    <textarea name="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ _('Reply Here...') }}" value="{{ old('description') }}"></textarea>
                                    @include('alerts.feedback', ['field' => 'description'])
                                </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-success">{{ _('Reply') }}</button>
                            </div>
                    </form>`;

                    $('#ticket-details').html(data);

                })

        
            });
        </script>
    @endpush
@endsection