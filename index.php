<?php
if (isset($_GET['page'])) {

  if ($_GET['page'] == 'register') {
    include('./views/register.php');
  } elseif ($_GET['page'] == 'login') {
    include('./views/login.php');
  } elseif ($_GET['page'] == 'logout') {
    require('./function.php?action=logout');
  } else {

    include('./layout/header.php');
    if ($_GET['page'] == 'master-unit') {
      include('./views/master_unit.php');
    } elseif ($_GET['page'] == 'master-system') {
      include('./views/master_system.php');
    } elseif ($_GET['page'] == 'master-equipment') {
      include('./views/master_equipment.php');
    } elseif ($_GET['page'] == 'master-details') {
      include('./views/master_details.php');
    } elseif ($_GET['page'] == 'dashboard') {
      include('./views/dashboard.php');
    }
    include('./layout/footer.php');
  }
} elseif (isset($_GET['login'])) {
  include('./views/login.php');
} elseif (isset($_GET['register'])) {
  include('./views/register.php');
} elseif (isset($_GET['logout'])) {
  header('location: /pln/function.php?action=logout');
} else {
  header('location: /pln/?login');;
}
