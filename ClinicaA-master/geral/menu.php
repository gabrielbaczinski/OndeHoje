<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- menu.php -->

	<!-- Top -->
	<div class="w3-top"> 
		<div class="w3-bar w3-theme w3-large" style="z-index:-1; background-color: rgb(28,28,28) !important;">
			<a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-light-gray w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">☰</a>
			<a href="."><img src='/ClinicaA-master/Imagens/Logo.jpg' alt="Logo" width="45" style="margin-top: 5px;"></a>
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-light-gray w3-padding-16" href="medListar.php" onclick="w3_show_nav('menuMedico')">Onde Hoje</a>
        </div>
	</div>



	<!-- Sidebar -->
	<div class="w3-sidebar w3-bar-block w3-collapse w3-animate-left" style="z-index:3;width:270px;" id="mySidebar" >
		<div class="w3-bar w3-hide-large w3-large">
			<a href="javascript:void(0)" onclick="w3_show_nav('menuMedico')"
			   class="w3-bar-item w3-button w3-theme w3-hover-light-gray w3-padding-16" style="width:50%">Médicos</a>
		</div>
		<a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-right w3-xlarge w3-hide-large"
		   title="Close Menu">x</a>
		<div id="menuMedico" class="myMenu">
			<div class="w3-container">
				<h3>Eventos</h3>
			</div>
			<a class="w3-bar-item w3-button" href="medListar.php">Eventos ativos</a>
			<a class="w3-bar-item w3-button" href="medIncluir.php">Cadastro de Eventos</a>
		</div>
	</div>
	<script type="text/javascript" src="js/myScriptClinic.js"></script>
