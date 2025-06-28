@extends('layouts.app', ['page' => __('Shipments'), 'pageSlug' => 'shipments'])
@section('content')
    <div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Shipments</h4>
                    </div>
                    @role('origin-supervisor')
                    <div class="col-4 text-right">
                        <a href="{{route('shipments.create')}}" class="btn btn-sm btn-success">Add Shipment</a>
                    </div>
                    @endrole
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')
                
                <div class="">
                    <table class="table tablesorter hover" id="example">
                        <thead class=" text-primary">
                            <tr>
                                @if(auth()->user()->hasAnyRole(['admin', 'origin-supervisor', 'local-supervisor']))
                                <th scope="col">Customer Name</th>
                                @endif
                                <th scope="col">Tracking ID</th>
                                <th scope="col">Number of boxes</th>
                                <th scope="col">CBM</th>
                                <th scope="col">KG</th>
                                <th scope="col">Freight Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Arrived</th>
                                <th scope="col">Price</th>
                                <th scope="col">Files</th>
                                @if(auth()->user()->hasAnyRole(['admin', 'origin-supervisor', 'local-supervisor']))
                                <th scope="col"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($shipments as $shipment)
                            <tr>
                                @if(auth()->user()->hasAnyRole(['admin', 'origin-supervisor', 'local-supervisor']))
                                <td>{{$shipment->customer->name}}</td>
                                @endif
                                <td>{{$shipment->tracking_id}}</td>
                                <td>{{$shipment->number_of_boxes}}</td>
                                <td>{{$shipment->cbm}}</td>
                                <td>{{$shipment->kg}}</td>
                                <td>{{$shipment->freight_type}}</td>
                                <td>{{$shipment->status}}</td>
                                <td>
                                    {{$shipment->arrived_at}}
                                </td>
                                <td>
                                    {{$shipment->price}}
                                </td>
                                <td>
                                    @foreach ($shipment->getMedia('files') as $file)
                                        <a href="{{$file->getUrl()}}" target="_blank" rel="noopener noreferrer">
                                             View
                                            <div class="ml-3 photo">
                                                <img src="{{$file->getUrl()}}">
                                            </div>
                                        </a>
                                    @endforeach
                                </td>
                                @if(auth()->user()->hasAnyRole(['admin', 'origin-supervisor', 'local-supervisor']))
                                <td class="td-actions text-right">
                                    @role('local-supervisor')
                                    <a class="btn btn-success btn-sm" href="{{route('local.edit', $shipment->id)}}">Edit</a>
                                    @else
                                    <a class="btn btn-success btn-sm" href="{{route('shipments.edit', $shipment->id)}}">Edit</a>
                                    @endrole
                                    <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal" data-shipmentid="{{$shipment->id}}" >
                                        Delete
                                    </button> -->
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-default btn-sm mt-1" data-toggle="modal" data-target="#exampleModalLong" data-shipmentid="{{$shipment->id}}">
                                        View
                                    </button>
                                </td>
                                @endif
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
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete the shipment
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="#" method="post" id="deleteshipment">
            @csrf
            @method('DELETE')
        
            <button type="submit" class="btn btn-warning">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div> -->
<!-- Modal -->



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Shipment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="shipment-details">
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
                let route = "{{route('shipments.index')}}/";
                $('#exampleModal').on('show.bs.modal', function (event) {
                    let shipmentId = $(event.relatedTarget).data('shipmentid');
                    $('#deleteshipment').prop('action', route + shipmentId);
                })
                //deletion
                
                let shipments = JSON.parse(`{!!$shipmentsJson!!}`);

                $('#exampleModalLong').on('show.bs.modal', function (event) {

                    let shipmentId = $(event.relatedTarget).data('shipmentid');
                    shipment = shipments.find(shipment => shipment.id == shipmentId);

                    let data = 
                        `<p><b class="title">Tracking ID: </b><i>${shipment.tracking_id}</i></p>`+
                        `<p><b class="title">Number Of Boxes: </b>${shipment.number_of_boxes}</p>`+
                        `<p><b class="title">Freight Type: </b>${shipment.freight_type}</p>`+
                        `<p><b class="title">In KG: </b>${shipment.kg}</p>`+
                        `<p><b class="title">In CBM: </b>${shipment.cbm}</p>`+
                        `<p><b class="title">Arrived Date: </b>${shipment.arrived_at}</p>`;

                    $('#shipment-details').html(data);

                })


        
            });
        </script>
    @endpush
@endsection