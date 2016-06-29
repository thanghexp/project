<h3 class="text-center bg-primary" style="padding: 10px 10px; font-weight: bold;" > DASHBOARD </h3>
    <div class="row">
        <div class="container">
            <div class="col-sm-6 col-md-4 margin-b-30">
                <div class="tile">
                    <div class="tile-title clearfix">
                        Total orders
                        <span class="pull-right"><i class="fa fa-caret-up"></i><?php echo ($total_order_paid != 0) ? number_format((( $total_order_paid / $total_order ) * 100), 2) . '%' : ''; ?></span>
                    </div><!--.tile-title-->
                    <div class="tile-body clearfix">
                        <i class="icon glyphicon glyphicon-shopping-cart"></i>
                        <h4 class="pull-right"><?php echo isset($total_order_paid) ? $total_order_paid : ''; ?></h4>
                    </div><!--.tile-body-->
                    <div class="tile-footer">
                        <a href="<?php echo $this->request->webroot . 'admin/invoices/listInvoice'; ?>">View Details...</a>
                    </div><!--.tile footer-->
                </div><!-- .tile-->
            </div><!--end .col-->

            <div class="col-sm-6 col-md-4 margin-b-30">
                <div class="tile">
                    <div class="tile-title clearfix">
                        Total Sales
                        <span class="pull-right"><i class="fa fa-caret-up"></i><?php echo isset($total_money) && isset($total_money_paid) ? number_format((($total_money / $total_money_paid) * 100), 2) . '%' : ''; ?></span>
                    </div><!--.tile-title-->
                    <div class="tile-body clearfix">
                        <i class="icon glyphicon glyphicon-credit-card"></i>
                        <h4 class="pull-right"><?php echo isset($total_money) ? number_format($total_money, 3) . 'VND' : 0; ?></h4>
                    </div><!--.tile-body-->
                    <div class="tile-footer">
                        <a href="<?php echo $this->request->webroot . 'admin/orders/listOrder' ?>">View Details...</a>
                    </div><!--.tile footer-->
                </div><!-- .tile-->
            </div><!--end .col-->

            <div class="col-sm-6 col-md-4 margin-b-30">
                <div class="tile">
                    <div class="tile-title clearfix">
                        Customers
                        <span class="pull-right"><i class="fa fa-caret-up"></i>
                        <?php //echo isset($total_customer) && isset($total_customer_status) ? number_format(((total_customer_status / $total_customer) * 100), 2)  : ''; ?></span>
                    </div><!--.tile-title-->
                    <div class="tile-body clearfix">
                        <i class="icon glyphicon glyphicon-user"></i>
                        <h4 class="pull-right"><?php echo isset($total_customer) ? $total_customer : ''; ?></h4>
                    </div><!--.tile-body-->
                    <div class="tile-footer">
                        <a href="<?php echo $this->request->webroot . 'admin/customers/listCustomer' ?>">View Details...</a>
                    </div><!--.tile footer-->
                </div><!-- .tile-->
            </div><!--end .col-->       
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-responsive table-bordered"  id="result">
                
            </table>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="col-md-6">
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                          #Report total money sales monthly
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                            <div class="col-md-9 panel-body">
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div>
                      </div>
                    </div>
              </div>
          </div>
      </div>

      <div class="col-md-6">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          #Report total order monthly
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                            <div class="col-md-9 panel-body">
                                <canvas id="myChart2" width="400" height="400"></canvas>
                            </div>
                      </div>
                    </div>
              </div>
          </div>
      </div>
    </div>

<div class="row">
    <div class="col-md-4" style="margin-left: 45px;">
        <table class="table table-responsive">
             <tr class = "bg-primary">
                <th> Check </th>
                <th>ID</th>
                <th>ID Order</th>
                <th>Name User</th>
                <th></th>
            </tr>
        </table>
    </div>

    <div class="col-md-7">
        <table class = "table table-responsive">
            <tr class = "bg-primary">
                <th>#</th>
                <th>Code</th>
                <th>Name User</th>
                <th>Money</th>
                <th>Status</th>
                <th>Create date</th>
            </tr>

            <?php
                $i = 1;
                if(isset($orderProducts)) {
                    foreach($orderProducts as $row) { 
            ?> 
            <tr>

                <td class="bg-success"><?php echo $i++; ?></td>
                <td>
                    <a href="<?php echo isset($row->order->code_order) ? $this->request->webroot . 'admin/orderProducts/listOrderProduct/' . $row->order->code_order : '#'; ?>">
                        <?php echo isset($row->order->code_order) ? $row->order->code_order : '-'; ?>
                    </a>
                </td>
                <td><?php echo (isset($row->user->first_name) && isset($row->user->last_name)) ? $row->user->last_name . ' ' . $row->user->first_name : '-'; ?></td>
                <td><?php echo isset($row->money) ? '<b>' . number_format($row->money,3) . '</b>' : ''; ?></td>                
                <?php 
                    if($row->status == 0) { 
                        $status = 'Order';
                        $class= "bg-warning";
                    } else if($row->status == 1) {
                        $status = 'Unpaid';
                        $class= "bg-danger";
                    } else {
                        $status = 'Paid';
                        $class= "bg-success";
                    }
                ?>
                <td class="<?php echo $class; ?> text-center" ><?php echo $status; ?></td>
                <td><?php echo (!$row->order->created) ?  '-' : $row->order->created->i18nFormat('yyyy-MM-dd hh:mm'); ?></td>
            </tr>
            <?php }} ?>
        </table>
    </div>
</div>

<script src="<?php echo $this->request->webroot . 'webroot/js/chart.js/dist/Chart.min.js'; ?>"></script>

<script>
    // $('#charts_sale').hide();

    function choseDate() {
        $.ajax({
            'url' :  'http://localhost/manage_coffee_trouser/admin/home/dataToDate',
            'type' : 'post',
            'dataType' : 'text',
            'data' : $('#from_date'),
            success: function(result) {
                return $('#to_date').html(result);
            }
        });
    }

    function reportSales() {
        $.ajax({
            'url' :  'http://localhost/manage_coffee_trouser/admin/home/reportSales',
            'type' : 'post',
            'dataType' : 'text',
            'data' : {
                'from_date' : $('#from_date').val(),
                'to_date'   : $('#to_date').val(),
                'chose_report' : $('#chose_report').val()
            },
            success: function(result) {
                return $('#result').html(result);
            }
        });
    }
</script>

<script>

    var ctx = document.getElementById("myChart");
    var data = {
        labels: <?php echo $labels; ?>,
        datasets: [
            {
                label: "Qty order offline",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: <?php echo $data_column1_total; ?>,
            }, {
                    label: "Qty order online",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "#dfdfdf",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: <?php echo $data_column2_total; ?>,
            }

        ]
    };

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });


    var data = {
        labels: <?php echo $labels; ?>,
        datasets: [
            {
                label: " offline /.ooo VND",
                fill: false,
                lineTension: 0.1,
                backgroundColor:"#dfdfdf",
                borderColor: "#dfdfdf",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: <?php echo $count_order2; ?>,
            },{
                label: " online /.ooo VND",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: <?php echo $count_order; ?>,
            },
        ]
    };


    var cty = document.getElementById("myChart2");
    var myLineChart = new Chart(cty, {
        type: 'line',
        data: data,
    });

</script>
