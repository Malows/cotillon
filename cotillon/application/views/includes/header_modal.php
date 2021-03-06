<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<?php $replacement = '/cotillon/index.php'; ?>
		<link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('/assets/css/bootstrap.min.css'));?>">
		<link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('/assets/css/modal.css'));?>">
		<link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('/assets/css/font-awesome.min.css'));?>">
		<link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('/assets/css/style.css'));?>">
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
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Información <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><?php echo anchor( base_url("localidades/"), "Localidades"); ?></li>
									<li><?php echo anchor( base_url("clientes/"), "Clientes"); ?></li>
									<li><?php echo anchor( base_url("proveedores/"), "Proveedores"); ?></li>
									<li><?php echo anchor( base_url("categorias/"), "Categorias"); ?></li>
									<li><?php echo anchor( base_url("productos/"), "Productos"); ?></li>
								</ul>
							</li>
							<li><?php echo anchor( base_url("productos/"), "Productos"); ?></li>
							<li><?php echo anchor( base_url("ventas/"), "Ventas"); ?></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contable <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><?php echo anchor( base_url("arqueos/"), "Arqueos"); ?></li>
									<li><?php echo anchor( base_url("registros/"), "Registros"); ?></li>
									<li><a href="#">Movimientos</a></li>
									<li><?php echo anchor( base_url("pedidos/"), "Pedidos"); ?></li>
									<li><?php echo anchor( base_url("ventas/"), "Ventas"); ?></li>
								</ul>
							</li>
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
