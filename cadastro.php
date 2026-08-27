<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Tech - Início & Cadastro</title>
    <style>
        /* 🎨 PALETA DE CORES AJUSTADA (OPÇÃO 1: ROXO TECNOLÓGICO / DARK MODE) */
        :root {
            --bg-principal: #09090d;
            /* Fundo geral da página */
            --bg-card: #13131a;
            /* Fundo do formulário */
            --roxo-neon: #a046ff;
            /* Roxo mais claro e vivo para melhor contraste */
            --roxo-botao: #8a2be2;
            /* Roxo sólido para botões */
            --roxo-hover: #6a1b9a;
            /* Roxo ao passar o mouse */
            --texto-claro: #ffffff;
            /* Títulos e textos principais */
            --texto-mutado: #b3b3c2;
            /* AJUSTE: Cinza mais claro para leitura perfeita */
            --borda: #222232;
            /* Linhas divisórias */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-principal);
            color: var(--texto-claro);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* BARRA DE NAVEGAÇÃO */
        nav {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--borda);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            font-size: 22px;
            font-weight: bold;
            color: var(--roxo-neon);
            letter-spacing: 1px;
        }

        nav .link-login {
            color: var(--texto-claro);
            text-decoration: none;
            font-size: 14px;
            border: 1px solid var(--roxo-neon);
            padding: 8px 16px;
            border-radius: 4px;
            transition: 0.3s;
        }

        nav .link-login:hover {
            background-color: var(--roxo-neon);
        }

        /* CONTEÚDO PRINCIPAL (HERO) */
        .hero {
            text-align: center;
            padding: 60px 20px 20px 20px;
            max-width: 850px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .hero h1 span {
            color: var(--roxo-neon);
        }

        /* AJUSTE 1: Texto maior e com cor mais clara para não sumir no fundo preto */
        .hero p {
            color: var(--texto-mutado);
            font-size: 19px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* CONTAINER DO FORMULÁRIO */
        .container-cadastro {
            max-width: 550px;
            background-color: var(--bg-card);
            border: 1px solid var(--borda);
            border-radius: 12px;
            padding: 40px;
            margin: 0 auto 60px auto;
            box-shadow: 0 10px 40px rgba(138, 43, 226, 0.08);
        }

        .container-cadastro h2 {
            margin-top: 0;
            color: var(--texto-claro);
            font-size: 24px;
            margin-bottom: 5px;
        }

        .container-cadastro .instrucao {
            color: var(--texto-mutado);
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* AJUSTE 2: Títulos das seções com contraste alto e sem fundos escuros apagados */
        h3 {
            color: var(--roxo-neon);
            font-size: 15px;
            border-bottom: 1px solid var(--roxo-neon);
            padding-bottom: 6px;
            margin-top: 30px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .grupo-campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--texto-claro);
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            background-color: var(--bg-principal);
            border: 1px solid var(--borda);
            border-radius: 6px;
            color: var(--texto-claro);
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--roxo-neon);
            box-shadow: 0 0 5px rgba(138, 43, 226, 0.3);
        }

        ::placeholder {
            color: #555566;
        }

        .linha-dupla {
            display: flex;
            gap: 15px;
        }

        .linha-dupla .grupo-campo {
            flex: 1;
        }

        /* AJUSTE 3: Margem aumentada no botão para dar respiro visual no final */
        button {
            width: 100%;
            padding: 14px;
            background-color: var(--roxo-botao);
            color: var(--texto-claro);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 35px;
        }

        button:hover {
            background-color: var(--roxo-hover);
        }
    </style>
</head>

<body>

    <!-- NAV BAR -->
    <nav>
        <div class="logo">Gym Tech</div>
        <a href="#" class="link-login">Área Restrita (Login)</a>
    </nav>

    <!-- SEÇÃO INICIAL OPERACIONAL -->
    <section class="hero">
        <h1>Gestão Digital Inteligente para <span>Sua Saúde</span></h1>
        <p>Painel administrativo para controle de matrículas, gerenciamento de alunos e monitoramento de desempenho da plataforma.</p>
    </section>

    <!-- FORMULÁRIO DE CADASTRO -->
    <div class="container-cadastro">
        <h2>Cadastrar Novo Aluno</h2>
        <div class="instrucao">Preencha todos os campos obrigatórios (*) para validar o plano.</div>

        <form action="cadastroAction.php" method="POST">

            <h3>1. Credenciais de Acesso</h3>
            <div class="grupo-campo">
                <label>Nome Completo *</label>
                <input type="text" name="nome" required placeholder="Nome do matriculado">
            </div>

            <div class="grupo-campo">
                <label>E-mail Corporativo ou Pessoal *</label>
                <input type="email" name="email" required placeholder="nome@provedor.com">
            </div>

            <div class="linha-dupla">
                <div class="grupo-campo">
                    <label>Senha Provisória *</label>
                    <input type="password" name="senha" required placeholder="Senha de acesso">
                </div>
                <div class="grupo-campo">
                    <label>Telefone Residencial</label>
                    <input type="text" name="telefone" placeholder="(00) 0000-0000">
                </div>
            </div>

            <h3>2. Ficha de Matrícula</h3>
            <div class="linha-dupla">
                <div class="grupo-campo">
                    <label>Data de Nascimento *</label>
                    <input type="date" name="data_nascimento" required>
                </div>
                <div class="grupo-campo">
                    <label>CPF *</label>
                    <input type="text" id="campo-cpf" name="cpf" placeholder="000.000.000-00" required>
                </div>
            </div>

            <div class="grupo-campo">
                <label>Endereço Residencial Completo</label>
                <input type="text" name="endereco" placeholder="Rua, Número, Bloco, Bairro">
            </div>

            <div class="grupo-campo">
                <label>Objetivo com os Treinos</label>
                <input type="text" name="objetivo" placeholder="Ex: Hipertrofia, Redução de Percentual de Gordura">
            </div>

            <div class="linha-dupla">
                <div class="grupo-campo">
                    <label>Plano Vinculado *</label>
                    <select name="plano" required>
                        <option value="">Escolha um plano...</option>
                        <option value="Mensal">Plano Mensal</option>
                        <option value="Trimestral">Plano Trimestral</option>
                        <option value="Anual">Plano Anual</option>
                    </select>
                </div>
                <div class="grupo-campo">
                    <label>Peso Corporal Inicial (kg)</label>
                    <input type="number" step="0.01" name="peso_atual" placeholder="00.00">
                </div>
            </div>

            <div class="grupo-campo">
                <label>Celular / WhatsApp</label>
                <input type="text" name="celular" placeholder="(00) 00000-0000">
            </div>

            <button type="submit">Efetivar Matrícula no Sistema</button>
        </form>
    </div>

    <!-- JAVASCRIPT DE FORMATAÇÃO AUTOMÁTICA DE CPF -->
    <script>
        const inputCpf = document.getElementById('campo-cpf');
        inputCpf.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, "");
            if (valor.length > 11) valor = valor.slice(0, 11);

            if (valor.length > 9) {
                valor = valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");
            } else if (valor.length > 6) {
                valor = valor.replace(/^(\d{3})(\d{3})(\d{3})$/, "$1.$2.$3");
            } else if (valor.length > 3) {
                valor = valor.replace(/^(\d{3})(\d{3})$/, "$1.$2");
            }
            e.target.value = valor;
        });
    </script>

</body>

</html>