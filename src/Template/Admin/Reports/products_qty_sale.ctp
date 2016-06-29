
    <h3 class="text-center bg-primary" style="padding: 10px 10px; font-weight: bold;" > REPORT </h3>

    <div class="row">
        <?php echo $this->Form->create(); ?>
            <div class="col-md-3 col-md-offset-1">
                <?php echo $this->Form->input('start_date', ['class' => 'form-control', 'id' => 'datepicker1']);?>
            </div>
            <div class="col-md-3">
                 <?php echo $this->Form->input('end_date', ['class' => 'form-control', 'id' => 'datepicker2']); ?>
            </div>
            <div class="col-md-3">
               <?php echo $this->Form->input('filter', ['class' => 'form-control', 'options' => $dropdown_filter]); ?>
            </div>
            <div class="col-md-1 col-md-offset-right-1">  
               <?php echo $this->Form->button('Report', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px;']); ?>
            </div>
        <?php echo $this->Form->end; ?>
    </div>

    <div class="row" style="margin-top: 50px;">
        <div class="col-md-3 col-md-offset-1">
            <?php if(isset($filter)) { ?>
                <h4><?php echo isset($title_table1) ? $title_table1 : ''; ?></h4>
                <table class = "table table-responsive table-bordered">
                    <tr class = "bg-primary">   
                        <th class="text-center"><?php echo isset($title_table_main) ? $title_table_main : ''; ?></th>
                        <th class="text-center"><?php echo isset($title_table) ? $title_table : ''; ?></th>
                    </tr>

                    <?php
                        if($filter == 0 && count($result_table1) > 0) {
                            foreach($result_table1 as $row) { 
                    ?> 
                        <tr>
                            <td style="background: #f5f5f5; text-align: center;" width="200px"><?php echo isset($row->product->name_product) ? $row->product->name_product : ''; ?></td>
                            <td class="text-center"><?php echo isset($row->total_qty_order) ? $row->total_qty_order : ''; ?></td>
                        </tr>
                    <?php 
                            }
                        } else if($filter == 1 && count($result_table1) > 0) { 
                            foreach($result_table1 as $row) { 
                    ?>
                        <tr>
                            <td style="background: #f5f5f5; text-align: center;" width="150px">
                                <?php echo isset($row->created) ? $row->created->i18nFormat('yyyy-MM-dd') : ''; ?>
                            </td>
                            <td class="text-center">
                                <?php echo isset($row->total_money) ? '<b>' . number_format($row->total_money, 3) . '</b>' : ''; ?>
                            </td>
                        </tr>
                    <?php 
                            } 
                        } else { 
                    ?>
                        <tr>
                            <td colspan="2" class="text-center">NOT FOUND DATA</td>
                        </tr>
                    <?php } ?>
                </table>

                <h4><?php echo isset($title_table2) ? $title_table2 : ''; ?></h4>
                <table class = "table table-responsive table-bordered">
                    <tr class = "bg-primary">   
                        <th class="text-center"><?php echo isset($title_table_main) ? $title_table_main : ''; ?></th>
                        <th class="text-center"><?php echo isset($title_table) ? $title_table : ''; ?></th>
                    </tr>
                    <?php
                        if($filter == 0 && count($result_table2) > 0) {
                            foreach($result_table2 as $row) { 
                    ?> 
                        <tr>
                            <td style="background: #f5f5f5; text-align: center;" width="200px"><?php echo isset($row->product->name_product) ? $row->product->name_product : ''; ?></td>
                            <td class="text-center"><?php echo isset($row->total_qty_order) ? $row->total_qty_order : ''; ?></td>
                        </tr>
                    <?php 
                            }
                        } else if($filter == 1 && count($result_table2) > 0) { 
                            foreach($result_table2 as $row) { 
                    ?>
                        <tr>
                            <td style="background: #f5f5f5; text-align: center;" width="150px">
                                <?php echo isset($row->created) ? $row->created->i18nFormat('yyyy-MM-dd') : ''; ?>
                            </td>
                            <td class="text-center">
                                <?php echo isset($row->total_money) ? '<b>' . number_format($row->total_money, 3) . '</b>' : ''; ?>
                            </td>
                        </tr>
                    <?php 
                            } 
                        } else { 
                    ?>
                        <tr>
                            <td colspan="2" class="text-center">NOT FOUND DATA</td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>

        <?php if(isset($labels)) { ?>
            <div class="col-md-7 col-md-offset-right-1">
                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                              <?php echo isset($report) ? $report : ''; ?>
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
        <?php } ?>
    </div>

<script src="<?php echo $this->request->webroot . 'webroot/js/chart.js/dist/Chart.min.js'; ?>"></script>
<script>
    var ctx = document.getElementById("myChart");
    var data = {
        labels: <?php echo $labels; ?>,
        datasets: [
            {
                label: "<?php echo $unit_chart1; ?>",
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
                data: <?php echo $data_chart; ?>,
            }, {
                label: "<?php echo $unit_chart2; ?>",
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
                data: <?php echo $data_chart2; ?>,
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
</script>
