<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/bootstrap.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/bulma.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/style.css">
		<title>Cotillon FTW</title>
	</head>
	<body>
		<div class="container-fluid">
			<?php if($this->session->userdata('esta_logeado')):?>
			<nav class="navbar navbar-default navbar-fixed-top" >
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="<?php echo base_url(); ?>" class="navbar-brand">Cotillon</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
						<ul class="nav navbar-nav">
							<li><?php echo anchor( base_url("categorias/"), "Categorias"); ?></li>
							<li><?php echo anchor( base_url("localidades/"), "Localidades"); ?></li>
							<li><?php echo anchor( base_url("clientes/"), "Clientes"); ?></li>
							<li><?php echo anchor( base_url("proveedores/"), "Proveedores"); ?></li>
							<li><?php echo anchor( base_url("productos/"), "Productos"); ?></li>
							<li><?php echo anchor( base_url("ventas/"), "Ventas"); ?></li>
						<?php if($this->session->userdata('es_admin')): ?>
							<li><?php echo anchor( base_url("usuarios/"), "Usuarios"); ?></li>
						<?php endif; ?>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="<?php echo base_url("inicio/salir");?>">Salir</a></li>
						</ul>
					</div>
				</div>
			</nav>
		<?php endif; ?>
			<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12" style="margin-top: 50px">
