<?php
session_start();
$resultado = "";
$historico = $_SESSION['historico'] ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST['num1'] ?? "";
    $num2 = $_POST['num2'] ?? "";
    $operacao = $_POST['operacao'] ?? "+";

    if (!is_numeric($num1) || !is_numeric($num2)) {
        $resultado = "Erro: valores inválidos.";
    } else {
        switch ($operacao) {
            case "+": $resultado = $num1 + $num2; break;
            case "-": $resultado = $num1 - $num2; break;
            case "*": $resultado = $num1 * $num2; break;
            case "/":
                $resultado = ($num2 == 0) ? "Erro: divisão por zero." : $num1 / $num2;
                break;
            default:
                $resultado = "Operação inválida.";
        }

        $registro = "$num1 $operacao $num2 = $resultado";
        $historico = $_SESSION['historico'] ?? [];
        array_unshift($historico, $registro);
        $historico = array_slice($historico, 0, 5);
        $_SESSION['historico'] = $historico;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .container {
            background: #1c1c2b;
            padding: 30;
            border-radius: 15px;
            width: 320px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            animation:  slideIn 0.6s ease;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00ffd5;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #00c896;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #00a57c;
            transform: scale(1.03);
        }

        .resultado {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            background-color: #2e2e4f;
            padding: 10px;
            border-radius: 5px;
        }
        .historico {
            margin-top: 25px;
        }
        .historico h3 {
            font-size: 1em;
            margin-bottom: 10px;
            color: #ccc;
        }

        .historico ul {
            list-style: none;
            padding-left: 0;
        }
        .historico li {
            background: #2a2a3d;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 5px;
            font-size: 0.95em;
        }

        footer {
            text-align: center;
            font-size: 0.8em;
            margin-top: 20px;
            color: #999;
        }
        @keyframes slideIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
        </style>
</head>
<body>
    <div class="container">
        <h2>🧮 Calculadora Web</h2>
        <form method="POST" id="calcForm">
            <input type="numer" name="num1" id="num1" placeholder="Primeiro número" required>
            <select name="operacao" id="operacao">
                <option value="+">Adição (+)</option>
                <option value="-">Subtração (-)</option>
                <option value="*">Multipliação (*)</option>
                <option value="/">Divisão (/)</option>
            </select>
            <input type="number" name="num2" id="num2" placeholder="Segundo número" required>
            <button type="submit" class="btn">Calcular</button>
    </form>

    <?php if ($resultado !== ""): ?>
        <div class="resultado">Resultado: <?= htmlspecialchars($resultado) ?></div>
    <?php endif; ?>

    <?php if (!empty($historico)): ?>
        <div class="historico">
            <h3>📝 Últimos Cáculos:</h3>
            <ul>
                <?php foreach ($historico as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
                </div>
                <?php endif; ?>

                <footer>© <?= date("Y") ?> Calculadora Avançada</footer>
                </div>

                <script>
                    document.getElementById("calcForm").addEventListener("submit", function (e) {
                        const n1 = document.getElementById("num1").value.trim();
                        const n2 = document.getElementById("num2").value.trim();
                        if (n1 === "" || n2 === "") {
                            e.preventDefault();
                            alert("Por favor, preencha ambos os campos.");
                        } else if (isNaN(n1) || isNaN(n2)) {
                            e.preventDefault();
                             alert("Insira apenas valores númericos válidos.");
                        }
                    });
                    </script>
                    </body>
                    </html>