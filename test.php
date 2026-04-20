<?php
/**
 * Fichier de test de sécurité
 * Accès: http://localhost:8080/test.php
 * 
 * ⚠️ À SUPPRIMER EN PRODUCTION
 */

// ✅ Test de configuration de base
echo "<h1>🧪 Tests de Sécurité</h1>";
echo "<hr>";

// Test 1: PHP Version
echo "<h2>1️⃣  Version PHP</h2>";
echo "Version: <code>" . phpversion() . "</code>";
echo (phpversion() >= "7.2") ? " ✅ OK" : " ❌ ERREUR";
echo "<br><br>";

// Test 2: Extensions requises
echo "<h2>2️⃣  Extensions PHP</h2>";
$extensions = ['mysqli', 'pdo', 'pdo_mysql'];
foreach ($extensions as $ext) {
    echo "$ext: ";
    echo extension_loaded($ext) ? "✅ OK" : "❌ MANQUANTE";
    echo "<br>";
}
echo "<br>";

// Test 3: Fonctions de sécurité
echo "<h2>3️⃣  Fonctions de Sécurité Disponibles</h2>";
$functions = [
    'password_hash' => 'Hachage bcrypt',
    'password_verify' => 'Vérification password',
    'filter_var' => 'Filtrage entrées',
    'htmlspecialchars' => 'Protection XSS'
];
foreach ($functions as $func => $desc) {
    echo "$func ($desc): ";
    echo function_exists($func) ? "✅ OK" : "❌ MANQUANTE";
    echo "<br>";
}
echo "<br>";

// Test 4: Configuration Base de Données
echo "<h2>4️⃣  Configuration Base de Données</h2>";
require_once 'config.php';

echo "Hôte: <code>" . htmlspecialchars(DB_HOST) . "</code><br>";
echo "Base: <code>" . htmlspecialchars(DB_NAME) . "</code><br>";
echo "User: <code>" . htmlspecialchars(DB_USER) . "</code><br>";

try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo "<p style='color: red;'>❌ Erreur connexion: " . htmlspecialchars($mysqli->connect_error) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Connexion BD réussie</p>";
        
        // Vérifier les tables
        echo "<h3>Tables présentes:</h3>";
        $result = $mysqli->query("SHOW TABLES");
        if ($result) {
            echo "<ul>";
            while ($row = $result->fetch_row()) {
                echo "<li>" . htmlspecialchars($row[0]) . "</li>";
            }
            echo "</ul>";
        }
        
        // Compter les utilisateurs
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Utilisateurs: <strong>" . intval($row['count']) . "</strong></p>";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Exception: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br>";

// Test 5: Exemple de password hashing
echo "<h2>5️⃣  Exemple Password Hashing</h2>";
$password = "TestPassword123!";
$hash = password_hash($password, PASSWORD_BCRYPT);
$verify = password_verify($password, $hash);

echo "<p><strong>Password original:</strong> <code>" . htmlspecialchars($password) . "</code></p>";
echo "<p><strong>Hash bcrypt:</strong> <code style='word-break: break-all;'>" . htmlspecialchars($hash) . "</code></p>";
echo "<p><strong>Vérification:</strong> ";
echo $verify ? "✅ OK - Le password correspond au hash" : "❌ ERREUR - Le password ne correspond pas";
echo "</p>";

echo "<br>";

// Test 6: Sécurité des variables
echo "<h2>6️⃣  Test Sécurité GET/POST</h2>";
echo "<form method='post'>";
echo "<input type='text' name='test_input' placeholder='Entrez une valeur'>";
echo "<button type='submit'>Envoyer</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_input'])) {
    $input = $_POST['test_input'];
    $filtered = filter_var($input, FILTER_SANITIZE_STRING);
    $escaped = htmlspecialchars($input);
    
    echo "<p><strong>Input brut:</strong> <code>" . $input . "</code></p>";
    echo "<p><strong>Filtré:</strong> <code>" . $filtered . "</code></p>";
    echo "<p><strong>Échappé (XSS safe):</strong> <code>" . $escaped . "</code></p>";
}

echo "<hr>";
echo "<p style='color: gray; font-size: 0.9em;'>⚠️ Cette page doit être supprimée en production</p>";
?>
