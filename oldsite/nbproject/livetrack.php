<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Track & Trace - Lidice Logistics</title>
	<meta name="Description" content="Monitoree el estado de su carga online.">
	<meta name="keywords" content="lidice, consolidacion, carga, zona libre, distribucion, aduana, container, consolidator, cargo, free zone, distribution, customs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-20294278-1']);
_gaq.push(['_setDomainName', '.lidice.net']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type =
'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);
})();

</script>

    <script language="JavaScript" type="text/JavaScript">

    var Hoy = new Date("<?php echo date("d M Y G:i:s");?>");
function Reloj(){
    Hora = Hoy.getHours()
    if (Hora>=1 && Hora <=21){
        Hora_LosAngeles = Hoy.getHours()-1;
        Hora_resto = Hoy.getHours()+2;
    }else if (Hora>=22 && Hora <=23) {
        Hora_LosAngeles = Hoy.getHours()-1;
        Hora_resto = Hoy.getHours() -22;
    } else if (Hora==0){
        Hora_LosAngeles = Hoy.getHours();+23
        Hora_resto = Hoy.getHours() +2;
    }
    Minutos = Hoy.getMinutes()
    Segundos = Hoy.getSeconds()
    if (Hora<=9) Hora = "0" + Hora
    if (Hora_LosAngeles<=9) Hora_LosAngeles = "0" + Hora_LosAngeles
    if (Hora_resto<=9) Hora_resto = "0" + Hora_resto
    if (Minutos<=9) Minutos = "0" + Minutos
    if (Segundos<=9) Segundos = "0" + Segundos

    var Inicio, Script, Final, Total

    Inicio = "<font size=1 color=white>"
    Script = Hora + ":" + Minutos + ":" + Segundos + " Hs."
    Script_LA = Hora_LosAngeles + ":" + Minutos + ":" + Segundos + " Hs."
    Script_Res = Hora_resto + ":" + Minutos + ":" + Segundos + " Hs."
    Final = "</font>"

    HoraServ = Inicio + Script + Final
    HoraLA = Inicio + Script_LA + Final
    HoraRes = Inicio + Script_Res + Final

     //hora del servidor
    document.getElementById('Reloj_serv').innerHTML = HoraServ

    //Hora de Los Angeles
    document.getElementById('Reloj_LA').innerHTML = HoraLA

    //Hora de New York
    document.getElementById('Reloj_NY').innerHTML = HoraRes

    //Hora de Miami
    document.getElementById('Reloj_MIAMI').innerHTML = HoraRes

    //Hora de Panamá
    document.getElementById('Reloj_PA').innerHTML = HoraRes
    Hoy.setSeconds(Hoy.getSeconds() +1)

    setTimeout("Reloj()",1000)
}
</script>

    
  </head>
  <body onload="Reloj()">
      <div id="wrapper">
          <div id="inner_wrapper">
              <div id="header">

                  <div id="Reloj_serv"></div>
                  <div id="Reloj_LA"></div>
                  <div id="Reloj_NY"></div>
                  <div id="Reloj_MIAMI"></div>
                  <div id="Reloj_PA"></div>


                  <a href="index.php" id="logo" ><img src="images/logo.png" alt="Lidice Logistics" /></a>
                  <div id="menu">
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="servicios.php">SERVICIOS</a></li>
                        <li><a href="contacto.php">CONTACTO</a></li>
						<li class="current_page_item"><a href="livetrack.php">LIVE TRACK</a></li>
                    </ul>
                  </div>
                  <img src="images/map.png" alt="Tu Carga es mi Carga" />
              </div><!--end header-->



              <div id="content">
					<table width="100%" height="100%">
						<tr>  
							<td id="WebTrackingHolder">
							 <!-- Here is where the tracking control is displayed -->             
							</td>
						</tr>
					</table>
				  
				  <!-- Load the script and call the function to display the Web LiveTrack control -->
				  <script type="text/javascript" language="javascript" src="http://www.magaya.com/products/livetrack.js"></script>  
				  <script type="text/javascript" language="javascript">
					//
					//DisplayTrackingControl Parameters: object_holder_id, magaya_network_id, width, height, align, border, color index (0-4)
					//
					//You should enter your own Magaya Network ID replacing the 13939 which is a Magaya Corporation Demo Database
					//Color Index are: {0 = classic, 1 =	blue, 2 = green, 3 = gray, 4 = purple}
					//
					DisplayTrackingControl("WebTrackingHolder", "25277", "966px", "422px", "center", "0", "1");
				  </script>
              </div><!--end content-->
              
              <div id="footer">
                  <div id="nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li class="current_page_item"><a href="servicios.php">Servicios</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                  </div>
                  <p>&copy; 2013 Lidice. All rights reserved</p>
              </div>
          </div><!--end inner_wrapper-->
      </div> <!--end wrapper-->
  </body>
</html>
