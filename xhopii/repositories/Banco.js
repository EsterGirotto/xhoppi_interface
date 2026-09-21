import { mkdir, readFile, writeFile, rename } from 'node:fs/promises';
import path from 'node:path';
import { MongoClient } from 'mongodb';
import { dadosIniciais } from '../data/inicial.js';

// Uma fila serializa as alterações. No MongoDB, a revisão também protege contra
// outro processo alterando o mesmo documento durante uma compra.
export class Banco {
  constructor({ diretorio, mongoUri = '', database = 'xhopii' }) {
    this.arquivo = path.join(diretorio, 'banco.json');
    this.mongoUri = mongoUri; this.database = database; this.fila = Promise.resolve();
  }
  async iniciar() {
    if (this.mongoUri) {
      this.client = new MongoClient(this.mongoUri, { serverSelectionTimeoutMS: 5000 });
      await this.client.connect();
      this.collection = this.client.db(this.database).collection('estado');
      await this.collection.updateOne({ _id: 'xhopii' }, { $setOnInsert: { revisao: 0, dados: dadosIniciais() } }, { upsert: true });
    } else {
      await mkdir(path.dirname(this.arquivo), { recursive: true });
      try { await readFile(this.arquivo, 'utf8'); }
      catch (erro) { if (erro.code !== 'ENOENT') throw erro; await writeFile(this.arquivo, JSON.stringify(dadosIniciais(), null, 2), { flag: 'wx' }); }
    }
  }
  async ler() {
    return this.collection ? (await this.collection.findOne({ _id: 'xhopii' })).dados : JSON.parse(await readFile(this.arquivo, 'utf8'));
  }
  alterar(operacao) {
    const trabalho = this.fila.then(async () => {
      const documento = this.collection ? await this.collection.findOne({ _id: 'xhopii' }) : null;
      const dados = documento ? documento.dados : await this.ler();
      const resultado = await operacao(dados);
      if (this.collection) {
        const salvo = await this.collection.updateOne({ _id: 'xhopii', revisao: documento.revisao }, { $set: { dados }, $inc: { revisao: 1 } });
        if (!salvo.matchedCount) { const erro = new Error('Os dados mudaram. Tente novamente.'); erro.status = 409; throw erro; }
      } else {
        await writeFile(`${this.arquivo}.tmp`, JSON.stringify(dados, null, 2));
        await rename(`${this.arquivo}.tmp`, this.arquivo);
      }
      return resultado;
    });
    this.fila = trabalho.catch(() => {});
    return trabalho;
  }
  async fechar() { await this.fila; await this.client?.close(); }
}
