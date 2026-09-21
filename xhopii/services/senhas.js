import { randomBytes, scryptSync, timingSafeEqual } from 'node:crypto';
export function gerarHash(senha) {
  const salt = randomBytes(16).toString('hex');
  return `${salt}:${scryptSync(senha, salt, 64).toString('hex')}`;
}
export function verificarSenha(senha, hash) {
  const [salt, valor] = hash.split(':');
  const atual = scryptSync(senha, salt, 64);
  const esperado = Buffer.from(valor, 'hex');
  return atual.length === esperado.length && timingSafeEqual(atual, esperado);
}
