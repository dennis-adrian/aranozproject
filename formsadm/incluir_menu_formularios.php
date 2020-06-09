<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
  <a class='navbar-brand' href='index.php'>Principal</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>
  <?php
  require_once('../classes/ctrl_sesion.php');

  use classes\ctrl_sesion\Ctrl_Sesion;

  $nombre_usuario = "";
  $rol_usuario = "";
  if (isset($_SESSION['nombre_usuario'])) {
    $nombre_usuario = Ctrl_Sesion::get_nombre_usuario();
    $rol_usuario = Ctrl_Sesion::get_rol_usuario();
  }
  if ($rol_usuario == 'admin') {
    echo "
    <div class='collapse navbar-collapse' id='navbarNavDropdown'>
    <ul class='navbar-nav'>
      <li class='nav-item active'>
        <a class='nav-link' href='frmproducto.php'>Productos</a>
      </li>
      <li class='nav-item active'>
        <a class='nav-link' href='frmusuario.php'>Clientes</a>
      </li>
      <li class='nav-item active'>
        <a class='nav-link' href='frmventas.php'>Ventas</a>
      </li>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            $nombre_usuario
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
          <a class='dropdown-item' href='#'>Mi cuenta</a>
          <a class='dropdown-item' href='../process/cerrar_sesion.php'>Cerrar session</a>
        </div>
      </li>
    </ul>

  </div>";
  } else {
    echo "
    <div class='collapse navbar-collapse' id='navbarNavDropdown'>
    <ul class='navbar-nav'>
      <li class='nav-item active'>
        <a class='nav-link' href='frmproducto.php'>Productos</a>
    
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <?php 
            $nombre_usuario;
          ?>
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
        <a class='dropdown-item' href='#'>Mi cuenta</a>
        <a class='dropdown-item' href='../process/cerrar_sesion.php'>Cerrar session</a>
        </div>
      </li>
    </ul>

  </div>";
  }
  ?>


</nav>