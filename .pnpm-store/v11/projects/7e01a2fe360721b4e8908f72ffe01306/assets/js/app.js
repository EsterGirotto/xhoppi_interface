document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => {
  if (!window.confirm(form.dataset.confirm)) event.preventDefault();
}));
// Somente comportamento: nenhuma alteração de classes, estilos ou layout.
document.querySelector('[data-logout]')?.addEventListener('click', event => {
  event.preventDefault();
  const form = document.createElement('form');
  form.method = 'post';
  form.action = '/logout';
  const token = document.createElement('input');
  token.type = 'hidden';
  token.name = '_csrf';
  token.value = document.querySelector('meta[name="csrf-token"]').content;
  form.append(token);
  document.body.append(form);
  form.submit();
});
document.querySelectorAll('.conteudo-login-sociais button').forEach(button => button.addEventListener('click', () => {
  window.alert('Login social não configurado nesta demonstração. Use o formulário de login.');
}));
document.querySelector('.conteudo-login-recuperacao a[href="#"]')?.addEventListener('click', event => {
  event.preventDefault();
  window.alert('Login por SMS não configurado nesta demonstração. Use o formulário de login.');
});
document.querySelector('[data-compra]')?.addEventListener('submit', event => {
  event.currentTarget.querySelector('button').disabled = true;
  event.currentTarget.querySelector('[data-status]').textContent = 'Verificando estoque, processando pagamento e preparando envio simulado…';
});
window.addEventListener('pageshow', () => {
  const botao = document.querySelector('[data-compra] button');
  if (botao && !botao.textContent.includes('esgotado')) botao.disabled = false;
});
