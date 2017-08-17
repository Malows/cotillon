<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		</div>
		<?php $replacement = '/cotillon/index.php'; ?>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/jquery-3.1.1.min.js'));?>"></script>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/datatables.min.js'));?>"></script>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/bootstrap.min.js'));?>"></script>
		<script>
		  $(document).ready(function() {
		    $('table').DataTable();
		  } );
		</script>
	</body>
</html>
