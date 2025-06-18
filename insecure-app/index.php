<?php
// Insecure PHP App for Vulnerability Testing
// WARNING: This code is intentionally insecure for educational/testing purposes only.

// Database connection (no password, no escaping)
$conn = new mysqli('db', 'root', '', 'testdb');
if ($conn->connect_error) die('DB Connection Failed: ' . $conn->connect_error);

// Simple router
$page = $_GET['page'] ?? 'home';

// VULNERABILITY: Home page (no direct vulnerabilities, navigation only)
function render_home() {
    echo '<h1>Welcome to Insecure App</h1>';
    echo '<a href="?page=login">Login</a> | <a href="?page=register">Register</a> | <a href="?page=upload">Upload</a> | <a href="?page=search">Search</a>';
}

// VULNERABILITY: SQL Injection, Insecure Authentication
function render_login($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        // VULNERABILITY: SQL Injection (user and pass are unsanitized)
        $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            echo 'Logged in as ' . htmlspecialchars($user);
        } else {
            echo 'Login failed.';
        }
    }
    echo '<form method="POST"><input name="username"><input name="password" type="password"><button>Login</button></form>';
}

// VULNERABILITY: SQL Injection, Insecure Authentication
function render_register($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        // VULNERABILITY: SQL Injection (user and pass are unsanitized)
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        $conn->query($sql);
        echo 'Registered!';
    }
    echo '<form method="POST"><input name="username"><input name="password" type="password"><button>Register</button></form>';
}

// VULNERABILITY: Insecure File Upload
function render_upload() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        // VULNERABILITY: No file type check, no path sanitization
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
        echo 'File uploaded!';
    }
    echo '<form method="POST" enctype="multipart/form-data"><input type="file" name="file"><button>Upload</button></form>';
}

// VULNERABILITY: SQL Injection, XSS
function render_search($conn) {
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        // VULNERABILITY: SQL Injection (q is unsanitized)
        // VULNERABILITY: XSS (q is echoed unsanitized)
        $sql = "SELECT * FROM users WHERE username LIKE '%$q%'";
        $res = $conn->query($sql);
        while ($row = $res->fetch_assoc()) {
            echo 'User: ' . $row['username'] . '<br>';
        }
        echo 'Searched for: ' . $q;
    }
    echo '<form><input name="q"><button>Search</button></form>';
}

// VULNERABILITY: Command Injection
function render_cmd() {
    if (isset($_GET['cmd'])) {
        // VULNERABILITY: Command Injection (cmd is unsanitized)
        $out = shell_exec($_GET['cmd']);
        echo '<pre>' . $out . '</pre>';
    }
    echo '<form><input name="cmd"><button>Run Command</button></form>';
}

switch ($page) {
    case 'login': render_login($conn); break;
    case 'register': render_register($conn); break;
    case 'upload': render_upload(); break;
    case 'search': render_search($conn); break;
    case 'cmd': render_cmd(); break;
    default: render_home(); break;
} 