<TABLE width="100%" height="10" border="0" cellpadding="2" cellspacing="0"  class="BackTitleFirst">
<TR> 
	<TD width="33%"><FONT color="#FFFFFF"><B>&nbsp;<? echo strtoupper($tabla) ?></B><? 
if(isset($id) && $id!=""){ 
 $sql = "SELECT * FROM " . $tabla . " WHERE id=" . $id;
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$row = mysql_fetch_array($result);
		echo ' "'.$row[1].'" ';
	}
} ?></FONT></TD>
  </TR>
        
  
</TABLE>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
              
  <TR> 
                
    <TD nowrap class="LiteViolet">
			 
			 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                    
	   <TR> 
                      
		<TD width="20" nowrap class="BackFrameSolapas"></TD>
		<TD width="100%" class="BackFrameSolapas">
 			
		  <?
			################### SOLAPAS #########
			$result_rel = mysql_query("SELECT * FROM usuarios_rel_tab t 
			LEFT JOIN usuarios_lista_tablas l ON (t.id_tablas = l.id) 
			WHERE tabla = '$tabla'");
			if(mysql_num_rows($result_rel)!=0){
			?>
			      <TABLE border="0" cellpadding="0" cellspacing="0">
                     
		    <TR>
			 <?
				while($row_rel=mysql_fetch_array($result_rel)){
					$img_estado = "off";
					if(!isset($original)){ ##
						$original = true;
						
						if($include == "abm") { $img_estado = "on"; }
				$tiene_solapas = "si";
			?>
		<INPUT type="hidden" name="tiene_solapas" value="si">
                            
			 <TD><IMG src="image/solapa_1_<? echo $img_estado ?>.gif" width="2" height="25"></TD>
			 <TD class="BackSolapa<? echo $img_estado ?>"><A href="?tabla=<?  echo $row_rel["tabla"] ?>&include=abm&id=<? echo $id ?>&accion=<? if($accion!=""){ echo $accion; }else{ echo "modificar";} ?>"><? echo $row_rel["nombre"] ?></A></TD>
			 <TD><IMG src="image/solapa_2_<? echo $img_estado ?>.gif" width="1" height="25"></TD>
			 <?		} ## del original
			$result_solapas = mysql_query("SELECT * FROM usuarios_rel_tab t
			LEFT JOIN usuarios_lista_tablas l ON (t.id_solapas_tablas=l.id) 
			WHERE t.id_solapas_tablas = " . $row_rel["id_solapas_tablas"]);
					$img_estado = "off";
			
			if(mysql_num_rows($result_solapas)!=0){
				$row_solapas=mysql_fetch_array($result_solapas);
				
				if($include == $row_solapas["include"]) {$img_estado = "on"; }
			$link = "?tabla=".$tabla."&include=".$row_solapas["include"];
			if($id!=""){$link .="&id=".$id;}
			if($accion=="agregar"){
				$link .="&ejecutar=AGREGAR&accion=agregar";
			}elseif($accion!=""){
				$link .="&accion=" . $accion;
			}else{
				$link .="&accion=modificar" ;
			}
			?>                            
			 <TD><IMG src="image/solapa_1_<? echo $img_estado ?>.gif" width="2" height="25"></TD>
			 <TD class="BackSolapa<? echo $img_estado ?>"><A href="
			 <? if($include=="abm"){ 
			 	echo "javascript:document.formulario_abm.action='".$link."';envio();";
			 }else{ 
			 	echo $link;
			 } 
			 ?>"><? echo $row_solapas["nombre"] ?></A></TD>
			 <TD><IMG src="image/solapa_2_<? echo $img_estado ?>.gif" width="1" height="25"></TD>
			 <?
			} ## fin result_solapas
			
			}
			?>
					
			 <TD><IMG src="image/solapa_end.gif" width="1" height="25"></TD>
		    </TR>
                        
		  </TABLE>
		  <?
			
			} ## fin result_rel
			
			######### FIN SOLAPAS #########
			?>
		  			
                            </TD>
	   </TR>
                  </TABLE></TD>
  </TR>
              
  <TR> 
                
    <TD class="BackVioletWorkFrame"><TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
                    
	   <TR> 
                      
		<TD width="2"><IMG src="image/frame_work_start.gif" width="2" height="33"></TD>
		<TD width="100%" class="BackFrameWork"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                          
		    <TR> 
                            
			 <TD><TABLE width="100" border="0" cellspacing="0" cellpadding="0">
                                
				<TR> 
                                  
				  <TD nowrap>Guardar <? echo $tabla ?></TD>
				  <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
				  <TD><IMG src="image/pipe.gif" width="2"></TD>
				  <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
				  <TD><INPUT name="ejecutar" type="<? if($accion=="agregar"){ echo 'button';}else{ echo 'submit';} ?>" class="BtnGuardarOver" onMouseOver="this.className='BtnGuardarOver';" onMouseOut="this.className='BtnGuardarOff';" value="<? echo strtoupper($accion) ?>" <? if($accion=="agregar"){ echo "onClick='javascript:envio()'";} ?>></TD>
				</TR>
                              </TABLE></TD>
			 <TD>&nbsp;</TD>
		    </TR>
                        </TABLE></TD>
		<TD width="2"><IMG src="image/frame_work_end.gif" width="2" height="33"></TD>
	   </TR>
                  </TABLE></TD>
  </TR>
              
  <TR>
                
    <TD class="BackVioletWorkFrame">&nbsp;</TD>
  </TR>
            
</TABLE>

