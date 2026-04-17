<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Lidice Logistics</title>
	<meta name="Description" content="Contactenos y dejenos optimizar sus procesos de distribucion.">
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

    var Hoy = new Date("<?php echo date('d M Y G:i:s');?>");
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
                        <li class="current_page_item"><a href="contacto.php">CONTACTO</a></li>
						<li><a href="livetrack.php">LIVE TRACK</a></li>
                    </ul>
                  </div>
                  <img src="images/map.png" alt="Tu Carga es mi Carga" />
              </div><!--end header-->

              <div id="content">
                  <h1>CONTACTO</h1>
                  <div id="left">
                      <div id="cont_foto">
                        <img src="images/foto01.jpg" alt="foto01" />
                      </div>
                      <h2>EN PANAM&Aacute;</h2>
                      <p>Lidice Investment Company<br />
                        Dirección: Colón, Zona Libre de Colón<br />
                        Calle C, Entre Imp. Panamá y Gingi
                      </p>
                      <p>(507)445.2727 - Telefono<br />
                      (507)441.4539 - Fax</p>
                      <p><span>Contacto:</span> Jacky Zebede<br />
                          <span>Email:</span> jacky@lidice.net
                     </p>
                  </div>

                  <div id="right">
                    <h2>EN MIAMI</h2>
                    <p>Lidice Investment- Miami<br />
                     6132 NW 74th. Ave.<br />
                     Miami, FL 33166
                    </p>
                    <p>786-458-8853/54 - Phone<br />
                      786-458-8856 - Fax<br />
					  954-551-4658 - Mobile</p>
                    <p><span>Contacto:</span> Hugo Villanueva<br />
                        <span>Email:</span> hugovillanueva@lidice.net
                    </p>
                  </div>
             </div><!--end content-->
              <div id="footer">
                  <div id="nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li class="current_page_item"><a href="contacto.php">Contacto</a></li>
                    </ul>
                  </div>
                  <p>&copy; 2013 Lidice. All rights reserved</p>
              </div>
          </div><!--end inner_wrapper-->
      </div> <!--end wrapper-->
  </body>
</html>
