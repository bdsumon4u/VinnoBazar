@extends('layouts.app')
@push('css')
    <link href="{{asset('libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputCity" class="col-form-label">Date</label>
                                    <input type="text" class="form-control datepicker" id="date" value="<?php echo date('Y-m-d')?>" placeholder="Select Date">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState" class="col-form-label">Select Courier</label>
                                    <select id="courierID" class="form-control"></select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState" class="col-form-label">Select User</label>
                                    <select id="userID" class="form-control"></select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState" class="col-form-label">Select Status</label>
                                    <select id="orderStatus" class="form-control">
                                        <option value="All">All</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Pending Invoiced">Pending Invoiced</option>
                                        <option value="Invoiced">Invoiced</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Return">Return</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputZip" class="col-form-label" style="opacity: 0">Print</label>
                                    <button class="btn btn-info btn-print"><i class="fas fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="reportTable" class="table table-centered table-nowrap mb-0" style="width: 100%">
                            <thead class="thead-light" >
                            <tr>
                                <th>Date</th>
                                <th>Invoice ID</th>
                                <th>Name</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th>Courier</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('libs/select2/select2.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script !src="">

        $(document).ready(function () {
            var token = $("input[name='_token']").val();
            $(".datepicker").flatpickr();

            var table = $("#reportTable").DataTable({
                type: "get",
                ajax: {
                    url: "{{url('manager/report/getOrdersOnDateCourierUser')}}",
                    data: {
                        date: function() { return $('#date').val() },
                        courierID: function() { return $('#courierID').val() },
                        userID: function() { return $('#userID').val() },
                        orderStatus: function() { return $('#orderStatus').val() }
                    }
                },
                ordering: false,
                pageLength: 10,
                paging: true,
                columns: [
                    {data: "invoiceID"},
                    {data: "deliveryDate"},
                    {
                        data: null,
                        width: "15%",
                        render: function (data) {
                            return '<i class="fas fa-user mr-2 text-grey-dark"></i>'+data.customerName +'<br> <i class="fas fa-phone  mr-2 text-grey-dark"></i>'+data.customerPhone+'<br><i class="fas fa-map-marker mr-2 text-grey-dark"></i>' + data.customerAddress;
                        }
                    },
                    {
                        data: "products",
                        width: "15%"
                    },
                    {data: "subTotal"},
                    {data: "courierName"},
                    {data: "name"},
                    {data: "status"}
                ],
                lengthChange: true,
                bFilter:true,
                search:true,
                info:true,
                dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
                    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
                    '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                buttons: [
                    {
                    extend: 'print',
                    text: 'Print',
                    title: function(){
                        var printTitle = 'Invoice';
                        return printTitle;
                    },
                    customize: function (win) {
                        $(win.document.body).find('h1').css('text-align','center');
                        $(win.document.body).find('h1').after('<p style="text-align: center">'+$('#date').val()+'</p>');

                    }
                }],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'>",
                        next: "<i class='fas fa-chevron-right'>"
                    }
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-sm");
                    $('.dt-buttons').hide();
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
            $("#courierID").select2({
                placeholder: "Select a Courier",
                allowClear:true,
                ajax: {
                    url:'{{url('manager/city/courier')}}',
                    processResults: function (data) {
                        var data = $.parseJSON(data);
                        return {
                            results: data
                        };
                    }
                }
            }).trigger("change").on("select2:select", function (e) {
                table.ajax.reload();
            });
            $("#userID").select2({
                placeholder: "Select a user",
                allowClear:true,
                ajax: {
                    url:'{{url('manager/report/users')}}',
                    processResults: function (data) {
                        var data = $.parseJSON(data);
                        return {
                            results: data
                        };
                    }
                }
            }).trigger("change").on("select2:select", function (e) {
                table.ajax.reload();
            });

            $(document).on('click', '.btn-print', function(){
                $(".buttons-print")[0].click();
            });
            $(document).on('change', '#date', function(){
                table.ajax.reload();
            });
            $(document).on('change', '#orderStatus', function(){
                table.ajax.reload();
            });

        });
    </script>

@endpush
