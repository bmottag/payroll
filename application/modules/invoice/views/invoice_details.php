<script type="text/javascript" src="<?php echo base_url("assets/js/validate/invoice/invoice_service.js"); ?>"></script>

<script>
$(function(){ 		
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				        url: base_url + 'invoice/cargarModalInvoiceService',
                data: {'idInvoice': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});

});
</script>

<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
?>
		<script>
			$(function() {
				toastr.success('<?php echo $retornoExito ?>')
		  	});
		</script>
<?php
	}

	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
?>
		<script>
			$(function() {
				toastr.error('<?php echo $retornoError ?>')
		  	});
		</script>
<?php
	}
?> 

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">

        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> <?php echo $appClient[0]['client_name']; ?> 
                <small class="float-right">Date:  <?php echo $invoiceInfo[0]['invoice_date']; ?></small>
              </h4>
            </div>
          </div>
              <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $appClient[0]['client_name']; ?> </strong><br>
                <?php echo $appClient[0]['client_address']; ?><br>
                Phone: <?php echo $appClient[0]['client_movil']; ?><br>
                Email: <?php echo $appClient[0]['client_email']; ?>
              </address>
            </div>
                <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            Invoice To
              <address>
                <strong><?php echo $invoiceInfo[0]['param_client_contact']; ?></strong><br>
                <?php echo $invoiceInfo[0]['param_client_name']; ?><br>
                <?php echo $invoiceInfo[0]['param_client_address']; ?><br>
                Phone: <?php echo $invoiceInfo[0]['param_client_movil']; ?><br>
                Email: <?php echo $invoiceInfo[0]['param_client_email']; ?>
              </address>
            </div>
            <div class="col-sm-4 invoice-col">
              <b>Invoice #<?php echo $invoiceInfo[0]['invoice_number']; ?></b><br>
              <br>
              <b>TERMS:</b> 4F3S8J
            </div>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">

            <?php                     
              if(!$invoiceDetails){ 
                echo '<div class="col-lg-12">
                    <p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> No data was found.</p>
                  </div>';
              }else{
            ?>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th class='text-center'>Qty</th>
                  <th>Service</th>
                  <th>Description</th>
                  <th class='text-center'>Rate</th>
                  <th class='text-center'>Subtotal</th>
                  <th class='text-center'>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subtotal = 0;
                foreach ($invoiceDetails as $lista):
                  $subtotal = $lista['value'] + $subtotal;
                  echo '<tr>';
                  echo "<td class='text-center'>" . $lista['quantity'] . "</td>";
                  echo "<td>" . $lista['service'] . "</td>";
                  echo "<td>" . $lista['description'] . "</td>";
                  echo "<td class='text-center'>$" . $lista['rate'] . "</td>";
                  echo "<td class='text-center'>$" . $lista['value'] . "</td>";
                  echo "<td class='text-center'>";
                ?>
                  <button type="button" id="<?php echo $lista['id_invoice_service']; ?>" class='btn btn-danger btn-xs' title="Delete">
                      <i class="fa fa-trash"></i>
                  </button>
                <?php
                  echo "</td>";
                  echo "</tr>";
                endforeach;
                ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
        </div>

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $invoiceInfo[0]['id_invoice']; ?>" >
              Add Service <i class="fas fa-edit"></i>
            </button>  
          </div>
          <!-- /.col -->
          <div class="col-6">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>$<?php echo $subtotal; ?></td>
                </tr>
                <tr>
                  <th>GST (5%)</th>
                  <?php $gst = $subtotal * 5 / 100; ?>
                  <td>$<?php echo $gst ?></td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <?php $total = $subtotal + $gst; ?>
                  <td>$<?php echo $total; ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="row no-print">
          <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
          </div>
        </div>
      </div>

			</div>
		</div>
	</div>
</section>

<!--INICIO Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->