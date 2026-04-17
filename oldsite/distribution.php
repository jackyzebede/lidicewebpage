<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Distribution - Lidice Logistics</title>
	<meta name="Description" content="Lidice offers a full range of maritime services to and from all points around the world.">
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
                        <li class="current_page_item"><a href="servicios.php">SERVICIOS</a></li>
                        <li><a href="contacto.php">CONTACTO</a></li>
						<li><a href="livetrack.php">LIVE TRACK</a></li>
                    </ul>
                  </div>
                  <img src="images/map.png" alt="Tu Carga es mi Carga" />
              </div><!--end header-->

              <div id="sidebar">
                  <ul>
                      <li><a href="servicios.php"><span>&raquo;</span> Colon Free Zone Consolidators:</a></li>
                      <li><hr /></li>
                      <li><a href="custom_clearence.php"><span>&raquo;</span> Custom Clearence:</a></li>
                      <li><hr /></li>
                      <li class="current_page_item"><a href="distribution.php"><span>&raquo;</span> 3PL Warehousing / Bonded Warehouse / Distribution</a></li>
                  </ul>

              </div><!--end sidebar-->

              <div id="content">
                  <h1>3PL WAREHOUSING / BONDED WAREHOUSE / DISTRIBUTION</h1>
                  <img class="servicios" src="images/distribution.jpg" alt="distribution" />
                  <p>Strategically located inside the Colon Free Zone and within 5 minutes
                    of most of the major ports, our 3PL facility is equipped to handle
                    diverse inbound freight, and is designed to accommodate large
                    transport vehicles.</p>
                  <p>Ocean Freight Forwarder
                    Ocean shipments is the best method to use for heavy or bulky goods and
                    liquids, were reasonable speed and safety are combined with a relative
                    economical cost.</p>
                   <p>Lidice offers a full range of maritime services to and from all points
                      around the world.</p>
                   <p>Containerized Cargo: 20' , 40', 40'HC, 45'
                      Dry and Reefer Cargo LCL (Less than Container Load)
                      Ro-Ro Services (Roll on - Roll off).
                      Specialized vessel for transportation of rolling equipment as cars,
                      trucks, cranes, etc.</p>
                   <p>Air Freight Service We utilize the world's major commercial airlines, all-cargo carriers,
                      and charters. Our global infrastructure links the Panama with every
                      major trade route worldwide, and provides a comprehensive service to
                      and from all major world markets. </p>
                  
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
