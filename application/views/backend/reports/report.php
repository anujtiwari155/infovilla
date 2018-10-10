
        <link rel="stylesheet" href="<?= base_url('assets/graph/style.css') ?>" type="text/css">
        <script src="<?= base_url('assets/graph/amcharts.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/graph/serial.js') ?>" type="text/javascript"></script>

        <script>
            var chartData = [];
            generateChartData();

            var chart = AmCharts.makeChart("chartdiv", {
                type: "serial",
                dataProvider: chartData,
                categoryField: "date",
                categoryAxis: {
                    parseDates: true,
                    gridAlpha: 0.15,
                    minorGridEnabled: true,
                    axisColor: "#DADADA"
                },
                valueAxes: [{
                    axisAlpha: 0.2,
                    id: "v1"
                }],
                graphs: [{
                    title: "red line",
                    id: "g1",
                    valueAxis: "v1",
                    valueField: "visits",
                    bullet: "round",
                    bulletBorderColor: "#FFFFFF",
                    bulletBorderAlpha: 1,
                    lineThickness: 2,
                    lineColor: "#b5030d",
                    negativeLineColor: "#0352b5",
                    balloonText: "[[category]]<br><b><span style='font-size:14px;'>value: [[value]]</span></b>"
                }],
                chartCursor: {
                    fullWidth:true,
                    cursorAlpha:0.1
                },
                chartScrollbar: {
                    scrollbarHeight: 40,
                    color: "#FFFFFF",
                    autoGridCount: true,
                    graph: "g1" 
                },

                mouseWheelZoomEnabled:true
            });

            chart.addListener("dataUpdated", zoomChart);


            // generate some random data, quite different range
            function generateChartData() {
            	var products = new Array();
            	var quantities = new Array();
            	var filter_date = '<?= $selected ?>';
            	<?php foreach ($booked_products as $booked_product) { ?>
            		var php_dt = '<?= $booked_product->created_date ?>';
            		var quantity = '<?php print_r($booked_product->product_booked_bydate($booked_product->created_date)); ?>';
            		var js_dt = new Date(php_dt);
            		quantities.push(quantity);
            		products.push(js_dt);
            	<?php } ?>
            	
                var firstDate = new Date();
                firstDate.setDate(firstDate.getDate() - filter_date);
                for (var i = 0; i <= filter_date; i++) {
                    // we create date objects here. In your data, you can have date strings
                    // and then set format of your dates using chart.dataDateFormat property,
                    // however when possible, use date objects, as this will speed up chart rendering.
                    var newDate = new Date(firstDate);
                    newDate.setDate(newDate.getDate() + i);
                    var value = 0;
                    for (var j = products.length - 1; j >= 0; j--) {
                    	if(products[j].getFullYear() == newDate.getFullYear() && products[j].getMonth() == newDate.getMonth() && products[j].getDate() == newDate.getDate()) {
                    		value = quantities[j];
                    		break;
                    	}
	            	}
                    chartData.push({
                        date: newDate,
                        visits: value
                    });
                }
            }

            // this method is called when chart is first inited as we listen for "dataUpdated" event
            function zoomChart() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
            }

            // changes cursor mode from pan to select
            function setPanSelect() {
                var chartCursor = chart.chartCursor;

                if (document.getElementById("rb1").checked) {
                    chartCursor.pan = false;
                    chartCursor.zoomable = true;

                } else {
                    chartCursor.pan = true;
                }
                chart.validateNow();
            }
        </script>
        
<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
	        
			<!-- <div class="row">
				<div class="col-md-12">
					<a href="<?= base_url() ?>backend/allfunction/product/add" class="pull-right btn btn-sm btn-info">Add Products</a>
				</div>
			</div> -->
			<div class="report">
				<h2 class="text-center"><b>Product Report</b></h2>
				<div class="row">
					<div class="col-md-6 nopl">
						<div class="form-group">
							<p class="col-md-5 nopl nopr report_label"><label>Product Report Summary</label></p>
							<div class="col-md-5 nopl">
								<div class="dropdown">
									<?php switch ($selected) {
										case '7':
											$default = "Last 7 days";
											break;
										case '30':
											$default = "Last 1 Month";
											break;
										case '180':
											$default = "Last 6 Month";
											break;
										default:
											$default = "Over All";
											break;
									} ?>
								  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><?= $default ?>
								  <span class="caret"></span></button>
								  <ul class="dropdown-menu">
								    <li><a href="<?= base_url('report/product') ?>">Over All</a></li>
								    <li><a href="<?= base_url('report/product?list=last_7_days') ?>">Last 7 days</a></li>
								    <li><a href="<?= base_url('report/product?list=last_1_month') ?>">Last 1 Month</a></li>
								    <li><a href="<?= base_url('report/product?list=last_6_months') ?>">Last 6 Months</a></li>
								  </ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
			</div>
			<h3>Graphical report</h3>
			<div id="chartdiv" style="width: 100%; height: 400px;"></div>
			<div class="report">
				<div class="row">
					<h3>Digital Report</h3>
					<div class="col-md-12">
						<div class="col-md-3 box">
							<p>Product Added</p>
							<h2><?= $product_added ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Product booked</p>
							<h2><?= $product_booked ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Product delivered</p>
							<h2><?= $product_delivered ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Product Left</p>
							<h2><?php print_r($product_added - $product_booked); ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Product Added</p>
							<h2>38</h2>
						</div>
					</div>
				</div>
			</div>
	 	</div>
	</div>
</div>