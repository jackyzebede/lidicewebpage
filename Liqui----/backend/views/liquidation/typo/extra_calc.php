<table id='table-with-liq-preparing' border="0" style="">
				<tr class='tbl-titles'>

					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					
					<td><input type='text' style="visibility: hidden; height: 1px;" /></td>
					<td><input type='text' style="visibility: hidden; height: 1px;" /></td>
					<td><input type='text' style="visibility: hidden; height: 1px;" /></td>
					<!-- <td><input type='text' style="visibility: hidden; height: 1px;" /></td> -->
					<td><input type='text' style="visibility: hidden; width: 95px; height: 1px;" /></td>
					<td>
						CIF Total:<br><span id="ciftotal" class="extra_calc_val"></span>
					</td>
					<td>
						FOB:<br><span id="cost" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>
					<td>Insurance:<br><span id="insurance" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>

					<td>Freight:<br><span id="freight" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>
					<td>Tasa:<br><span id="tasa" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>
					<td>Uso de Sistema:<br><span id="uso_sistema" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>
					<td>Imp a pagar:<br><span id="imp_pagar" class="extra_calc_val"></span>
						<input type='text' style="visibility: hidden; height: 1px;" />
					</td>
					<?php
					if (in_array($model->liquidacion_type, [2,4,5]) ) { ?>
					<td><input type='text' style="visibility: hidden; height: 1px;" /></td>
					<?php } ?>
				</tr>
</table>