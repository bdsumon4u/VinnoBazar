@extends('layouts.app')

@push('css')
    <link href="{{asset('libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <?php $status = ucfirst($status); ?>
     <div class="row">
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Pending Invoiced')}}">
                <div class="widget-rounded-circle card-box order pt-1 pb-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1 mb-0">
                                    <span id="pendingInvoiced" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Pending Invoiced</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Invoiced')}}">
                <div class="widget-rounded-circle card-box order pt-1 pb-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1 mb-0">
                                    <span id="invoiced" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Invoiced</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Stock Out')}}">
                <div class="widget-rounded-circle card-box order pt-1 pb-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1 mb-0">
                                    <span id="stockOut" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Stock Out</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
     </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <h4 class="page-title mt-0 d-inline">Total <span class="total">0</span> Orders </h4>
                    </div>
                    <div class="col-md-8">
                        <div class="text-md-right">

                            <div class="btn-group dropdown ml-2 float-right">
                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn bg-info btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-thumbtack mr-1"></i> Change Status</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item btn-change-status" data-status="Pending Invoiced" href="#">Pending Invoiced</a>
                                    <a class="dropdown-item btn-change-status" data-status="Invoiced" href="#">Invoiced</a>
                                    <a class="dropdown-item btn-change-status"  data-status="Stock Out" href="#">Stock Out</a>
                                    <a class="dropdown-item btn-change-status"  data-status="Delivered" href="#">Delivered</a>
                                </div>
                            </div>
                            <div class="btn-group dropdown ml-2 float-right">
                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn bg-success btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-check mr-1"></i> Assign User</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach($users as $user)
                                            <a class="dropdown-item btn-assign-user" data-id="{{$user->id}}" href="#">{{$user->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button"
                                    class="btn btn-danger btn-all-delete btn-xs waves-effect waves-light ml-2 float-right"><i
                                    class="fas fa-trash mr-1"></i> Delete All
                            </button>
                            <a  href="{{url('admin/order/create')}}"
                                    class="btn btn-primary btn-add btn-xs waves-effect waves-light float-right"><i
                                    class="fas fa-plus mr-1"></i> Add New Order
                            </a>
                            <button type="button" class="btn btn-warning btn-print btn-xs waves-effect waves-light mr-2 float-right">
                                <i class="fas fa-print mr-1"></i> Invoice Print
                            </button>
                            <button type="button"
                                    class="btn btn-warning btn-pathao btn-xs waves-effect waves-light mr-2 float-right"><i
                                    class="fas fa-sync mr-1"></i> Pathao
                            </button>
                        </div>
                    </div>
                </div>

                <table class="table table-centered table-striped" id="orderTable"
                       style="width: 100%;" data-status="<?php echo isset($status) == '' ? "all" : $status; ?>">

                    <thead>
                    <tr>
                        <th></th>
                        <th>Invoice ID</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Courier</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>User</th>
                        <th class="hidden-sm">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<div class="modal fade bs-example-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit" class="btn btn-primary">Save</button>
                @csrf
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('libs/select2/select2.min.js')}}"></script>
    <script>

        $(document).ready(function () {
            var table = $("#orderTable").DataTable({
                ajax: {
                    url:"{{url('admin/order/show')}}?status=" + $('#orderTable').attr('data-status'),
                },
                ordering: false,
                processing: true,
                serverSide: true,
                pageLength: 50,
                rowId: "id",
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    },
                ],
                columns: [
                    {data: 'id',searchable:false},
                    {data: 'invoice',searchable:false},
                    {data: 'customerInfo',width: "15%",searchable:false},
                    {data: "products",width: "15%",searchable:false},
                    {data: "subTotal",searchable:false},
                    {data: "courierName",width: "10%",searchable:false},
                    {data: "orderDate",width: "10%",searchable:false},
                    {data: 'statusButton',width: "10%",searchable:false},
                    {data: 'notification',width: "15%",searchable:false},
                    {data: "name", searchable:false},
                    {data: "action",searchable:false}
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'>",
                        next: "<i class='fas fa-chevron-right'>"
                    }
                },
                initComplete: function(settings, json) {
                    loadcountOrders();
                    $(".dataTables_paginate > .pagination").addClass("pagination-sm")
                },
                footerCallback: function ( ) {
                    var api = this.api();
                    var numRows = api.rows().count();
                    $('.total').empty().append(numRows);

                    var intVal = function (i) {
                        return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
                    };
                    pageTotal = api.column(4, { page: "current" }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(pageTotal + " Tk");
                }
            });

            $('#orderTable thead th').each(function () {
            var title = $(this).text();
            if(title != 'Status'
            && title != ''
            && title != 'Action'
            && title != 'Products'
            && title != 'Total'
            && title != 'Notes'){
                // console.log(title);
                if(title == 'Order Date'){
                    $(this).html(' <input type="text" class="form-control datepicker" placeholder="Date" />');
                }

                if(title == 'Courier'){
                    $(this).html(' <select type="text" class="form-control courierID" placeholder="Courier" ></select>');
                }
                if(title == 'User'){
                    $(this).html(' <select type="text" class="form-control" id="userID" placeholder="User" ></select>');
                }
                if(title == 'Invoice ID'){
                    $(this).html(' <input type="text" class="form-control" placeholder="User ID" />');
                }
                if(title == 'Name'){
                    $(this).html(' <input type="text" class="form-control" placeholder="Customer Phone" />');
                }
                
            }
        });

        $("#userID").select2({
                placeholder: "Select a User",
                allowClear:true,
                ajax: {
                    url:'{{url('admin/order/users')}}',
                    processResults: function (data) {
                        var data = $.parseJSON(data);
                        return {
                            results: data
                        };
                    }
                }
        });

        $(".courierID").select2({
                placeholder: "Select a Courier",
                allowClear:true,
                ajax: {
                    url: '{{url('admin/order/courier')}}',
                    processResults: function (data) {
                        var data = $.parseJSON(data);
                        return {
                            results: data
                        };
                    }
                }
        });



            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                if (table.search() !== this.value) {
                	   table.search(this.value).draw();
                    }
                });
            });

            function loadcountOrders(){
                $.ajax({
                type: "get",
                url: "{{url('admin/order/countOrders')}}",
                contentType: "application/json",
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data["status"] == "success") {

                        $('#delivered').text(data["delivered"]);
                        $('#customerConfirm').text(data["customerConfirm"]);
                        $('#paid').text(data["paid"]);
                        $('#return').text(data["return"]);
                        $('#lost').text(data["lost"]);
                        $('#pendingInvoiced').text(data["pendingInvoiced"]);
                        $('#invoiced').text(data["invoiced"]);
                        $('#stockOut').text(data["stockOut"]);
                        $('#all').text(data["all"]);
                        $('#processing').text(data["processing"]);
                        $('#pendingPayment').text(data["pendingPayment"]);
                        $('#onHold').text(data["onHold"]);
                        $('#canceled').text(data["canceled"]);
                        $('#completed').text(data["completed"]);

                        // console.log(data)
                    } else {
                        if (data["status"] == "failed") {
                            Swal.fire(data["message"]);
                        } else {
                            Swal.fire("Something wrong ! Please try again.");
                        }
                    }
                }
            });
            }

            var token = $("input[name='_token']").val();

            $(document).on('click', '.btn-all-delete', function (e) {
                e.preventDefault();

                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.value) {
                        jQuery.ajax({
                            type: "get",
                            url: "{{url('admin/order/deleteAll')}}",
                            contentType: "application/json",
                            data: {
                                action: "deleteOrder",
                                ids: ids
                            },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data["status"] == "success") {
                                    Swal.fire(data["message"]);
                                    table.ajax.reload();
                                } else {
                                    if (data["status"] == "failed") {
                                        Swal.fire(data["message"]);
                                    } else {
                                        Swal.fire("Something wrong ! Please try again.");
                                    }
                                }
                            },
                            complete: function () {
                                $(document).find('.dt-checkboxes-select-all').click();
                            }
                        });
                    }
                });

            });

            $(document).on('click', '.btn-assign-user', function (e) {
                e.preventDefault();

                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                var user_id = $(this).attr('data-id');

                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/assign')}}",
                    contentType: "application/json",
                    data: {
                        action: "assign",
                        ids: ids,
                        user_id: user_id
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] == "success") {
                            Swal.fire(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data["status"] == "failed") {
                                Swal.fire(data["message"]);
                            } else {
                                Swal.fire("Something wrong ! Please try again.");
                            }
                        }
                    },
                    complete: function () {
                        $(document).find('.dt-checkboxes-select-all').click();
                    }
                });

            });

            $(document).on('click', '.btn-sync', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Auto sync start!',
                    html: 'It will close after all order sync.',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/orderSync')}}",
                    contentType: 'application/json',
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            Swal.fire({
                                title: data['message'],
                                html: data['orders'] +
                                    ' Orders Sync.'

                            }).then(function() {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: data['message'],
                                html: data['orders'] +
                                    ' Orders Sync.'

                            });
                        }
                    }
                });



            });

            $(document).on('click', '.btn-change-status', function (e) {
                e.preventDefault();
                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                var status = $(this).attr('data-status');
                 $.ajax({
                    type: "get",
                    url: "{{url('admin/order/changeStatusByCheckbox')}}",
                    data: {
                        'status': status,
                        'ids': ids,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            toastr.success(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data['status'] == 'failed') {
                                toastr.error(data["message"]);
                            } else {
                                toastr.error('Something wrong ! Please try again.');
                            }
                        }
                    },
                    complete: function () {
                        $(document).find('.dt-checkboxes-select-all').click();
                    }
                });
            });

            $(document).on('click', '.btn-status', function (e) {
                e.preventDefault();
                var status = $(this).attr('data-status');
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "get",
                    url: "{{url('admin/order/status')}}",
                    data: {
                        'status': status,
                        'id': id,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            toastr.success(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data['status'] == 'failed') {
                                toastr.error(data["message"]);
                            } else {
                                toastr.error('Something wrong ! Please try again.');
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "get",
                    url: "{{url('admin/order')}}/"+id+"/edit",
                    data: {
                        '_token': token
                    },
                    success: function (response) {

                        $('.modal .modal-body').empty().append(response);
                        $('.modal').modal('toggle');
                        $('.modal-footer').hide();

                        $(".datepicker").flatpickr();

                        $("#productID").select2({
                            placeholder: "Select a Product",
                            templateResult: function (state) {
                                if (!state.id) {
                                    return state.text;
                                }
                                var $state = $(
                                    '<span><img width="60px" src="' +
                                    state.image +
                                    '" class="img-flag" /> ' +
                                    state.text +
                                    "</span>"
                                );
                                return $state;
                            },
                            ajax: {
                                url: '{{url('admin/order/product')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data.data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                            $("#productTable tbody").append(
                                "<tr>" +
                                '<td  style="display: none"><input type="text" class="productID" style="width:80px;" value="' + e.params.data.id + '"></td>' +
                                '<td><span class="productCode">' + e.params.data.productCode + '</span></td>' +
                                '<td><span class="productName">' + e.params.data.text + '</span></td>' +
                                '<td><input type="number" class="productQuantity form-control" style="width:80px;" value="1"></td>' +
                                '<td><span class="productPrice">' + e.params.data.productPrice + '</span></td>' +
                                '<td><button class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                                "</tr>"
                            );
                            calculation();
                        });

                        $("#storeID").select2({
                            placeholder: "Select a Store",
                            ajax: {
                                url: '{{url('admin/order/stores')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });


                        $("#courierID").select2({
                            placeholder: "Select a Courier",
                            ajax: {
                                url: '{{url('admin/order/courier')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                              $("#zoneID").empty();
                              for (var i = 0; i < couriers.length; i++) {
                                if (couriers[i]['courierName'] == e.params.data.text) {
                                     if (couriers[i]['hasCity'] == 'on') {
                                        jQuery(".hasCity").show();
                                    } else {
                                        jQuery(".hasCity").hide();
                                    }
                                    if (couriers[i]["hasZone"] == 'on') {
                                        jQuery(".hasZone").show();
                                    } else {
                                        jQuery(".hasZone").hide();
                                        $("#zoneID").empty();
                                    }
                                }

                                if (e.params.data.text == 'Pathao') {
                                    $("#cityID").empty().append('<option value="8">Dhaka</option>');
                                } else {
                                    $("#cityID").empty();
                                }
                            }

                        });

                        if ($("#courierID").text()) {
                            var courier = $("#courierID").text().trim();
                             for (var i = 0; i < couriers.length; i++) {
                                if (couriers[i]['courierName'] == courier) {
                                     if (couriers[i]['hasCity'] == 'on') {
                                        jQuery(".hasCity").show();
                                    } else {
                                        jQuery(".hasCity").hide();
                                    }

                                    if (couriers[i]["hasZone"] == 'on') {
                                        jQuery(".hasZone").show();
                                    } else {
                                        jQuery(".hasZone").hide();
                                        $("#zoneID").empty();
                                    }
                                }
                            }
                        }

                        $("#cityID").select2({
                            placeholder: "Select a City",
                            ajax: {
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        courierID: $("#courierID").val()
                                    };
                                    return query;
                                },
                                url: '{{url('admin/order/city')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });

                        $("#zoneID").select2({
                            placeholder: "Select a Zone",
                            ajax: {
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        courierID: $("#courierID").val(),
                                        cityID: $("#cityID").val()
                                    };
                                    return query;
                                },
                                url: '{{url('admin/order/zone')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });


                        var orderNoteTable = $("#orderNoteTable").DataTable({
                            ajax: "{{url('admin/order/getNotes')}}?id=" + $('#orderNoteTable').attr('data-id'),
                            ordering: false,
                            lengthChange: false,
                            bFilter:false,
                            search:false,
                            info:false,
                            columns: [
                                {data: "date"},
                                {data: "notificaton"},
                                {data: "name"}
                            ],
                        });

                        var oldOrderTable = $("#oldOrderTable").DataTable({
                            ajax: "{{url('admin/order/oldOrders')}}?id=" + $('#oldOrderTable').attr('data-id'),
                            ordering: false,
                            lengthChange: false,
                            bFilter:false,
                            search:false,
                            info:false,
                            columns: [
                                {data: "invoiceID"},
                                {
                                    data: null,
                                    width: "15%",
                                    render: function (data) {
                                        return '<i class="fas fa-user mr-2 text-grey-dark"></i>'+data.customerName +'<br> <i class="fas fa-phone  mr-2 text-grey-dark"></i>'+data.customerPhone+'<br><i class="fas fa-map-marker mr-2 text-grey-dark"></i>' + data.customerAddress;
                                    }
                                },
                                {data: "products"},
                                {data: "subTotal"},
                                {data: "status"}
                            ]
                        });

                        $(document).on("click", "#updateNote", function () {
                            let note = $('#note');
                            let id = $('#btn-update').val()
                            if(note.val() == ''){
                                note.css('border','1px solid red');
                                return;
                            }else if( id == ''){
                                toastr.success('Something Wrong , Try again ! ');
                                return;
                            }else{
                                $.ajax({
                                    type: "get",
                                    url: "{{url('admin/order/updateNotes')}}",
                                    data: {
                                        'note': note.val(),
                                        'id': id,
                                        '_token': token
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        if (data['status'] == 'success') {
                                            toastr.success(data["message"]);
                                            orderNoteTable.ajax.reload();
                                        } else {
                                            if (data['status'] == 'failed') {
                                                toastr.error(data["message"]);
                                            } else {
                                                toastr.error('Something wrong ! Please try again.');
                                            }
                                        }
                                    }
                                });
                            }


                        });


                        if ($("#paymentTypeID").text()) {
                            var paymentType = $("#paymentTypeID").val();
                            if (paymentType == "") {
                                $(".paymentID").hide();
                                $(".paymentAgentNumber").hide();
                                $(".paymentAmount").hide();
                            } else {
                                $(".paymentID").show();
                                $(".paymentAgentNumber").show();
                                $(".paymentAmount").show();
                            }
                        }

                        $("#paymentTypeID").select2({
                            placeholder: "Select a payment Type",
                            allowClear: true,
                            ajax: {
                                data: function (params) {
                                    return {
                                        q: params.term
                                    };
                                },
                                url: '{{url('admin/order/paymenttype')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                            if (e.params.data.text == "") {
                                $(".paymentID").hide();
                                $(".paymentAgentNumber").hide();
                                $(".paymentAmount").hide();
                            } else {
                                $(".paymentID").show();
                                $(".paymentAgentNumber").show();
                                $(".paymentAmount").show();
                            }
                        }).on("select2:unselect", function (e) {
                            $(".paymentID").hide();
                            $(".paymentAgentNumber").hide();
                            $(".paymentAmount").hide();
                            calculation();
                        });

                        $("#paymentID").select2({
                            placeholder: "Select a payment Number",
                            allowClear: true,
                            ajax: {
                                data: function (params) {
                                    return {
                                        q: params.term,
                                        paymentTypeID: $("#paymentTypeID").val(),
                                    };
                                },
                                url: '{{url('admin/order/paymentnumber')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });

                        $(document).on("change", ".productQuantity", function () {
                             calculation();
                        });
                        $(document).on("input", "#paymentAmount", function () {
                            calculation();
                        });
                        $(document).on("input", "#deliveryCharge", function () {
                            calculation();
                        });
                        $(document).on("input", "#discountCharge", function () {
                            calculation();
                        });

                        calculation();

                        function calculation() {
                            var subtotal = 0;
                            var deliveryCharge = +$("#deliveryCharge").val();
                            var discountCharge = +$("#discountCharge").val();
                            var paymentAmount = +$("#paymentAmount").val();
                            $("#productTable tbody tr").each(function (index) {
                                subtotal = subtotal + +$(this).find(".productPrice").text() * +$(this).find(".productQuantity").val();
                            });
                            $("#subtotal").text(subtotal);
                            $("#total").text(subtotal + deliveryCharge - paymentAmount - discountCharge);
                        }

                        $(document).on("click", ".delete-btn", function () {
                            $(this).closest("tr").remove();
                            calculation();
                        });


                    }
                });
            });


            $(document).on("click", "#btn-update", function () {
                var id =  $(this).val();
                var invoiceID = $("#invoiceID");
                var customerName = $("#customerName");
                var customerPhone = $("#customerPhone");
                var customerAddress = $("#customerAddress");
                var storeID = $("#storeID");
                var total = +$("#total").text();
                var deliveryCharge = +$("#deliveryCharge").val();
                var discountCharge = +$("#discountCharge").val();
                var paymentTypeID = $("#paymentTypeID").val();
                var paymentID = $("#paymentID").val();
                var paymentAmount = +$("#paymentAmount").val();
                var paymentAgentNumber = $("#paymentAgentNumber").val();
                var orderDate = $("#orderDate");
                var courierID = $("#courierID");
                var cityID = +$("#cityID").val();
                var zoneID = +$("#zoneID").val();
                var memo = +$("#memo").val();
                var product = [];
                var productCount = 0 ;
                $("#productTable tbody tr").each(function (index, value) {
                    var currentRow = $(this);
                    var obj = {};
                    obj.productID = currentRow.find(".productID").val();
                    obj.productCode = currentRow.find(".productCode").text();
                    obj.productName = currentRow.find(".productName").text();
                    obj.productQuantity = currentRow.find(".productQuantity").val();
                    obj.productPrice = currentRow.find(".productPrice").text();
                    product.push(obj);
                    productCount++;
                });

                if(storeID.val() == ''){
                    toastr.error('Store Should Not Be Empty');
                    storeID.closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                storeID.closest('.form-group').find('.select2-selection').css('border','1px solid #ced4da');

                if(invoiceID.val() == ''){
                    toastr.error('Invoice ID Should Not Be Empty');
                    invoiceID.css('border','1px solid red');
                    return;
                }
                invoiceID.css('border','1px solid #ced4da');

                if(customerName.val() == ''){
                    toastr.error('Customer Name Should Not Be Empty');
                    customerName.css('border','1px solid red');
                    return;
                }
                customerName.css('border','1px solid #ced4da');

                if(customerPhone.val() == ''){
                    toastr.error('Customer Phone Should Not Be Empty');
                    customerPhone.css('border','1px solid red');
                    return;
                }
                customerPhone.css('border','1px solid #ced4da');

                if(customerAddress.val() == ''){
                    toastr.error('Customer Address Should Not Be Empty');
                    customerAddress.css('border','1px solid red');
                    return;
                }
                customerAddress.css('border','1px solid #ced4da');

                if(orderDate.val() == ''){
                    toastr.error('Order Date Should Not Be Empty');
                    orderDate.css('border','1px solid red');
                    return;
                }
                orderDate.css('border','1px solid #ced4da');

                if(courierID.val() == ''){
                    toastr.error('Courier Should Not Be Empty');
                    courierID.closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                courierID.css('border','1px solid #ced4da');

                if(courierID.val() == '34' && !cityID){
                    toastr.error('City Should Not Be Empty');
                    $('#cityID').closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                $('#cityID').css('border','1px solid #ced4da');

                if(courierID.val() == '34' && !zoneID){
                    toastr.error('Zone Should Not Be Empty');
                    $('#zoneID').closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                $('#zoneID').css('border','1px solid #ced4da');

                if(productCount == 0){
                    toastr.error('Product Should Not Be Empty');
                    return;
                }

                var data = {};
                data["invoiceID"] = invoiceID.val();
                data["storeID"] = storeID.val();
                data["customerName"] = customerName.val();
                data["customerPhone"] = customerPhone.val();
                data["customerAddress"] = customerAddress.val();
                data["total"] = total;
                data["deliveryCharge"] = deliveryCharge;
                data["discountCharge"] = discountCharge;
                data["paymentTypeID"] = paymentTypeID;
                data["paymentID"] = paymentID;
                data["paymentAmount"] = paymentAmount;
                data["paymentAgentNumber"] = paymentAgentNumber;
                data["orderDate"] = orderDate.val();
                data["courierID"] = +courierID.val();
                data["cityID"] = cityID;
                data["zoneID"] = zoneID;
                data["userID"] = $('#user_id').val();
                data["products"] = product;
                data["memo"] = memo;
                $.ajax({
                    type: "PUT",
                    url: "{{url('admin/order')}}/" + id,
                    data: {
                        'data': data,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] === "success") {
                            toastr.success(data["message"]);
                            $('.modal').modal('toggle');
                        } else {
                            toastr.error(data["message"])
                        }
                        table.ajax.reload();

                    }
                });


            });

            $(document).on("click", ".btn-delete", function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                Swal.fire({
                    title:"Are you sure?",
                    text:"You won't be able to revert this!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#3085d6"
                    ,cancelButtonColor:"#d33"
                    ,confirmButtonText:"Yes, delete it!"
                }).then(function(t){
                    if(t.value){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            type: "DELETE",
                            url: "{{url('admin/order/')}}/" + id,
                            data: {
                                '_token': token
                            },
                            contentType: "application/json",
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data['status'] === 'success') {
                                    toastr.success(data["message"]);
                                    table.ajax.reload();
                                } else {
                                    if (data['status'] === 'failed') {
                                        toastr.error(data["message"]);
                                    } else {
                                        toastr.error('Something wrong ! Please try again.');
                                    }
                                }
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.btn-pathao', function (e) {
                e.preventDefault();

                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                var user_id = $(this).attr('data-id');

                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/pathao')}}",
                    contentType: "application/json",
                    data: {
                        action: "pathao",
                        ids: ids,
                        user_id: user_id
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] == "success") {
                            // Swal.fire(data["message"]);
                            // table.ajax.reload();

                            ivp(ids);
                        } else {
                            if (data["status"] == "failed") {
                                Swal.fire(data["message"]);
                            } else {
                                Swal.fire("Something wrong ! Please try again.");
                            }
                        }
                    },
                    error: function (request, error) {
                        toastr.error('Can not book in Pathao');
                    }
                });

            });

            function ivp(ids) {
                if (ids.length < 1) {
                    swal("Oops...!", "Select at last one", "error");
                }

                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/storeInvoice')}}",
                    contentType: "application/json",
                    data: {
                        ids: ids
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data['status'] === 'success') {
                            window.open(data['link'], "_blank");
                            Swal.fire({
                                title: "Pathao booked "+ids.length+" orders.",
                                text: "All invoiced Printed?",
                                type: "warning",
                                showCancelButton: !0,
                                confirmButtonColor: "#3085d6"
                                , cancelButtonColor: "#d33"
                                , confirmButtonText: "Yes, Invoiced Printed!"
                            }).then((t) => {
                                console.log(t.value);
                                $.ajax({
                                    type: "get",
                                    url: "{{url('admin/order/changeStatusByCheckbox')}}",
                                    data: {
                                        'status': t.value ? 'Invoiced' : 'Pending Invoiced',
                                        'ids': ids,
                                        '_token': token
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        if (data['status'] === 'success') {
                                            toastr.success(data["message"]);
                                        } else {
                                            if (data['status'] === 'failed') {
                                                toastr.error(data["message"]);
                                            } else {
                                                toastr.error('Something wrong ! Please try again.');
                                            }
                                        }
                                        
                                        table.ajax.reload();
                                        // location.reload();
                                    },
                                    complete: function () {
                                        $(document).find('.dt-checkboxes-select-all').click();
                                    }
                                });
                            });

                        } else {
                            if (data['status'] === 'failed') {
                                toastr.error(data["message"]);
                            } else {
                                toastr.error('Something wrong ! Please try again.');
                            }
                            
                            // table.ajax.reload();
                            location.reload();
                        }

                        $(document).find('.dt-checkboxes-select-all').click();
                    }

                });
            }

            $(document).on('click','.btn-print',function (e) {
                e.preventDefault();
                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                if (ids.length > 0) {
                    jQuery.ajax({
                        type: "get",
                        url: "{{url('admin/order/storeInvoice')}}",
                        contentType: "application/json",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data['status'] === 'success') {
                                window.open(data['link'], "_blank");
                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "All invoiced Printed !",
                                    type: "warning",
                                    showCancelButton: !0,
                                    confirmButtonColor: "#3085d6"
                                    , cancelButtonColor: "#d33"
                                    , confirmButtonText: "Yes, Invoiced Printed!"
                                }).then((t) => {
                                    console.log(t.value);
                                    if (t.value) {
                                        $.ajax({
                                            type: "get",
                                            url: "{{url('admin/order/changeStatusByCheckbox')}}",
                                            data: {
                                                'status': 'Invoiced',
                                                'ids': ids,
                                                '_token': token
                                            },
                                            success: function (response) {
                                                var data = JSON.parse(response);
                                                if (data['status'] === 'success') {
                                                    toastr.success(data["message"]);
                                                    table.ajax.reload();
                                                } else {
                                                    if (data['status'] === 'failed') {
                                                        toastr.error(data["message"]);
                                                    } else {
                                                        toastr.error('Something wrong ! Please try again.');
                                                    }
                                                }
                                            },
                                            complete: function () {
                                                $(document).find('.dt-checkboxes-select-all').click();
                                            }
                                        });
                                    } else {
                                        Swal("Invoice Stay Pending !");
                                    }
                                });

                            } else {
                                if (data['status'] === 'failed') {
                                    toastr.error(data["message"]);
                                } else {
                                    toastr.error('Something wrong ! Please try again.');
                                }
                            }


                        }

                    });
                }else{
                    swal("Oops...!", "Select at last one", "error");
                }


            });




        });
    </script>
@endpush
