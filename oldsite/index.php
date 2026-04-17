<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lidice Logistics</title>
	<meta name="Description" content="Ofrecemos el servicio de cosolidacion de mercancia en la Zona Libre de Colon en Panama.">
	<meta name="keywords" content="lidice, consolidacion, carga, zona libre, distribucion, aduana, container, consolidator, cargo, free zone, distribution, customs">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
                        <li class="current_page_item"><a href="index.php">HOME</a></li>
                        <li><a href="servicios.php">SERVICIOS</a></li>
                        <li><a href="contacto.php">CONTACTO</a></li>
						<li><a href="livetrack.php">LIVE TRACK</a></li>
                    </ul>
                  </div>
                  <img src="images/map.png" alt="Tu Carga es mi Carga" />
              </div><!--end header-->

              <div id="content">
                  <h1><span>LE TRAEMOS TODAS SUS COMPRAS</span> DESDE CUALQUIER PARTE DEL MUNDO!!</h1>
                  <p>Lidice es orgullosamente una empresa 100% panameña que con el buen servicio que nos caracteriza brindamos apoyo a grandes empresas nacionales como internacionales.</p>
                  <p>Lidice is proud to be a Panamanian company that with its great workflow has provided services to national and international clients.</p>
                  <p>Muchos se preguntaran porque tambien ofrecemos servicios maritimos si la via aerea es mas rapida? La simple respuesta es PRECIO. En Lidice Logistics cobramos por el pie cubico, lo que hace que los embarques pesados, numerosos y voluminosos sean preferibles embarcarlos en contenedores.</p>
                  <p>Many will ask themselves why do we also offer sea-freight-forwarding if air transportation is much faster? And the answer is very simple, PRICE. In Lidice Logistics we charge for cubic feet, which makes heavy cargo a good option for sea transportation.</p>
              </div><!--end content-->
              <div id="banner">
                  <div id="item1">
                      <img src="images/img1.png" alt="consolidators" />
                      <h3>CONSOLIDATORS</h3>
                      <p>Ofrecemos el servicio de cosolidaci&oacute;n de mercancia en la Zona Libre de Colon en Panam&aacute;.</p>
                      <a href="servicios.php">MORE &raquo;</a>
                  </div>
                  <div id="item2">
                      <img src="images/img2.png" alt="paperwork" />
                      <h3>PAPERWORK</h3>
                      <p>Nos encargamos de todo el papeleo que sea necesario para el transporte de su carga. Custom clearance.</p>
                      <a href="servicios.php">MORE &raquo;</a>
                  </div>
                  <div id="item3">
                      <img src="images/img3.png" alt="transport" />
                      <h3>TRANSPORT</h3>
                      <p>Le manejamos su carga hasta su <br />destino con la mejor eficiencia<br /> y servicio</p>
                      <a href="servicios.php">MORE &raquo;</a>
                  </div>
              </div>
              <div id="footer">
                  <div id="nav">
                    <ul>
                        <li class="current_page_item"><a href="index.php">Home</a></li>
                        <li><a href="servicios.php">Servicios</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                  </div>
                  <p>&copy; 2013 Lidice. All rights reserved</p>
              </div>
          </div><!--end inner_wrapper-->
      </div> <!--end wrapper-->
  </body>
</html>
