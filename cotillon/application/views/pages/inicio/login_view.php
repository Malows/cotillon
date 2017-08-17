<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	if ( isset( $error ) ) {
		echo $error;
	}
?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
<?php
	echo form_open('/');

	echo '<div class="form-group">';
		echo form_label('DNI');
		echo form_input('usuario', '', array('class' => 'form-control'));
	echo '</div>';

	echo '<div class="form-group">';
		echo form_label( "Contraseña" );
		echo '<div class="input-group">';
			echo form_password('contrasenia','',array('class' => 'form-control', 'id' => 'password-form'));
			echo '<div id="show-me" class="input-group-addon"><i class="fa fa-lg fa-eye"></i></div>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group">';
	echo form_submit('logear', 'Ingresar al sistema',array('class' => 'btn btn-primary'));
	echo '</div>';

	echo form_close();
?>
</div>
<?php $replacement = '/cotillon/index.php'; ?>
<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/password-show.js'));?>"></script>
