<?php
session_start();
$koneksi = mysqli_connect('localhost', 'root', '', 'db_pln');

if ($koneksi) {
    // echo 'Connection => Success';
} else {
    die("Connection failed: " . mysqli_connect_error());
}

function register($name, $email, $password, $role)
{
    global $koneksi;

    // Check if the email already exists in the database
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($koneksi, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        return 'Email is already used.';
    }

    $md5_password = md5($password);
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$md5_password', '$role')";

    if (mysqli_query($koneksi, $query)) {
        return 'Register Berhasil';
    } else {
        return 'Register Gagal';
    }
}

function login($email, $password, $remember)
{
    global $koneksi;

    $md5_password = md5($password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$md5_password'";

    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // User found, return user data
        if ($remember == true) {
            $cookie_expiry = time() + (60 * 60 * 24 * 30); // 30 days
            setcookie('user_email', $email, $cookie_expiry, '/');
            setcookie('user_password', $md5_password, $cookie_expiry, '/');
        } else {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_password'] = $md5_password;
        }
        return 'login berhasil';
    } else {
        // User not found or password incorrect
        logout();
        return 'login gagal';
    }
}

function validation_login($email, $password)
{
    global $koneksi;

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // User found, return user data
        return true;
    } else {
        // User not found or password incorrect
        return false;
    }
}


function check_session()
{
    $message = "";
    if (isset($_COOKIE['user_email']) && isset($_COOKIE['user_password'])) {
        if (validation_login($_COOKIE['user_email'], $_COOKIE['user_password']) == true) {
            $message = 'Session check success';
        } else {
            $message = 'Session check failed';
        }
    } elseif (isset($_SESSION['user_email']) && isset($_SESSION['user_password'])) {
        if (validation_login($_SESSION['user_email'], $_SESSION['user_password']) == true) {
            $message = 'Session check success';
        } else {
            $message = 'Session check failed';
        }
    } else {
        $message = 'Session check failed';
    }
    return $message;
}

function logout()
{
    session_destroy();
    setcookie('user_email', '', time() - 3600, '/');
    setcookie('user_password', '', time() - 3600, '/');
    header('location: /pln/?login');
    return false;
}

function getUnitList()
{
    global $koneksi;

    $query = mysqli_query($koneksi, "SELECT * FROM tbl_unit");

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $dataList = array(); // Initialize an empty array to store the data

            while ($data = mysqli_fetch_assoc($query)) {
                $dataList[] = $data; // Append each row to the data array
            }

            // Encode the array as JSON and output
            echo json_encode($dataList);
        } else {
            echo "No data found.";
        }
    } else {
        echo "Query failed: " . mysqli_error($koneksi);
    }
}

function insertUnit($nama, $tanggal)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "INSERT into tbl_unit(nama,tanggal) VALUES('$nama', '$tanggal')");

    if ($query) {
        echo "Unit Berhasil Ditambahkan!";
        header('refresh:2, url=/pln/?page=master-unit');
        return false;
    } else {
        echo "Unit Gagal Ditambahkan! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-unit');
        return false;
    }
}

function hapusUnit($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "DELETE FROM tbl_unit WHERE id = '$id'");

    if ($query) {
        echo "Unit Berhasil Dihapus!";
        header('refresh:2, url=/pln/?page=master-unit');
        return false;
    } else {
        echo "Unit Gagal Dihapus! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-unit');
        return false;
    }
}

function getSystemListByUnitID($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "SELECT tbl_system.id AS id_system , tbl_unit.id as id_unit , tbl_unit.nama AS nama_unit,  tbl_system.nama AS nama_system
    FROM tbl_system
    JOIN tbl_unit ON tbl_unit.id = tbl_system.id_unit
    WHERE tbl_system.id_unit = '$id'; 
    ");

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $dataList = array(); // Initialize an empty array to store the data

            while ($data = mysqli_fetch_assoc($query)) {
                $dataList[] = $data; // Append each row to the data array
            }

            // Encode the array as JSON and output
            echo json_encode($dataList);
        } else {
            echo "No data found.";
        }
    } else {
        echo "Query failed: " . mysqli_error($koneksi);
    }
}

function insertSystemWithIDUnit($nama, $id_unit)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "INSERT into tbl_system(nama,id_unit) VALUES('$nama', '$id_unit')");

    if ($query) {
        echo "System Berhasil Ditambahkan!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "System Gagal Ditambahkan! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function hapusSystem($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "DELETE FROM tbl_system WHERE id = '$id'");

    if ($query) {
        echo "System Berhasil Dihapus!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "System Gagal Dihapus! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function updateSystemWithID($nama, $id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "UPDATE tbl_system SET nama = '$nama' WHERE id = '$id' ");

    if ($query) {
        echo "System Berhasil Diupdate!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "System Gagal Diupdate! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function getEquipmentListBySystemID($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "SELECT tbl_equipment.id AS id_equipment,
    tbl_equipment.nama AS nama_equipment,
    tbl_system.id AS id_system,
    tbl_system.nama AS nama_system,
    tbl_unit.id AS id_unit,
    tbl_unit.nama AS nama_unit
    FROM tbl_equipment
    JOIN tbl_system ON tbl_system.id = '$id'
    JOIN tbl_unit ON tbl_unit.id = tbl_system.id_unit;
    ");

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $dataList = array(); // Initialize an empty array to store the data

            while ($data = mysqli_fetch_assoc($query)) {
                $dataList[] = $data; // Append each row to the data array
            }

            // Encode the array as JSON and output
            echo json_encode($dataList);
        } else {
            echo "No data found.";
        }
    } else {
        echo "Query failed: " . mysqli_error($koneksi);
    }
}

function insertEquipmentWithIDSystem($nama, $id_system)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "INSERT into tbl_equipment(nama,id_system) VALUES('$nama', '$id_system')");

    if ($query) {
        echo "Equipment Berhasil Ditambahkan!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "Equipment Gagal Ditambahkan! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function hapusEquipment($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "DELETE FROM tbl_equipment WHERE id = '$id'");

    if ($query) {
        echo "Equipment Berhasil Dihapus!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "Equipment Gagal Dihapus! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function updateEquipmentWithID($nama, $id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "UPDATE tbl_equipment SET nama = '$nama' WHERE id = '$id' ");

    if ($query) {
        echo "Equipment Berhasil Diupdate!";
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    } else {
        echo "Equipment Gagal Diupdate! => " . mysqli_error($koneksi);
        header('refresh:2, url=/pln/?page=master-system');
        return false;
    }
}

function showDataWithUnitID($id)
{
    global $koneksi;

    $query = mysqli_query($koneksi, "SELECT 
        tbl_unit.id AS id_unit, 
        tbl_unit.nama AS nama_unit, 
        tbl_unit.tanggal AS date_unit,
        tbl_system.id AS id_system,
        tbl_system.nama AS nama_system,
        tbl_equipment.id AS id_equipment,
        tbl_equipment.nama AS nama_equipment
        FROM tbl_unit
        JOIN tbl_system ON tbl_system.id_unit = tbl_unit.id
        JOIN tbl_equipment ON tbl_equipment.id_system = tbl_system.id
        WHERE tbl_unit.id = '$id'
        ");

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $dataList = array(); // Initialize an empty array to store the data

            while ($data = mysqli_fetch_assoc($query)) {
                $dataList[] = $data; // Append each row to the data array
            }

            // Encode the array as JSON and output
            echo json_encode($dataList);
            http_response_code(200);
        } else {
            echo "No data found.";
            http_response_code(404);
        }
    } else {
        echo "Query failed: " . mysqli_error($koneksi);
        http_response_code(422);
    }
}



if (isset($_GET['action'])) {

    if ($_GET['action'] == 'showDataWithUnitID') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-system');
            http_response_code(421);
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-system');
            http_response_code(422);
            return false;
        }

        showDataWithUnitID($id);
    }


    if ($_GET['action'] == 'updateEquipmentWithID') {
        if (!isset($_POST['nama']) || !isset($_GET['id'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        $nama = $_POST['nama'];
        $id = $_GET['id'];

        if (empty($nama) || empty($id)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        updateEquipmentWithID($nama, $id);
    }

    if ($_GET['action'] == 'hapusEquipment') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        hapusEquipment($id);
    }

    if ($_GET['action'] == 'insertEquipmentWithIDUnit') {
        if (!isset($_POST['nama']) || !isset($_POST['id_unit'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        $nama = $_POST['nama'];
        $id_unit = $_POST['id_unit'];

        if (empty($nama) || empty($id_unit)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        insertEquipmentWithIDSystem($nama, $id_unit);
    }

    if ($_GET['action'] == 'getEquipmentListByUnitID') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-equipment');
            return false;
        }

        getEquipmentListBySystemID($id);
    }

    if ($_GET['action'] == 'updateSystemWithID') {
        if (!isset($_POST['nama']) || !isset($_GET['id'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        $nama = $_POST['nama'];
        $id = $_GET['id'];

        if (empty($nama) || empty($id)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        updateSystemWithID($nama, $id);
    }

    if ($_GET['action'] == 'hapusSystem') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        hapusSystem($id);
    }

    if ($_GET['action'] == 'insertSystemWithIDUnit') {
        if (!isset($_POST['nama']) || !isset($_POST['id_unit'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        $nama = $_POST['nama'];
        $id_unit = $_POST['id_unit'];

        if (empty($nama) || empty($id_unit)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        insertSystemWithIDUnit($nama, $id_unit);
    }

    if ($_GET['action'] == 'getSystemListByUnitID') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-system');
            return false;
        }

        getSystemListByUnitID($id);
    }

    if ($_GET['action'] == 'hapusUnit') {
        if (!isset($_GET['id'])) {
            echo 'id not found';
            header('refresh:2, url=/pln/?page=master-unit');
            return false;
        }

        $id = $_GET['id'];

        if (empty($id)) {
            echo 'id cannot be empty';
            header('refresh:2, url=/pln/?page=master-unit');
            return false;
        }

        hapusUnit($id);
    }


    if ($_GET['action'] == 'insertUnit') {
        if (!isset($_POST['nama']) || !isset($_POST['tanggal'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?page=master-unit');
            return false;
        }

        $nama = $_POST['nama'];
        $tanggal = $_POST['tanggal'];

        if (empty($nama) || empty($tanggal)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?page=master-unit');
            return false;
        }

        insertUnit($nama, $tanggal);
    }

    if ($_GET['action'] == 'getUnitList') {
        getUnitList();
    }

    if ($_GET['action'] == 'check_session') {
        echo check_session();
    }

    if ($_GET['action'] == 'logout') {
        logout();
    }

    if ($_GET['action'] == "login") {

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?login');
            return false;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? $_POST['remember'] : false;

        if (empty($email) || empty($password)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?login');
            return false;
        }

        $message = login($email, $password, $remember);

        if ($message == "login berhasil") {
            echo 'Login success';
            header('refresh:2, url=/pln/?page=dashboard');
            return false;
        } elseif ($message == "login gagal") {
            echo 'Login failed';
            logout();
            header('refresh:2, url=/pln/?login');
            return false;
        } else {
            echo 'Tidak dapat login!';
            logout();
            header('refresh:2, url=/pln/?login');
            return false;
        }
    }

    if ($_GET['action'] == 'register') {

        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['role'])) {
            echo 'invalid field';
            header('refresh:2, url=/pln/?pages=register');
            return false;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($email) || empty($password) || empty($name) || empty($role)) {
            echo 'field cannot be empty';
            header('refresh:2, url=/pln/?pages=register');
            return false;
        }

        $message = register($name, $email, $password, $role);

        if ($message == "Register Berhasil") {
            echo 'Register success';
            header('refresh:2, url=/pln/?login');
            return false;
        } elseif ($message == "Register Gagal") {
            echo 'Register failed';
            header('refresh:2, url=/pln/?pages=register');
            return false;
        } elseif ($message == "Email is already used.") {
            echo 'Register failed email already used.';
            header('refresh:2, url=/pln/?pages=register');
            return false;
        } else {
            echo 'Tidak dapat register!';
            header('refresh:2, url=/pln/?pages=register');
            return false;
        }
    }
}
