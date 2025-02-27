<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montagem do Componente Carrossel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f5;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #0056b3;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        fieldset {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        legend {
            font-weight: bold;
            color: #0056b3;
        }
        label {
            font-weight: bold;
            font-size: 0.9em;
        }
        input[type="text"], input[type="url"], select, textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004494;
        }
        pre {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            overflow: auto;
        }
    </style>
    <script>
        let quantidadeBotoesGlobal = 1; // Valor padrão
        let quantidadeItensGlobal = 3; // Valor padrão
        let tipoBotaoGlobal = "texto"; // Valor padrão

        function montarJson() {
            const nomeTemplate = document.getElementById('nome-template').value;
            const textoPreBody = document.getElementById('texto-pre-body').value;
            const itens = [];

            for (let i = 1; i <= quantidadeItensGlobal; i++) {
                const bodyItem = document.getElementById(`body-item-${i}`).value;
                const buttons = [];

                for (let j = 1; j <= quantidadeBotoesGlobal; j++) {
                    const botaoTexto = document.getElementById(`botao${j}-texto-${i}`).value;
                    const botaoUrl = tipoBotaoGlobal === "link" ? document.getElementById(`botao${j}-url-${i}`).value : null;

                    if (botaoTexto) {
                        buttons.push({
                            type: tipoBotaoGlobal === "link" ? "url" : "text",
                            text: botaoTexto,
                            ...(tipoBotaoGlobal === "link" && { url: botaoUrl })
                        });
                    }
                }

                itens.push({
                    components: [
                        {
                            type: "header",
                            format: "image",
                            example: {
                                header_handle: [
                                    // Insira o header_handle criado na ResumableAPI
                                ]
                            }
                        },
                        {
                            type: "body",
                            text: bodyItem
                        },
                        {
                            type: "buttons",
                            buttons: buttons.length > 0 ? buttons : [{ type: "text", text: "Botão Padrão" }] // Botão padrão se nenhum for preenchido
                        }
                    ]
                });
            }

            const json = {
                name: nomeTemplate,
                language: "pt_BR",
                category: "marketing",
                components: [
                    {
                        type: "body",
                        text: textoPreBody
                    },
                    {
                        type: "carousel",
                        cards: itens
                    }
                ]
            };

            document.getElementById('resultado').textContent = JSON.stringify(json, null, 4);
        }

        function adicionarItens() {
            const containerItens = document.getElementById('container-itens');
            containerItens.innerHTML = '';

            for (let i = 1; i <= quantidadeItensGlobal; i++) {
                const itemHTML = `
                    <fieldset>
                        <legend>Item ${i}</legend>
                        <label for="body-item-${i}">Texto do Item ${i}:</label>
                        <textarea id="body-item-${i}" rows="4" required></textarea><br>
                        ${gerarCamposBotoes(i)}
                    </fieldset>
                `;
                containerItens.insertAdjacentHTML('beforeend', itemHTML);
            }
        }

        function gerarCamposBotoes(itemIndex) {
            let campos = '';
            for (let j = 1; j <= quantidadeBotoesGlobal; j++) {
                campos += `
                    <label for="botao${j}-texto-${itemIndex}">Texto do Botão ${j}:</label>
                    <input type="text" id="botao${j}-texto-${itemIndex}"><br>
                    ${tipoBotaoGlobal === "link" ? `
                        <label for="botao${j}-url-${itemIndex}">URL do Botão ${j}:</label>
                        <input type="url" id="botao${j}-url-${itemIndex}"><br>
                    ` : ''}
                `;
            }
            return campos;
        }

        function atualizarQuantidadeBotoes() {
            quantidadeBotoesGlobal = parseInt(document.getElementById('quantidade-botoes').value);
            adicionarItens(); // Atualiza os itens com a nova quantidade de botões
        }

        function atualizarQuantidadeItens() {
            quantidadeItensGlobal = parseInt(document.getElementById('quantidade-itens').value);
            adicionarItens(); // Atualiza os itens com a nova quantidade de itens
        }

        function atualizarTipoBotao() {
            tipoBotaoGlobal = document.getElementById('tipo-botao').value;
            adicionarItens(); // Atualiza os itens com o novo tipo de botão
        }

        function copiarResultado() {
            const resultado = document.getElementById('resultado').textContent;
            if (resultado) {
                navigator.clipboard.writeText(resultado).then(() => {
                    alert('JSON copiado para a área de transferência!');
                }).catch(err => {
                    console.error('Erro ao copiar o texto: ', err);
                });
            } else {
                alert('Não há nada para copiar!');
            }
        }

        function limparCampos() {
            document.getElementById('nome-template').value = '';
            document.getElementById('texto-pre-body').value = '';
            document.getElementById('quantidade-botoes').value = '1'; // Valor padrão
            document.getElementById('tipo-botao').value = 'texto'; // Valor padrão
            document.getElementById('quantidade-itens').value = '3'; // Valor padrão
            quantidadeBotoesGlobal = 1; // Resetar a quantidade global de botões
            quantidadeItensGlobal = 3; // Resetar a quantidade global de itens
            tipoBotaoGlobal = "texto"; // Resetar o tipo de botão
            document.getElementById('container-itens').innerHTML = '';
            document.getElementById('resultado').textContent = '';
        }
    </script>
</head>
<body>
    <h1>Montagem do Componente Carrossel</h1>
    <form onsubmit="event.preventDefault(); montarJson();">
        <fieldset>
            <legend>Informações Gerais</legend>
            <label for="nome-template">Nome do Template:</label>
            <input type="text" id="nome-template" required><br>
            <label for="texto-pre-body">Texto do Pré Body:</label>
            <textarea id="texto-pre-body" rows="4" required></textarea><br>
            <label for="quantidade-botoes">Quantidade de Botões:</label>
            <select id="quantidade-botoes" onchange="atualizarQuantidadeBotoes()">
                <option value="1">1 Botão</option>
                <option value="2">2 Botões</option>
            </select><br>
            <label for="tipo-botao">Tipo de Botão:</label>
            <select id="tipo-botao" onchange="atualizarTipoBotao()">
                <option value="texto">Texto</option>
                <option value="link">Link</option>
            </select><br>
            <label for="quantidade-itens">Quantidade de Itens no Carrossel:</label>
            <select id="quantidade-itens" onchange="atualizarQuantidadeItens()">
                <option value="3">3 Itens</option>
                <option value="4">4 Itens</option>
                <option value="5">5 Itens</option>
                <option value="6">6 Itens</option>
                <option value="7">7 Itens</option>
                <option value="8">8 Itens</option>
                <option value="9">9 Itens</option>
                <option value="10">10 Itens</option>
            </select><br>
        </fieldset>

        <div id="container-itens"></div>

        <button type="submit">Montar JSON</button>
        <button type="button" onclick="limparCampos()" style="margin-left: 10px; background-color: #dc3545;">Limpar Campos</button>
    </form>

    <h2>Resultado:</h2>
    <pre id="resultado"></pre>
    <button onclick="copiarResultado()" style="margin-top: 10px; background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Copiar Resultado</button>
</body>
</html>