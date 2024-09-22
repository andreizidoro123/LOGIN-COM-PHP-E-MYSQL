function mudarParaRegister() {
    // Seleciona a div com a classe 'trocar'
    var trocarDiv = document.querySelector('.trocar');
    // Seleciona a div com a classe 'formulario'
    var formularioDiv = document.querySelector('.formulario');
    // Seleciona o botão com a classe 'troca'
    var botao = document.querySelector('.troca');

    // Alterna a classe 'right' na div 'trocar'
    trocarDiv.classList.toggle('right');

    // Usa setTimeout para atrasar a mudança do formulário e do título
    setTimeout(function() {
        // Alterna a classe 'right' na div 'formulario'
        formularioDiv.classList.toggle('right');

        // Verifica se a div 'trocar' contém a classe 'right'
        if (trocarDiv.classList.contains('right')) {
            botao.textContent = "LOGIN"; // Altera o texto do botão para "LOGIN"
            document.title = "Registrar"; // Muda o título do site para "Registrar"
            document.getElementById('loginForm').style.display = 'none'; // Esconde o formulário de login
            document.getElementById('registerForm').style.display = 'block'; // Mostra o formulário de registro
        } else {
            botao.textContent = "REGISTRAR"; // Altera o texto do botão para "REGISTRAR"
            document.title = "Login"; // Muda o título do site para "Login"
            document.getElementById('loginForm').style.display = 'block'; // Mostra o formulário de login
            document.getElementById('registerForm').style.display = 'none'; // Esconde o formulário de registro
        }
    }, 225); // Atraso de 225ms
}