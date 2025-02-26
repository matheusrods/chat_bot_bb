<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montagem do Componente Call To Action</title>
    <style>
        body {
            font-family: BancoDoBrasil Textos;
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
    <script src="../../lib/js/fontawesome.js"></script>

    <script>
        function montarJson() {
            let body = document.getElementById('body').value;
            body = body.replace(/\n/g, '\\n');
            let headerType = document.getElementById('header-type').value;
            let footerType = document.getElementById('footer-type').value;
            let footerText = document.getElementById('footer-text').value;
            let display_text = document.getElementById('display_text').value;
            let url = document.getElementById('url').value;
            
            let json = {
                "body": body,
                "idTipoComponente": 12,
                "nomeTipoComponente": "CTA URL",
                "action": {
                    "name": "cta_url",
                    "parameters": {
                        "display_text": display_text,
                        "url": url
                    }
                }
            };

            if (headerType !== "none") {
                let header = { "type": headerType };
                if (headerType === "text") {
                    header.value = document.getElementById('header-text').value; 
                } else if (headerType === "image" || headerType === "video" || headerType === "document") {
                    let value = document.getElementById('id-link-value').value;
                    header[headerType] = { "link": value };
                }
                json.header = header;
            }

            if (footerType === "text") {
                json.footer = footerText;
            }

            document.getElementById('resultado').textContent = JSON.stringify(json, null, 4);
            atualizarPreview(json);
        }

        function toggleHeaderOptions() {
            let headerType = document.getElementById('header-type').value;
            document.getElementById('header-text-options').style.display = (headerType === 'text') ? 'block' : 'none';
            document.getElementById('header-media-options').style.display = (headerType === 'image' || headerType === 'video' || headerType === 'document') ? 'block' : 'none';
            let linkLabel = document.getElementById('link-label');
            if (headerType === 'image') {
                linkLabel.textContent = 'Link da imagem:';
            } else if (headerType === 'video') {
                linkLabel.textContent = 'Link do vídeo:';
            } else if (headerType === 'document') {
                linkLabel.textContent = 'Link do documento:';
            }
        }

        function toggleFooterOptions() {
            let footerType = document.getElementById('footer-type').value;
            document.getElementById('footer-text-options').style.display = (footerType === 'text') ? 'block' : 'none';
        }

        function atualizarPreview(json) {
            document.getElementById('preview-header').textContent = json.header ? (json.header.type === 'text' ? json.header.text : `[${json.header.type.charAt(0).toUpperCase() + json.header.type.slice(1)}]`) : '';
            let body = json.body;
            body = body.replace(/\*([^*]+)\*/g, '<strong>$1</strong>');
            body = body.replace(/_([^_]+)_/g, '<em>$1</em>');
            body = body.replace(/\n/g, "<br>");
            body = body.replace(/\\n/g, "<br>");
            document.getElementById('preview-body').innerHTML = "<p>" + body + "</p>";
            document.getElementById('preview-footer').textContent = json.footer ? json.footer : '';
            document.getElementById('preview-link').textContent = json.action.parameters.display_text;
            document.getElementById('preview-link').href = json.action.parameters.url;
            if (json.action.parameters.display_text) {
                document.getElementById('preview-button').style.display = 'flex';
            } else {
                document.getElementById('preview-button').style.display = 'none';
            }
        }
        function copiarResultado() {
            let resultado = document.getElementById('resultado').textContent;
            if (resultado) {
                // Parse o resultado para um objeto e então stringify sem espaços extras
                let resultadoSemEspacosExtras = JSON.stringify(JSON.parse(resultado));
                navigator.clipboard.writeText(resultadoSemEspacosExtras).then(() => {
                    alert('JSON copiado para a área de transferência!');
                }).catch(err => {
                    console.error('Erro ao copiar o texto: ', err);
                });
            } else {
                alert('Não há nada para copiar!');
            }
        }
        function limparCampos() {
            document.getElementById('header-type').value = 'none';
            document.getElementById('header-text').value = '';
            document.getElementById('id-link-value').value = '';
            toggleHeaderOptions(); 

            document.getElementById('body').value = '';

            document.getElementById('footer-type').value = 'none';
            document.getElementById('footer-text').value = '';
            toggleFooterOptions(); 

            document.getElementById('display_text').value = '';
            document.getElementById('url').value = '';

            document.getElementById('resultado').textContent = '';
            document.getElementById('preview-header').textContent = '';
            document.getElementById('preview-body').textContent = '';
            document.getElementById('preview-footer').textContent = '';
            document.getElementById('preview-link').textContent = '';
            document.getElementById('preview-link').href = '#';
            document.getElementById('preview-button').style.display = 'none';
        }
    </script>
</head>
<body>
    <h1>Montagem do Componente Call To Action</h1>
    <p><a href="https://developers.facebook.com/docs/whatsapp/cloud-api/messages/interactive-cta-url-messages/" target="_blank">Documentação do Componente</a></p>
    <form onsubmit="event.preventDefault(); montarJson();">
        <fieldset>
            <legend>Cabeçalho (Header)</legend>
            <label for="header-type">Tipo de Cabeçalho:</label>
            <select id="header-type" onchange="toggleHeaderOptions()">
                <option value="none">Nenhum</option>
                <option value="text">Texto</option>
                <option value="image">Imagem</option>
                <option value="video">Vídeo</option>
                <option value="document">Documento</option>
            </select><br>

            <div id="header-text-options" style="display: none;">
                <label for="header-text">Texto do cabeçalho:</label>
                <input type="text" id="header-text" maxlength="60" title="Máx. caracteres: 60"><br>
            </div>

            <div id="header-media-options" style="display: none;">
                <label id="link-label" for="id-link-value">Link da imagem:</label>
                <input type="url" id="id-link-value"><br>
            </div>
        </fieldset>

        <fieldset>
            <legend>Corpo (Body)</legend>
            <label for="body">Corpo da Mensagem:</label>
            <textarea id="body" rows="4" maxlength="1024" required title="Máx. caracteres: 1024"></textarea><br>
        </fieldset>

        <fieldset>
            <legend>Rodapé (Footer)</legend>
            <label for="footer-type">Tipo de Rodapé:</label>
            <select id="footer-type" onchange="toggleFooterOptions()">
                <option value="none">Nenhum</option>
                <option value="text">Texto</option>
            </select><br>

            <div id="footer-text-options" style="display: none;">
                <label for="footer-text">Texto do rodapé:</label>
                <input type="text" id="footer-text" maxlength="60" title="Máx. caracteres: 60"><br>
            </div>
        </fieldset>

        <fieldset>
            <legend>Botão de ação (CTA)</legend>
            <label for="display_text">Texto do botão:</label>
            <input type="text" id="display_text" maxlength="20" required title="Máx. caracteres: 20"><br>

            <label for="url">Link do botão:</label>
            <input type="url" id="url" required><br>
        </fieldset>

        <button type="submit">Montar JSON</button>
        <button type="button" onclick="limparCampos()" style="margin-left: 10px; background-color: #dc3545;">Limpar Campos</button>
    </form>

    <h2>Resultado:</h2>
    <pre id="resultado"></pre>
    <button onclick="copiarResultado()" style="margin-top: 10px; background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Copiar Resultado</button>
    <h2>Pré-visualização do componente:</h2>
    <p style="color: #777; font-size: 12px;">Obs: A pré-visualização visa facilitar a identificação da disposição dos itens, mas não corresponde com exatidão ao componente real do WhatsApp</p>
    <div id="preview" style="background-color: #ffffff; padding: 15px; border-radius: 10px; margin-top: 20px; max-width: 350px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); font-family: BancoDoBrasil Textos; position: relative; border: 1px solid #e0e0e0;">
        <div style="position: absolute; left: -10px; top: 20px; width: 0; height: 0; border-top: 10px solid transparent; border-bottom: 10px solid transparent; border-right: 10px solid #ffffff;"></div>
        <div id="preview-header" style="font-weight: bold; margin-bottom: 5px; color: #075e54; font-size: 14px;"></div>
        <div id="preview-body" style="margin-bottom: 5px; font-size: 16px; line-height: 1.4;"></div>
        <div id="preview-footer" style="margin-top: 5px; color: #999; font-size: 12px;"></div>
        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <div id="preview-button" style="margin-top: 15px; display: none; justify-content:center">
            <i class="fa-solid fa-arrow-up-right-from-square" style="color: #34b7f1;margin-right: 8px"></i>
            <a href="#" id="preview-link" style="display: inline-flex; align-items: center; color: #34b7f1; font-weight: bold; font-size: 14px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px; margin-right: 5px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span>Ação</span>
            </a>
        </div>
    </div>
</body>
</html>
