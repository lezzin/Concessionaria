document.addEventListener("DOMContentLoaded", function () {

    // objetos - funções
    const setaDeVoltaAoTopo = {
        seta: document.querySelector('.toTop'),

        mostrar: function () {
            this.seta.classList.add('show');
        },
        esconder: function () {
            this.seta.classList.remove('show');
        }
    };

    const loader = {
        loader: document.querySelector('.loader'),

        esconder: function () {
            this.loader.classList.add('hide');
            document.body.classList.remove('no-scroll');
        }
    }

    const textarea = {
        textarea: document.querySelector('textarea'),
        maximoDeCaracteres: 150,
        contador: document.querySelector('#textarea_message'),

        atualizarContador: function () {
            let caracteresRestantes = this.maximoDeCaracteres - this.textarea.value.length;

            this.contador.textContent = `${caracteresRestantes} / ${this.maximoDeCaracteres}`;
        },
        iniciar() {
            if (this.textarea) {
                this.atualizarContador();
                // o método bind é utilizado para manter o contexto do objeto
                this.textarea.addEventListener('input', this.atualizarContador.bind(this));
            }
        }
    }

    const alerta = {
        containerAlerta: document.querySelector('#alert'),
        botao: document.querySelector('#alert_button'),

        esconder: function () {
            this.containerAlerta.classList.add('hide');
        },
        iniciar() {
            if (this.containerAlerta) {
                if (this.botao)
                    this.botao.addEventListener('click', this.esconder.bind(this));

                window.addEventListener('click', function (e) {
                    let elementoClicado = e.target,
                        elementoClicadoNaoFoiOAlerta = elementoClicado != this.containerAlerta;

                    if (elementoClicadoNaoFoiOAlerta) this.esconder();
                }.bind(this));
            }
        }
    }

    const visualizacaoImagem = {
        imagemComZoom: document.querySelector('#imageViewer'),
        imagemSemZoom: document.querySelector('#imageToView'),

        mostrar: function () {
            this.imagemComZoom.classList.add('view');
        },
        esconder: function () {
            this.imagemComZoom.classList.remove('view');
        },
        iniciar() {
            if (this.imagemComZoom) {

                window.addEventListener("click", function (e) {

                    let elementoClicado = e.target,
                        imagemSemZoomFoiClicada = elementoClicado == this.imagemSemZoom;

                    if (imagemSemZoomFoiClicada)
                        return this.mostrar();

                    this.esconder();

                }.bind(this));
            }
        }
    }

    const previewPreco = {
        inputPreco: document.querySelector('#price'),

        atualizarPreco: function () {
            let semLetras = /\D/g, // remover letras
                ultimosNumerosComVirgula = /(\d{2})$/g, // pegar os dois últimos números e colocar uma vírgula
                adicionarPonto = /(\d)(?=(\d{3})+(?!\d))/g, // adicionar um ponto a cada 3 números
                precoFormatado = this.inputPreco.value.replace(semLetras, '').replace(ultimosNumerosComVirgula, ',$1').replace(adicionarPonto, '$1.');

            this.inputPreco.value = precoFormatado;
        },
        iniciar() {
            if (this.inputPreco) {
                this.atualizarPreco();
                this.inputPreco.addEventListener('input', this.atualizarPreco.bind(this));
            }
        }
    }

    const informacoesImagem = {
        input: document.querySelector('#imageInput'),
        mensagemDeAlerta: document.querySelector('.bottom .size'),

        mostrarTamanhoDaImagem: function () {

            let tamanhoDaImagemEmMB = (this.input.files[0].size / 1024 / 1024).toFixed(2),
                tamanhoDaImagemMaiorQue2MB = tamanhoDaImagemEmMB > 2;

            this.mensagemDeAlerta.innerHTML = `Tamanho da imagem: ${tamanhoDaImagemEmMB}MB / 2MB`;

            if (tamanhoDaImagemMaiorQue2MB) {
                this.input.value = '';
                this.mensagemDeAlerta.innerHTML = `Tamanho máximo da imagem atingido! - ${tamanhoDaImagemEmMB}MB / 2MB`;
            }

        },
        iniciar() {
            if (this.input)
                this.input.addEventListener('change', this.mostrarTamanhoDaImagem.bind(this));
        }
    }

    const inputPesquisa = {
        input: document.querySelector('#searchCar'),
        cards: document.querySelectorAll('.cars .card'),

        pesquisar: function () {

            let valorDoInput = this.input.value.toLowerCase(),
                containerSemResultados = document.querySelector('.noResults');

            this.cards.forEach(function (card) {
                let nomeDoVeiculo = card.querySelector('.title h2').textContent.toLowerCase(),
                    veiculoFoiPesquisado = nomeDoVeiculo.includes(valorDoInput);

                veiculoFoiPesquisado ? card.classList.remove('hide') : card.classList.add('hide');

                let cardsVisiveis = document.querySelectorAll('.cars .card:not(.hide)'),
                    nenhumCardVisivel = cardsVisiveis.length == 0;

                nenhumCardVisivel ? containerSemResultados.classList.remove('hide') : containerSemResultados.classList.add('hide');

            });
        }, iniciar() {
            if (this.input)
                this.input.addEventListener('input', this.pesquisar.bind(this));
        }
    }

    const pesquisaTabela = {
        input: document.querySelector('#searchInputTable'),
        nomes: document.querySelectorAll('#carsTable tbody tr .carName'),

        pesquisar: function () {
            let valorDoInput = this.input.value.toLowerCase();

            this.nomes.forEach(function (nome) {
                let nomeDoVeiculo = nome.textContent.toLowerCase(),
                    veiculoFoiPesquisado = nomeDoVeiculo.includes(valorDoInput);

                veiculoFoiPesquisado ? nome.parentElement.classList.remove('hide') : nome.parentElement.classList.add('hide');
            });
        },
        iniciar() {
            if (this.input)
                this.input.addEventListener('input', this.pesquisar.bind(this));
        }
    }

    // eventos
    window.addEventListener('load', function () {

        setTimeout(() => { loader.esconder(); }, 500);

        // página admin
        textarea.iniciar();
        alerta.iniciar();
        informacoesImagem.iniciar();
        previewPreco.iniciar();
        pesquisaTabela.iniciar();

        // página carros
        inputPesquisa.iniciar();

        // página carro
        visualizacaoImagem.iniciar();

    });

    window.addEventListener('scroll', function () {
        let scrollSuperiorMaiorQue100 = window.pageYOffset > 100;

        (scrollSuperiorMaiorQue100) ? setaDeVoltaAoTopo.mostrar() : setaDeVoltaAoTopo.esconder();
    });

});