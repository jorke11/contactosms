<div class="container">
    <div class="row">
        <ul class="nav nav-tabs">
            <li id="tabempresas" class="active"><a href="#empresas" data-toggle="tab">Empresa</a></li>
            <li id="tabusuarios"><a href="#registro" data-toggle="tab" class="quitaralerta">Registro de Usuarios</a></li>
            <li id="tabcarrier"><a href="#carries" data-toggle="tab" class="quitaralerta">Carriers</a></li>
            <li id="tabservicios"><a href="#servicios" data-toggle="tab" class="quitaralerta">Servicios</a></li>
            <li id="tabcanales"><a href="#canales" data-toggle="tab" class="quitaralerta">Canales</a></li>
            <li id="tabpreferencias"><a href="#preferencias" data-toggle="tab">Preferencias</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane table-responsive-lx active" id="empresas">
                <?php
                
                $this->load->view('administrador/empresas');
                ?>
            </div>
            <div class="tab-pane table-responsive-lx" id="registro">
                <?php
                
                $this->load->view('administrador/usuarios');
                
                ?>
            </div> 
            <div class="tab-pane table-responsive-lx" id="carries">
                <?php
                $this->load->view('administrador/carries');
                ?>
            </div> 
            <div class="tab-pane table-responsive-lx" id="servicios">
                <?php
                $this->load->view('administrador/servicios');
                ?>
            </div> 
            <div class="tab-pane table-responsive-lx" id="canales">
                <?php
                $this->load->view('administrador/canales');
                ?>
            </div> 
            <div class="tab-pane table-responsive-lx" id="preferencias">
                <?php
                $this->load->view('administrador/preferencias');
                ?>
            </div> 
        </div>

    </div>
</div>