<div id="whatsapp">
	<div>
		<label for="tlf">Movil</label>
		<input id="tlf" name="phone" pattern="\d{9}" type="text">
	</div>
	<div>
		<label for="mensaje"></label>
		<textarea name="text" id="mensaje" cols="30" rows="10"></textarea>
	</div>
	<div>
		<button id="asd">enviar</button>
	</div>
</div>
<script>
	$('#asd').on('click',function(){

		movil=$('#tlf').val();
		//console.log(form['text'].value);
		texto=$('#mensaje').val();
		//console.log(encodeURI(texto));
		codificado=encodeURI(texto);
		location.href="https://api.whatsapp.com/send?phone=34"+movil+"&text="+codificado;
	})
</script>