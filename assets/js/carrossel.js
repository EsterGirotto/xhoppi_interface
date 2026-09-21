document.addEventListener('DOMContentLoaded', function () {
    var carrossel = document.querySelector('[data-carrossel]');

    if (!carrossel) {
        return;
    }

    var slides = Array.from(carrossel.querySelectorAll('.carousel-item'));
    var indicadores = Array.from(carrossel.querySelectorAll('[data-carrossel-indicador]'));
    var atual = 0;
    var intervalo;

    function mostrar(indice) {
        atual = (indice + slides.length) % slides.length;

        slides.forEach(function (slide, posicao) {
            slide.classList.toggle('active', posicao === atual);
        });

        indicadores.forEach(function (indicador, posicao) {
            indicador.classList.toggle('active', posicao === atual);
        });
    }

    function iniciarRotacao() {
        window.clearInterval(intervalo);
        intervalo = window.setInterval(function () {
            mostrar(atual + 1);
        }, 4500);
    }

    carrossel.querySelector('[data-carrossel-anterior]').addEventListener('click', function () {
        mostrar(atual - 1);
        iniciarRotacao();
    });

    carrossel.querySelector('[data-carrossel-proximo]').addEventListener('click', function () {
        mostrar(atual + 1);
        iniciarRotacao();
    });

    indicadores.forEach(function (indicador) {
        indicador.addEventListener('click', function () {
            mostrar(Number(indicador.dataset.carrosselIndicador));
            iniciarRotacao();
        });
    });

    carrossel.addEventListener('mouseenter', function () {
        window.clearInterval(intervalo);
    });

    carrossel.addEventListener('mouseleave', iniciarRotacao);
    iniciarRotacao();
});
