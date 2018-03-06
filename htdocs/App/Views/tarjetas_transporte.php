<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="registros">
	<div class="contenedorEntradas">
		<button id="nuevaTarjeta" class="btn btn-default">Nueva registro</button>
		<!--button id="enviar" class="pull-right btn btn-default" title="Envia los telefonos seleccionados al correo comercial@gestoriaportol.com">
			<i style="margin-right: 4px" class="glyphicon glyphicon-send"></i>
			<span>Enviar</span>
		</button>
		<button id="sms" class="pull-right btn btn-default" title="Desde el movil, se abre un nuevo mensaje con todos los contactos seleccionados">SMS</button>
		<button id="confirmar" class="pull-right btn btn-default" title="Tras enviar los sms atraves del movil, se confirma que todos los sms han sido enviados correctamente">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Confirmar</span>
		</button-->
	</div>
	
	
	<table id="registro">
		<thead>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Cliente</th>
				<th>Telefono</th>
				<th>Valido Hasta</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Cliente</th>
				<th>Telefono</th>
				<th>Valido Hasta</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</tfoot>
		<tbody>
			<?php 
				$month = new \DateInterval( "P1M" );
				$month->invert = 1; //Make it negative.
				$hoy=date('Y-m');
				$today=new \DateTime(date('Y-m-d'));
			?>
			<?php foreach ($registros as  $registro): ?>
				<?php
					$proximo=new \DateTime($registro['fecha_vencimiento']);
					$proximo->add($month);
				?>
			<tr class="<?= empty($registro['fecha_vencimiento'])?"naranja":($hoy==$proximo->format('Y-m')?"verde":($proximo<$today?"rojo":"")) ?>" >
				<td><?= $registro['id'] ?></td>
				<td><?= strtoupper($registro['matricula']) ?></td>
				<td><?= $registro['cliente'] ?></td>
				<td><?= $registro['telefono'] ?></td>
				<!--td><?= empty($registro['fecha_renovacion'])?"Pendiente":date("d-m-Y", strtotime($registro['fecha_renovacion'])) ?></td-->
				<td><?= empty($registro['fecha_vencimiento'])?"Pendiente":date("d-m-Y", strtotime($registro['fecha_vencimiento'])) ?></td>
				<td><?= $registro['usuario'] ?></td>
				<td class="opciones" style="display:flex;">
					<button class="edit btn btn-success">Editar</button>
					<button class="archivos btn btn-info">Ver archivos</button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorCliente"></div>
	<div id="galeria"></div>
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
		<!-- Background of PhotoSwipe. 
		It's a separate element, as animating opacity is faster than rgba(). -->
		<div class="pswp__bg"></div>
		<!-- Slides wrapper with overflow:hidden. -->
		<div class="pswp__scroll-wrap">
			<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
			<div class="pswp__container">
				<!-- don't modify these 3 pswp__item elements, data is added later on -->
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>
			<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<!--  Controls are self-explanatory. Order can be changed. -->
					<div class="pswp__counter"></div>
					<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
					<button class="pswp__button pswp__button--share" title="Share"></button>
					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
					<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
					<!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
					<!-- element will get class pswp__preloader--active when preloader is running -->
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
							<div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip"></div> 
				</div>
				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
				</button>
				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
				</button>
				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>
</div>