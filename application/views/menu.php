<!--<ul class="nav navbar-nav">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Aplicación<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="inicio">Inicio</a></li>
            <li><a href="#" onclick="cargaPagina('administrador')">Administracion</a></li>
            <li><a href="#" onclick="cargaManual('<?php echo base_url(); ?>documentos')" title='Crear Orden de cargue'>Manual usuaro</a></li>
            <li><a href="login/cerrarSession">Salir</a></li>
        </ul>
    </li>

    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Envio de Mensajes<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#" onclick="cargaPagina('cargaexcel')">Enviar por Excel</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Información<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#">Información del cliente</a></li>
            <li><a href="#">Información del trafico Mensual</a></li>
            <li><a href="#">Información del trafico Diario</a></li>
            <li><a href="#">Información del trafico Hoy</a></li>
            <li><a href="#">Descargar Archivo de Mensajes</a></li>
        </ul>
    </li>
    <li></li>

</ul>-->

<ul class="nav navbar-nav">

    <?php
    $menu = $this->session->userdata("menu");
    foreach ($menu as $i => $value) {
        if ($i != "permisos") {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($i) ?><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php
                    foreach ($value as $j => $val) {
                        ?>
                        <li><a href='<?php echo base_url() . $val ?>' ><?php echo ucwords($j) ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <?php
        }
    }
    ?>
</ul>


