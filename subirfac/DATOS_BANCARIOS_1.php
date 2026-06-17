<div id="content">     
			<hr/>
		<strong>	  <p class="mb-0 text-uppercase" ><img src="includes/contraer31.png" id="mostrar14" style="cursor:pointer;"/>
<img src="includes/contraer41.png" id="ocultar14" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;DATOS BANCARIOS DEL PROVEEDOR</p></strong></div>
<div id="mensajeDATOSBANCARIOS12">
<div class="progress" style="width: 25%;">
									<div class="progress-bar" role="progressbar" style="width: <?php echo $datosDATOSBANCARIOS1 ; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $datosDATOSBANCARIOS1 ; ?>%</div></div></div>
							
								
	  
	                  <div id="target14" style="display:block;" class="content2">
                  
                   <div class="card-body">
                  
					     <table class="table mb-0 table-striped">

                <tr>
            
                <th style="text-align:center" scope="col">DATOS BANCARIOS: </th>
				 <strong><mark><a style="font-size:17px;">LES INFORMAMOS QUE PODRÁN SUBIR 2 O MAS CUENTAS BANCARIAS. (FAVOR DE MARCAR LA CUENTA EN LA CUAL QUIEREN QUE SE LES DEPOSITE, LA MARCA DEBERA SER EN LA COLUMNA QUE DICE "CUENTA PARA DEPOSITO" GRACIAS)</a></mark> </strong>
				 <br></br>
                 </tr></table>  <?php if($conexion->variablespermisos('','DATOS_BANCARIOS_1SF','guardar')=='si'){ ?>
	                     <form class="row g-3 needs-validation was-validated" novalidate="" id="DATOSBANCARIOS1form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	
                     
                          <div class="col-md-4"style="background:#fef5e7">
                          <strong><label for="validationCustom02" class="form-label">TIPO DE MONEDA:</label></strong>
                          <select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="P_TIPO_DE_MONEDA_1"> >
                       
                         <option style="background: #c9e8e8" value="MXN" <?php if($P_TIPO_DE_MONEDA_1=='MXN'){echo "selected";} ?>>MXN (Peso mexicano)</option>
                         <option style="background: #a3e4d7" value="USD" <?php if($P_TIPO_DE_MONEDA_1=='USD'){echo "selected";} ?>>USD (Dolar)</option>
                         <option style="background: #e8f6f3" value="EUR" <?php if($P_TIPO_DE_MONEDA_1=='EUR'){echo "selected";} ?>>EUR (Euro)</option>
                         <option style="background: #fdf2e9" value="GBP" <?php if($P_TIPO_DE_MONEDA_1=='GBP'){echo "selected";} ?>>GBP (Libra esterlina)</option>
                         <option style="background: #eaeded" value="CHF" <?php if($P_TIPO_DE_MONEDA_1=='CHF'){echo "selected";} ?>>CHF (Franco suizo)</option>
                         <option style="background: #fdebd0" value="CNY" <?php if($P_TIPO_DE_MONEDA_1=='CNY'){echo "selected";} ?>>CNY (Yuan)</option>
                         <option style="background: #ebdef0" value="JPY" <?php if($P_TIPO_DE_MONEDA_1=='JPY'){echo "selected";} ?>>JPY (Yen japonés)</option>
                         <option style="background: #d6eaf8" value="HKD" <?php if($P_TIPO_DE_MONEDA_1=='HKD'){echo "selected";} ?>>HKD (Dólar hongkonés)</option>
                         <option style="background: #fef5e7" value="CAD" <?php if($P_TIPO_DE_MONEDA_1=='CAD'){echo "selected";} ?>>CAD (Dólar canadiense)</option>
                         <option style="background: #ebedef" value="AUD" <?php if($P_TIPO_DE_MONEDA_1=='AUD'){echo "selected";} ?>>AUD (Dólar australiano)</option>
                         <option style="background: #fbeee6" value="BRL" <?php if($P_TIPO_DE_MONEDA_1=='BRL'){echo "selected";} ?>>BRL (Real brasileño)</option>
                         <option style="background: #e8f6f3" value="RUB" <?php if($P_TIPO_DE_MONEDA_1=='RUB'){echo "selected";} ?>>RUB  (Rublo ruso)</option>

                         </select> 
                          <div class="valid-feedback">Bien!</div>
                          </div>
                         
                        
                     
						
                        <div class="col-md-4"style="background:#d4f6c8">
                          <strong><label for="validationCustom01" class="form-label">NOMBRE DE LA INSTITUCIÓN FINANCIERA / BANCO:</label></strong>
                          <input type="text" class="form-control" id="validationCustom01" value="<?php echo $P_INSTITUCION_FINANCIERA_1; ?>" required="" name="P_INSTITUCION_FINANCIERA_1">
                          <div class="valid-feedback">Bien!</div>
                        </div>
						
                        
                        
                        <div class="col-md-4"style="background:#fbeee6">
                          <strong><label for="validationCustom01" class="form-label">NÚMERO DE CUENTA:</label></strong>
                       
                          <input type="text" class="form-control formato-numero" id="validationCustom01" value="<?php echo $P_NUMERO_DE_CUENTA_DB_1; ?>" maxlength="29" required="" name="P_NUMERO_DE_CUENTA_DB_1" >
                          <div class="valid-feedback">Bien!</div>
                        </div>
						
						
						
                        <div class="col-md-4"style="background:#fef5e7">
                          <strong><label for="validationCustom01" class="form-label">NÚMERO DE CUENTA CLABE (18 DIGITOS):</label></strong>
                          <input type="text"  maxlength="26" class="form-control formato-numero"  id="validationCustom01" value="<?php echo $P_NUMERO_CLABE_1; ?>" required="" name="P_NUMERO_CLABE_1"  >
                          <div class="valid-feedback">Bien!</div>
                      
                        </div>
                        <div class="col-md-4"style="background:#d4f6c8">
                          <strong><label for="validationCustom01" class="form-label">NÚMERO DE TARJETA DE CREDITO:</label></strong>
                          <input type="text" class="form-control" id="validationCustom01" value="<?php echo $P_NUMERO_DE_SUCURSAL_1; ?>" required="" name="P_NUMERO_DE_SUCURSAL_1">
                          <div class="valid-feedback">Bien!</div>
                        </div>
                        <div class="col-md-4"style="background:#fbeee6">
                          <strong><label for="validationCustom01" class="form-label">NÚMERO DE IBAN:</label></strong>
                          <input type="text" class="form-control" id="validationCustom01" value="<?php echo $P_NUMERO_IBAN_1; ?>" required="" name="P_NUMERO_IBAN_1">
                          <div class="valid-feedback">Bien!</div>
                        </div>
                        
                        <div class="col-md-4"style="background:#fef5e7">
                          <strong><label for="validationCustom01" class="form-label">NÚMERO / CUENTA SWIFT:</label></strong>
                          <input type="text" class="form-control" id="validationCustom01" value="<?php echo $P_NUMERO_CUENTA_SWIFT_1; ?>" required="" name="P_NUMERO_CUENTA_SWIFT_1">
                        </div>

                        <div class="col-md-4"style="background:#d4f6c8">
                          <strong><label for="validationCustom01" class="form-label">FOTO DEL ESTADO DE CUENTA:</label></strong>
                          <input type="file" class="form-control" id="validationCustom01" value="<?php echo $FOTO_ESTADO_PROVEE; ?>" required="" name="FOTO_ESTADO_PROVEE">
                        </div>
								   <div class="col-md-4"style="background:#fbeee6">

                        <strong>   <label for="validationCustom01" class="form-label">OBSERVACIONES:</label></strong>
                          <input type="text" class="form-control" id="validationCustom01" value="<?php echo $OBSERVACIONES_D; ?>" required="" name="OBSERVACIONES_D">
                          <div class="valid-feedback">Bien!</div>
                        
                        </div>

                        <div><tr>
                        <th style="text-align:center;background:#faebee;" scope="col">FECHA DE ÚLTIMA CARGA</th>   
           <td  style="background:#faebee">
           <strong>
           <?php echo date('Y-m-d'); ?>
           </strong>
           <input type="hidden" style="width:200px;"  class="form-control" id="validationCustom03"   value="<?php echo date('Y-m-d'); ?>" name="ULTIMA_CARGA_DATOBANCA">
           
           </td>
     </tr>
    
     <table>
      <tr>
						
                 <input type="hidden" value="validaDATOSBANCARIOS1" name="validaDATOSBANCARIOS1"/>


	               <th>


<button class="btn btn-sm btn-outline-success px-5"  type="button" id="enviarDATOSBANCARIOS1">GUARDAR</button><div style="
    color: #f5f5f5;
    text-shadow: 1px 1px 1px #919191,
        1px 2px 1px #919191,
        1px 3px 1px #919191,
        1px 4px 1px #919191,
        1px 5px 1px #919191,
        1px 6px 1px #919191,
        1px 7px 1px #919191,
        1px 8px 1px #919191,
        1px 9px 1px #919191,
        1px 10px 1px #919191,
    1px 18px 6px rgba(16,16,16,0.4),
    1px 22px 10px rgba(16,16,16,0.2),
    1px 25px 35px rgba(16,16,16,0.2),
    1px 30px 60px rgba(16,16,16,0.4);" id="mensajeDATOSBANCARIOS1">                 
<?php } ?>
</th>  
              </tr></table>
       

               </form>
               <?php if($conexion->variablespermisos('','DATOS_BANCARIOS_1SF','email')=='si'){ ?>
				  <form name="form_emai_DATOSBpro" id="form_emai_DATOSBpro">
                  <table><tr>              
                <td style="width:500px"><textarea placeholder="ESCRIBE AQUÍ TUS CORREOS SEPARADOS POR PUNTO Y COMA EJEMPLO: NOMBRE@CORREO.ES;NOMBRE@CORREO.ES"  name="DAbancaPRO_ENVIAR_IMAIL" id="DAbancaPRO_ENVIAR_IMAIL" class="form-control" aria-label="With textarea"><?php echo $DAbancaPRO_ENVIAR_IMAIL; ?></textarea> </td>
                  <td> <button class="btn btn-sm btn-outline-success px-5"  type="button" id="enviar_email_bancarios">ENVIAR POR EMAIL</button></td>   
                 </tr></table><?php } ?>
                 

       



                          							
									
									
									
<?php                                                                   
$querycontras = $SUBEFACTURA->Listado_datos_bancariosPRO();
?>

<br/>
<div class='table-responsive'>
<div align='right'>
</div>
<br />
<div id='employee_table'>
<tbody= 'font-style:italic;'>
<table class="table table-striped table-bordered" style="width:100%"  id='resetBancario1p' name='resetBancario1p'>
<tr style="text-align:center">

<th width="15%"style="background:#c9e8e8">ENVIAR POR EMAIL</th>
<th width="15%"style="background:#c9e8e8">CUENTA PARA DEPOSITO</th>
<th width="20%"style="background:#c9e8e8">TIPO DE MONEDA</th>
<th width="20%"style="background:#c9e8e8">INSTITUCIÓN FINANCIERA</th>
<th width="20%"style="background:#c9e8e8">NÚMERO DE CUENTA</th>
<th width="20%"style="background:#c9e8e8"> CUENTA CLABE</th>
<th width="20%"style="background:#c9e8e8">NÚMERO DE SUCURSAL</th>
<th width="20%"style="background:#c9e8e8">NÚMERO IBAN</th>
<th width="20%"style="background:#c9e8e8">NÚMERO DE CUENTA SWIFT</th>
<th width="20%"style="background:#c9e8e8">FOTO ESTADO DE CUENTA</th>
<th width="20%"style="background:#c9e8e8">OBSERVACIONES</th>
<th width="20%"style="background:#c9e8e8">FECHA ÚLTIMA CARGA</th>
</tr>

<?php
while($row = mysqli_fetch_array($querycontras))
{
			if($row["FOTO_ESTADO_PROVEE"]!=""){
$urlFOTO_ESTADO_PROVEE= "<a target='_blank'
href='includes/archivos/".$row["FOTO_ESTADO_PROVEE"]."'>Visualizar!</a>";
}else{
$urlFOTO_ESTADO_PROVEE="";
}
?>
<tr style='background:#f5f9fc;text-align:center'>
<td style="text-align:center" >
<input type="checkbox" style="width:20%" class="form-check-input" name="datosbancPRO[]" id="datosbancPRO" value="<?php echo $row["id"]; ?>"/> </td>

<td style="text-align:center" >
<!--<input type="checkbox" style="width:15%" class="form-check-input" name="cuentaD[]" id="cuentaD" value="<?php echo $row["id"]; ?>"/> -->


<input type="checkbox" style="width:22%;" class="form-check-input only-one" 

id="cuentaD<?php echo $row["id"]; ?>" 
name="cuentaD<?php echo $row["id"]; ?>" value="<?php echo $row["id"]; ?>"  
onclick="cuentaDver(<?php echo $row["id"]; ?>)"  	

<?php if($row["checkbox"]=='si'){
	echo "checked";
} ?>/>





</td>

<td ><?php echo $row["P_TIPO_DE_MONEDA_1"]; ?></td>
<td ><?php echo $row["P_INSTITUCION_FINANCIERA_1"]; ?></td>
<td ><?php echo $row["P_NUMERO_DE_CUENTA_DB_1"]; ?></td>
<td ><?php echo $row["P_NUMERO_CLABE_1"]; ?></td>
<td ><?php echo $row["P_NUMERO_DE_SUCURSAL_1"]; ?></td>
<td ><?php echo $row["P_NUMERO_IBAN_1"]; ?></td>
<td ><?php echo $row["P_NUMERO_CUENTA_SWIFT_1"]; ?></td>
<td ><?php echo $urlFOTO_ESTADO_PROVEE; ?></td>  
<td ><?php echo $row["OBSERVACIONES_D"]; ?></td>                        
<td ><?php echo $row["ULTIMA_CARGA_DATOBANCA"]; ?></td>
<td><?php if($conexion->variablespermisos('','DATOS_BANCARIOS_1SF','modificar')=='si'){ ?>

<input type="button" name="view" value="MODIFICAR" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data_bancario1p_modifica" /><?php } ?></td>
<td>
<?php if($conexion->variablespermisos('','DATOS_BANCARIOS_1SF','borrar')=='si'){ ?>


<input type="button" name="view2" value="BORRAR" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_databancario1borrar" /><?php } ?></td>
</tr>
<?php
}
?>
</table>
</tbody>
</form>
</div>
</div>
</div>
</div>
</div>
						                  
                          					
									
									
									
									
									
									
									
									
									
									
						